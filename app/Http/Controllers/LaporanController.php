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

        // Get violation rule to calculate incentive fee
        $violationRule = \App\Models\ViolationRule::findOrFail($request->violation_article_id);
        $incentiveFee = $violationRule->fine_amount * 0.10;

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
        $report->report_fee = $incentiveFee;
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

    /**
     * Tampilkan halaman verifikasi untuk Polantas
     */
    public function verification(Request $request)
    {
        $query = Report::with(['reporter', 'violationRule'])
            ->whereIn('status', ['menunggu_verifikasi', 'diterima', 'ditolak']);

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

        return view('laporan.verifikasi', compact('reports'));
    }

    /**
     * Approve laporan
     */
    public function approve($id)
    {
        $report = Report::with(['reporter'])->findOrFail($id);
        
        // Use stored report fee as incentive
        $incentive = $report->report_fee;
        
        // Update report status
        $report->update([
            'status' => 'diterima',
            'verified_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        // Add incentive to reporter's balance
        $reporter = $report->reporter;
        $reporter->balance = ($reporter->balance ?? 0) + $incentive;
        $reporter->save();

        return redirect()->route('laporan.verifikasi')
            ->with('success', 'Laporan berhasil disetujui. Insentif Rp ' . number_format($incentive, 0, ',', '.') . ' telah ditambahkan ke saldo pelapor.');
    }

    /**
     * Reject laporan
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $report = Report::findOrFail($id);
        
        $report->update([
            'status' => 'ditolak',
            'rejection_reason' => $request->rejection_reason,
            'verified_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('laporan.verifikasi')
            ->with('success', 'Laporan berhasil ditolak.');
    }

    /**
     * Show detail laporan for Polantas
     */
    public function detail($id)
    {
        $report = Report::with(['reporter', 'violationRule', 'verifier'])
            ->findOrFail($id);

        return view('laporan.detail-verifikasi', compact('report'));
    }
}
