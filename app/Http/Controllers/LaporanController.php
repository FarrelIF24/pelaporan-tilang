<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ViolationRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * Tampilkan form untuk input laporan pelanggaran baru
     */
    public function create()
    {
        $violationRules = ViolationRule::all();
        return view('laporan.laporkan', compact('violationRules'));
    }

    /**
     * Simpan laporan pelanggaran baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'license_plate' => 'required|string|max:20',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'violation_article_id' => 'required|exists:violation_rules,id',
            'location' => 'required|string|max:255',
            'violation_date' => 'required|date',
        ]);

        // Upload foto
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('violations', 'public');
        }

        // Simpan laporan
        $report = new Report();
        $report->reporter_id = Auth::id();
        $report->license_plate = $request->license_plate;
        $report->photo_url = $photoPath;
        $report->violation_article_id = $request->violation_article_id;
        $report->location = $request->location;
        $report->violation_date = $request->violation_date;
        $report->status = 'menunggu_verifikasi';
        $report->created_by = Auth::id();
        $report->save();

        return redirect()->route('laporan.riwayat')
            ->with('success', 'Laporan pelanggaran berhasil disimpan dan menunggu verifikasi.');
    }

    /**
     * Tampilkan riwayat laporan user
     */
    public function history(Request $request)
    {
        $query = Report::where('reporter_id', Auth::id())
            ->with(['violationRule', 'verifier']);

        // Filter by status if provided
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Get per page value from request, default to 10
        $perPage = $request->get('per_page', 10);
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $reports = $query->latest()->paginate($perPage);
        
        // Append query parameters to pagination links
        $reports->appends($request->query());

        return view('laporan.riwayat', compact('reports'));
    }

    /**
     * Tampilkan detail laporan
     */
    public function show($id)
    {
        $report = Report::where('id', $id)
            ->where('reporter_id', Auth::id())
            ->with(['violationRule', 'verifier'])
            ->firstOrFail();

        return view('laporan.detail', compact('report'));
    }
}
