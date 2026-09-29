<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    private function checkAdmin()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Halaman ini hanya dapat diakses oleh Admin Sistem.');
        }
    }

    /**
     * Display a listing of system activity logs.
     */
    public function index(Request $request)
    {
        $this->checkAdmin();

        $query = ActivityLog::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.logs.index', compact('logs'));
    }

    /**
     * Clear old activity logs.
     */
    public function clear()
    {
        $this->checkAdmin();

        ActivityLog::truncate();

        return redirect()->route('logs.index')
            ->with('success', 'Seluruh riwayat log aktivitas berhasil dibersihkan.');
    }
}
