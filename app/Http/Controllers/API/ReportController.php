<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ViolationRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    /**
     * Display a listing of reports based on user role.
     * For Pelapor: Only shows their reports
     * For Polantas: Shows all reports
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Report::with(['reporter', 'violationRule', 'verifier']);
        
        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Pelapor can only see their own reports
        if ($user->isPelapor()) {
            $query->where('reporter_id', $user->id);
        }
        
        $reports = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return response()->json([
            'success' => true,
            'data' => $reports
        ]);
    }

    /**
     * Store a newly created report.
     * Only accessible to Pelapor users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'license_plate' => 'required|string|max:20',
            'photo' => 'required|image|max:2048', // max 2MB
            'violation_article_id' => 'required|exists:violation_rules,id',
            'location' => 'required|string|max:255',
            'violation_date' => 'required|date|before_or_equal:today',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $user = Auth::user();
        
        // Handle file upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('violations', 'public');
        }
        
        $report = new Report([
            'reporter_id' => $user->id,
            'license_plate' => $request->license_plate,
            'photo_url' => $photoPath,
            'violation_article_id' => $request->violation_article_id,
            'location' => $request->location,
            'violation_date' => $request->violation_date,
            'status' => 'menunggu_verifikasi',
            'created_by' => $user->id
        ]);
        
        $report->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Report submitted successfully',
            'data' => $report
        ], 201);
    }

    /**
     * Display the specified report.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $report = Report::with(['reporter', 'violationRule', 'verifier'])->find($id);
        
        if (!$report) {
            return response()->json([
                'success' => false,
                'message' => 'Report not found'
            ], 404);
        }
        
        $user = Auth::user();
        
        // Pelapor can only view their own reports
        if ($user->isPelapor() && $report->reporter_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view this report'
            ], 403);
        }
        
        return response()->json([
            'success' => true,
            'data' => $report
        ]);
    }
    
    /**
     * Verify a report (approve or reject).
     * Only accessible to Polantas users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:diterima,ditolak',
            'rejection_reason' => 'required_if:status,ditolak|nullable|string',
            'report_fee' => 'required_if:status,diterima|nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $report = Report::find($id);
        
        if (!$report) {
            return response()->json([
                'success' => false,
                'message' => 'Report not found'
            ], 404);
        }
        
        // Check if report is already verified
        if ($report->status !== 'menunggu_verifikasi') {
            return response()->json([
                'success' => false,
                'message' => 'Report has already been verified'
            ], 400);
        }
        
        $user = Auth::user();
        
        $report->status = $request->status;
        $report->verified_by = $user->id;
        $report->updated_by = $user->id;
        
        if ($request->status === 'diterima') {
            $report->report_fee = $request->report_fee;
            $report->rejection_reason = null;
        } else {
            $report->rejection_reason = $request->rejection_reason;
            $report->report_fee = null;
        }
        
        $report->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Report has been ' . ($request->status === 'diterima' ? 'approved' : 'rejected'),
            'data' => $report
        ]);
    }
    
    /**
     * Get report statistics.
     * For Polantas: Shows overall statistics
     * For Pelapor: Shows their personal statistics
     *
     * @return \Illuminate\Http\Response
     */
    public function statistics()
    {
        $user = Auth::user();
        $query = Report::query();
        
        // Pelapor can only see stats for their own reports
        if ($user->isPelapor()) {
            $query->where('reporter_id', $user->id);
        }
        
        $total = $query->count();
        $pending = $query->where('status', 'menunggu_verifikasi')->count();
        $approved = $query->where('status', 'diterima')->count();
        $rejected = $query->where('status', 'ditolak')->count();
        
        // For Polantas only - most common violations
        $commonViolations = [];
        if ($user->isPolantas()) {
            $commonViolations = Report::where('status', 'diterima')
                ->select('violation_article_id')
                ->selectRaw('count(*) as count')
                ->groupBy('violation_article_id')
                ->orderByDesc('count')
                ->limit(5)
                ->with('violationRule')
                ->get();
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'total' => $total,
                'pending' => $pending,
                'approved' => $approved,
                'rejected' => $rejected,
                'common_violations' => $commonViolations
            ]
        ]);
    }
}
