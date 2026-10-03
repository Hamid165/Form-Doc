<?php

namespace App\Http\Controllers\FormBastik;

use App\Http\Controllers\Controller;
use App\Models\FormBastik\FormBastik;
use App\Models\FormBastik\FormBastikItem;
use App\Models\FormBastik\FormBastikLampiran;
use App\Models\FormBastik\ApprovalHistory;
use App\Models\FormCctv\MasterSigner;
use App\Models\FormBastik\NomorSuratCounter;
use App\Models\FormBastik\QrValidationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\IOFactory;

class FormBastikController extends Controller
{   
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentUser = auth()->user();
        $query = FormBastik::with(['petugas', 'pimpinan']);

        // Role-based scope filtering for document listing
        if ($currentUser) {
            if ($currentUser->role === 'petugas') {
                $query->where('petugas_id', $currentUser->id);
            } elseif ($currentUser->role === 'pimpinan') {
                $query->where(function ($q) use ($currentUser) {
                    $q->where('approved_by', $currentUser->id)
                      ->orWhereHas('pimpinan', function ($sq) use ($currentUser) {
                          $sq->where('nipp', $currentUser->nip_kwt)
                             ->orWhere('nama', $currentUser->name);
                      });
                });
            }
            // Admin role sees all documents
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('kota', 'like', "%{$search}%")
                  ->orWhere('business_area', 'like', "%{$search}%")
                  ->orWhereHas('petugas', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('form-bastik.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Auto-populate petugas based on current simulated session user
        $currentUser = auth()->user() ?? \App\Models\User::where('role', 'petugas')->first();
        $signers = MasterSigner::all();

        return view('form-bastik.create', compact('currentUser', 'signers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pimpinan_id' => 'required|exists:master_signers,id',
            'tanggal_surat' => 'required|date',
            'kota' => 'required|string|max:50',
            'business_area' => 'required|string|max:100',
            'items' => 'required|array|min:1',
            'items.*.no_tiket' => 'required|string|max:30',
            'items.*.detail_tiket' => 'required|string',
            'items.*.user_pemohon' => 'required|string|max:150',
            'items.*.nipp' => 'required|string|max:30',
            'items.*.unit' => 'required|string|max:100',
            'items.*.lampiran_1' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx',
                'max:10240',
            ],

            'items.*.lampiran_2' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx',
                'max:10240',
            ],

            'items.*.lampiran_3' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx',
                'max:10240',
            ],

            'action' => 'required|in:draft,generate',
            
        ], [
            'items.*.lampiran_1.uploaded' =>
                'Lampiran konfirmasi ke-1 gagal diunggah oleh server. Pastikan ukuran file maksimal 10 MB dan coba unggah kembali.',

            'items.*.lampiran_1.file' =>
                'Lampiran konfirmasi ke-1 harus berupa file.',

            'items.*.lampiran_1.mimes' =>
                'Lampiran konfirmasi ke-1 hanya boleh berformat JPG, JPEG, PNG, PDF, DOC, atau DOCX.',

            'items.*.lampiran_1.max' =>
                'Lampiran konfirmasi ke-1 maksimal berukuran 10 MB.',

            'items.*.lampiran_2.uploaded' =>
                'Lampiran konfirmasi ke-2 gagal diunggah oleh server. Pastikan ukuran file maksimal 10 MB dan coba unggah kembali.',    
            
                'items.*.lampiran_2.file' =>
                'Lampiran konfirmasi ke-2 harus berupa file.',

            'items.*.lampiran_2.mimes' =>
                'Lampiran konfirmasi ke-2 hanya boleh berformat JPG, JPEG, PNG, PDF, DOC, atau DOCX.',

            'items.*.lampiran_2.max' =>
                'Lampiran konfirmasi ke-2 maksimal berukuran 10 MB.',

            'items.*.lampiran_3.uploaded' =>
                'Lampiran konfirmasi ke-3 gagal diunggah oleh server. Pastikan ukuran file maksimal 10 MB dan coba unggah kembali.',

            'items.*.lampiran_3.file' =>
                'Lampiran konfirmasi ke-3 harus berupa file.',

            'items.*.lampiran_3.mimes' =>
                'Lampiran konfirmasi ke-3 hanya boleh berformat JPG, JPEG, PNG, PDF, DOC, atau DOCX.',

            'items.*.lampiran_3.max' =>
                'Lampiran konfirmasi ke-3 maksimal berukuran 10 MB.',
        ]);

        $currentUser = auth()->user() ?? \App\Models\User::where('role', 'petugas')->first();

        if (!$currentUser) {
            return redirect()->back()->withErrors(['error' => 'Silakan login terlebih dahulu untuk membuat Berita Acara.']);
        }

        // New workflow: 'generate' means submit for approval, 'draft' remains draft.
        // Nomor surat is NOT generated at submit time — it is generated at approval time.
        $status = $request->input('action') === 'generate' ? 'submitted' : 'draft';

        $bastik = DB::transaction(function () use ($request, $currentUser, $status) {

            $bastik = FormBastik::create([
                'petugas_id' => $currentUser->id,
                'pimpinan_id' => $request->input('pimpinan_id'),
                'nomor_surat' => null, // Nomor surat generated at approval
                'tanggal_surat' => $request->input('tanggal_surat'),
                'kota' => $request->input('kota'),
                'business_area' => $request->input('business_area'),
                'status' => $status,
                'qr_token' => Str::random(40),
            ]);

            // Save items & upload lampirans
            foreach ($request->input('items') as $index => $itemData) {
                $item = FormBastikItem::create([
                    'form_bastik_id' => $bastik->id,
                    'urutan_baris' => $index + 1,
                    'no_tiket' => $itemData['no_tiket'],
                    'detail_tiket' => $itemData['detail_tiket'],
                    'user_pemohon' => $itemData['user_pemohon'],
                    'nipp' => $itemData['nipp'],
                    'unit' => $itemData['unit'],
                ]);

                // Handle file uploads for this item
                for ($confNum = 1; $confNum <= 3; $confNum++) {
                    $fileKey = "items.{$index}.lampiran_{$confNum}";
                    if ($request->hasFile($fileKey)) {
                        $file = $request->file($fileKey);
                        $path = $file->store('lampirans', 'public');

                        FormBastikLampiran::create([
                            'form_bastik_id' => $bastik->id,
                            'form_bastik_item_id' => $item->id,
                            'file_path' => $path,
                            'original_name' => basename(
                                $file->getClientOriginalName()
                            ),
                            'urutan_konfirmasi' => $confNum,
                        ]);
                    }
                }
            }

            // Create approval history for submit action
            if ($status === 'submitted') {
                ApprovalHistory::create([
                    'form_bastik_id' => $bastik->id,
                    'user_id' => $currentUser->id,
                    'action' => 'SUBMIT',
                    'from_status' => 'draft',
                    'to_status' => 'submitted',
                    'note' => null,
                ]);
            }

            return $bastik;
        });

        $message = $status === 'submitted' 
            ? "Berita Acara berhasil disubmit untuk persetujuan." 
            : "Draft Berita Acara berhasil disimpan.";

        return redirect()->route('form-bastik.show', $bastik->id)->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bastik = FormBastik::with(['petugas', 'pimpinan', 'items.lampirans', 'approvalHistories.user', 'approver'])->findOrFail($id);
        $currentUser = auth()->user();
        if (!$this->canAccessBastik($bastik, $currentUser)) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat dokumen ini.');
        }
        return view('form-bastik.show', compact('bastik'));
    }

    /**
     * Show the form for editing the specified resource.
     * Allowed for: draft, rejected (revision after rejection).
     */
    public function edit($id)
    {
        $bastik = FormBastik::with('items')->findOrFail($id);

        $currentUser = $bastik->petugas;
        $signers = MasterSigner::all();

        return view('form-bastik.edit', compact('bastik', 'currentUser', 'signers'));
    }

    /**
     * Update the specified resource in storage.
     * Allowed for: draft, rejected (revision).
     */
    public function update(Request $request, $id)
    {
        $bastik = FormBastik::findOrFail($id);

        $request->validate([
            'pimpinan_id' => 'required|exists:master_signers,id',
            'tanggal_surat' => 'required|date',
            'kota' => 'required|string|max:50',
            'business_area' => 'required|string|max:100',
            'items' => 'required|array|min:1',
            'items.*.no_tiket' => 'required|string|max:30',
            'items.*.detail_tiket' => 'required|string',
            'items.*.user_pemohon' => 'required|string|max:150',
            'items.*.nipp' => 'required|string|max:30',
            'items.*.unit' => 'required|string|max:100',
            'items.*.lampiran_1' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx',
                'max:10240',
            ],

            'items.*.lampiran_2' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx',
                'max:10240',
            ],

            'items.*.lampiran_3' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx',
                'max:10240',
            ],

            'action' => 'required|in:draft,generate',
        ], [
            'items.*.lampiran_1.uploaded' =>
                'Lampiran konfirmasi ke-1 gagal diunggah oleh server. Pastikan ukuran file maksimal 10 MB dan coba unggah kembali.',

            'items.*.lampiran_1.file' =>
                'Lampiran konfirmasi ke-1 harus berupa file.',

            'items.*.lampiran_1.mimes' =>
                'Lampiran konfirmasi ke-1 hanya boleh berformat JPG, JPEG, PNG, PDF, DOC, atau DOCX.',

            'items.*.lampiran_1.max' =>
                'Lampiran konfirmasi ke-1 maksimal berukuran 10 MB.',

            'items.*.lampiran_2.uploaded' =>
                'Lampiran konfirmasi ke-1 gagal diunggah oleh server. Pastikan ukuran file maksimal 10 MB dan coba unggah kembali.',
            
            'items.*.lampiran_2.file' =>
                'Lampiran konfirmasi ke-2 harus berupa file.',

            'items.*.lampiran_2.mimes' =>
                'Lampiran konfirmasi ke-2 hanya boleh berformat JPG, JPEG, PNG, PDF, DOC, atau DOCX.',

            'items.*.lampiran_2.max' =>
                'Lampiran konfirmasi ke-2 maksimal berukuran 10 MB.',

            'items.*.lampiran_3.uploaded' =>
                'Lampiran konfirmasi ke-1 gagal diunggah oleh server. Pastikan ukuran file maksimal 10 MB dan coba unggah kembali.',
            
                'items.*.lampiran_3.file' =>
                'Lampiran konfirmasi ke-3 harus berupa file.',

            'items.*.lampiran_3.mimes' =>
                'Lampiran konfirmasi ke-3 hanya boleh berformat JPG, JPEG, PNG, PDF, DOC, atau DOCX.',

            'items.*.lampiran_3.max' =>
                'Lampiran konfirmasi ke-3 maksimal berukuran 10 MB.',
        ]);

        // New workflow: 'generate' means submit for approval
        $previousStatus = $bastik->status;
        $newStatus = $request->input('action') === 'generate' ? 'submitted' : 'draft';

        DB::transaction(function () use ($request, $bastik, $newStatus, $previousStatus) {

            $bastik->update([
                'pimpinan_id' => $request->input('pimpinan_id'),
                'tanggal_surat' => $request->input('tanggal_surat'),
                'kota' => $request->input('kota'),
                'business_area' => $request->input('business_area'),
                'status' => $newStatus,
                'rejection_note' => $newStatus === 'submitted' ? null : $bastik->rejection_note,
            ]);

            // Simple delete items and recreate to update
            $bastik->items()->delete();

            // Re-create items & keep existing lampirans or upload new ones
            foreach ($request->input('items') as $index => $itemData) {
                $item = FormBastikItem::create([
                    'form_bastik_id' => $bastik->id,
                    'urutan_baris' => $index + 1,
                    'no_tiket' => $itemData['no_tiket'],
                    'detail_tiket' => $itemData['detail_tiket'],
                    'user_pemohon' => $itemData['user_pemohon'],
                    'nipp' => $itemData['nipp'],
                    'unit' => $itemData['unit'],
                ]);

                // Handle file uploads for this item
                for ($confNum = 1; $confNum <= 3; $confNum++) {
                    $fileKey = "items.{$index}.lampiran_{$confNum}";
                    if ($request->hasFile($fileKey)) {
                        // Delete previous lampiran for this confNum if any
                        FormBastikLampiran::where('form_bastik_id', $bastik->id)
                            ->where('urutan_konfirmasi', $confNum)
                            ->delete();

                        $file = $request->file($fileKey);
                        $path = $file->store('lampirans', 'public');

                        FormBastikLampiran::create([
                            'form_bastik_id' => $bastik->id,
                            'form_bastik_item_id' => $item->id,
                            'file_path' => $path,
                            'original_name' => basename(
                                $file->getClientOriginalName()
                            ),
                            'urutan_konfirmasi' => $confNum,
                        ]);
                    }
                }
            }

            // Create approval history entries
            if ($previousStatus === 'rejected' && $newStatus !== 'draft') {
                // Revision: rejected → draft (implicit) then submit
                ApprovalHistory::create([
                    'form_bastik_id' => $bastik->id,
                    'user_id' => auth()->id() ?? $bastik->petugas_id,
                    'action' => 'REVISE',
                    'from_status' => 'rejected',
                    'to_status' => 'draft',
                    'note' => null,
                ]);
            }

            if ($newStatus === 'submitted') {
                ApprovalHistory::create([
                    'form_bastik_id' => $bastik->id,
                    'user_id' => auth()->id() ?? $bastik->petugas_id,
                    'action' => 'SUBMIT',
                    'from_status' => $previousStatus === 'rejected' ? 'draft' : $previousStatus,
                    'to_status' => 'submitted',
                    'note' => null,
                ]);
            }
        });

        $message = $newStatus === 'submitted' 
            ? "Berita Acara berhasil disubmit untuk persetujuan." 
            : "Draft Berita Acara berhasil diupdate.";

        return redirect()->route('form-bastik.show', $bastik->id)->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $bastik = FormBastik::findOrFail($id);

        if ($bastik->lampirans) {
            foreach ($bastik->lampirans as $lampiran) {
                if (!empty($lampiran->file_path) && \Illuminate\Support\Facades\Storage::disk('public')->exists($lampiran->file_path)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($lampiran->file_path);
                }
            }
        }

        $bastik->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Berita Acara berhasil dihapus.'
            ]);
        }

        return redirect()->route('form-bastik.index')->with('success', 'Berita Acara berhasil dihapus.');
    }

    /**
     * Set document status to void (admin only).
     */
    public function void($id)
    {
        $bastik = FormBastik::findOrFail($id);

        // Simple auth check for admin role simulation
        $currentUser = auth()->user() ?? \App\Models\User::where('role', 'admin')->first();
        if (!$currentUser || $currentUser->role !== 'admin') {
            return redirect()->route('form-bastik.show', $bastik->id)
                ->with('error', 'Hanya Admin yang berhak membatalkan (void) dokumen.');
        }

        $bastik->status = 'void';
        $bastik->save();

        return redirect()->route('form-bastik.show', $bastik->id)
            ->with('success', 'Dokumen berhasil dibatalkan (void).');
    }

    /**
     * Submit document for approval (petugas only).
     * Valid from: draft, rejected.
     */
    public function submit($id)
    {
        $bastik = FormBastik::findOrFail($id);
        $currentUser = auth()->user() ?? \App\Models\User::where('role', 'petugas')->first() ?? \App\Models\User::first();

        if (!$currentUser) {
            abort(403, 'Silakan login terlebih dahulu.');
        }

        // Only petugas or admin can submit
        if ($currentUser->role !== 'petugas' && $currentUser->role !== 'admin') {
            abort(403, 'Hanya Petugas Service Desk atau Admin yang dapat mensubmit dokumen.');
        }

        if (!$bastik->canBeSubmitted()) {
            return redirect()->route('form-bastik.show', $bastik->id)
                ->with('error', 'Dokumen tidak dapat disubmit dari status saat ini.');
        }

        $previousStatus = $bastik->status;

        DB::transaction(function () use ($bastik, $currentUser, $previousStatus) {
            // If coming from rejected, record REVISE first
            if ($previousStatus === 'rejected') {
                ApprovalHistory::create([
                    'form_bastik_id' => $bastik->id,
                    'user_id' => $currentUser->id,
                    'action' => 'REVISE',
                    'from_status' => 'rejected',
                    'to_status' => 'draft',
                    'note' => null,
                ]);
            }

            $bastik->update([
                'status' => 'submitted',
                'rejection_note' => null,
            ]);

            ApprovalHistory::create([
                'form_bastik_id' => $bastik->id,
                'user_id' => $currentUser->id,
                'action' => 'SUBMIT',
                'from_status' => $previousStatus === 'rejected' ? 'draft' : $previousStatus,
                'to_status' => 'submitted',
                'note' => null,
            ]);
        });

        return redirect()->route('form-bastik.show', $bastik->id)
            ->with('success', 'Dokumen berhasil disubmit untuk persetujuan.');
    }

    /**
     * Approve document (pimpinan only).
     * 
     * Backend authorization enforced:
     * - Only role=pimpinan can approve
     * - Document must be in 'submitted' status
     * - Creator cannot approve their own document
     * - Nomor surat generated at approval time
     */
    public function approve($id)
    {
        $bastik = FormBastik::findOrFail($id);
        $currentUser = auth()->user();

        if (!$currentUser) {
            abort(403, 'Silakan login terlebih dahulu.');
        }

        // Backend authorization: only pimpinan can approve
        if ($currentUser->role !== 'pimpinan') {
            abort(403, 'Hanya Pimpinan yang berhak menyetujui dokumen.');
        }

        // Status validation: only submitted documents can be approved
        if (!$bastik->canBeApproved()) {
            return redirect()->route('form-bastik.show', $bastik->id)
                ->with('error', 'Dokumen hanya dapat disetujui jika berstatus "Menunggu Persetujuan".');
        }

        // Self-approval prevention: creator cannot approve their own document
        if ($bastik->petugas_id === $currentUser->id) {
            return redirect()->route('form-bastik.show', $bastik->id)
                ->with('error', 'Anda tidak dapat menyetujui dokumen yang Anda buat sendiri (separation of duties).');
        }

        DB::transaction(function () use ($bastik, $currentUser) {
            // Generate nomor surat using existing numbering mechanism
            $nomorSurat = $bastik->nomor_surat;
            if (!$nomorSurat) {
                $tanggal = new \DateTime($bastik->tanggal_surat);
                $tahun = (int)$tanggal->format('Y');
                $bulan = (int)$tanggal->format('m');
                $unit = $bastik->petugas->unit_kerja ?? 'TI';

                // Real-time locking counter logic to prevent duplicate numbers
                $counter = NomorSuratCounter::where('kode_unit', $unit)
                    ->where('tahun', $tahun)
                    ->where('bulan', $bulan)
                    ->where('kode_jenis_surat', 'BA-INC')
                    ->lockForUpdate()
                    ->first();

                if (!$counter) {
                    $counter = NomorSuratCounter::create([
                        'tahun' => $tahun,
                        'bulan' => $bulan,
                        'kode_jenis_surat' => 'BA-INC',
                        'kode_unit' => $unit,
                        'last_number' => 0,
                    ]);
                }

                $counter->increment('last_number');
                $nomorSurat = sprintf('%03d/BA-INC/%s/%s/%s',
                    $counter->last_number,
                    $unit,
                    FormBastik::getRomanMonth($bulan),
                    $tahun
                );
            }

            $bastik->update([
                'status' => 'signed',
                'nomor_surat' => $nomorSurat,
                'approved_by' => $currentUser->id,
                'approved_at' => now(),
                'rejection_note' => null,
            ]);

            ApprovalHistory::create([
                'form_bastik_id' => $bastik->id,
                'user_id' => $currentUser->id,
                'action' => 'APPROVE',
                'from_status' => 'submitted',
                'to_status' => 'signed',
                'note' => null,
            ]);
        });

        return redirect()->route('form-bastik.show', $bastik->id)
            ->with('success', "Dokumen Berita Acara berhasil disetujui dengan nomor {$bastik->fresh()->nomor_surat}.");
    }

    /**
     * Reject document (pimpinan only).
     *
     * Backend authorization enforced:
     * - Only role=pimpinan can reject
     * - Document must be in 'submitted' status
     * - Rejection note is required
     */
    public function reject(Request $request, $id)
    {
        $bastik = FormBastik::findOrFail($id);
        $currentUser = auth()->user();

        if (!$currentUser) {
            abort(403, 'Silakan login terlebih dahulu.');
        }

        // Backend authorization: only pimpinan can reject
        if ($currentUser->role !== 'pimpinan') {
            abort(403, 'Hanya Pimpinan yang berhak menolak dokumen.');
        }

        // Status validation
        if (!$bastik->canBeRejected()) {
            return redirect()->route('form-bastik.show', $bastik->id)
                ->with('error', 'Dokumen hanya dapat ditolak jika berstatus "Menunggu Persetujuan".');
        }

        // Rejection note is required
        $request->validate([
            'rejection_note' => 'required|string|max:2000',
        ], [
            'rejection_note.required' => 'Alasan penolakan wajib diisi.',
        ]);

        DB::transaction(function () use ($request, $bastik, $currentUser) {
            $bastik->update([
                'status' => 'rejected',
                'rejection_note' => $request->input('rejection_note'),
            ]);

            ApprovalHistory::create([
                'form_bastik_id' => $bastik->id,
                'user_id' => $currentUser->id,
                'action' => 'REJECT',
                'from_status' => 'submitted',
                'to_status' => 'rejected',
                'note' => $request->input('rejection_note'),
            ]);
        });

        return redirect()->route('form-bastik.show', $bastik->id)
            ->with('success', 'Dokumen telah ditolak.');
    }

    /**
     * Pending Approval list (pimpinan only).
     */
    public function pendingApproval(Request $request)
    {
        $currentUser = auth()->user();

        if (!$currentUser || !in_array($currentUser->role, ['pimpinan', 'admin'])) {
            abort(403, 'Halaman ini hanya dapat diakses oleh Pimpinan.');
        }

        $query = FormBastik::with(['petugas', 'pimpinan'])
            ->where('status', 'submitted');

        // Scope pending approval list by designated pimpinan (unless admin)
        if ($currentUser->role === 'pimpinan') {
            $query->whereHas('pimpinan', function ($sq) use ($currentUser) {
                $sq->where('nipp', $currentUser->nip_kwt)
                   ->orWhere('nama', $currentUser->name);
            });
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('kota', 'like', "%{$search}%")
                  ->orWhere('business_area', 'like', "%{$search}%")
                  ->orWhereHas('petugas', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('form-bastik.pending-approval', compact('documents'));
    }

    /**
     * Display standalone printable version of the BASTIK (matches browser print standard).
     */
    public function print($id)
    {
        $bastik = FormBastik::with([
            'petugas',
            'pimpinan',
            'items.lampirans',
        ])->findOrFail($id);

        $currentUser = auth()->user();
        if (!$this->canAccessBastik($bastik, $currentUser)) {
            abort(403, 'Anda tidak memiliki hak akses untuk mencetak dokumen ini.');
        }

        $verifyUrl = route('form-bastik.verify', $bastik->qr_token);
        $qrCodeSvg = QrCode::size(80)->generate($verifyUrl);
        $qrCodeBase64 = base64_encode($qrCodeSvg);

        return view('form-bastik.print', compact('bastik', 'qrCodeBase64'));
    }

    /**
     * Generate PDF version of the BASTIK.
     */
    public function downloadPdf($id)
    {
        $bastik = FormBastik::with([
            'petugas',
            'pimpinan',
            'items.lampirans',
        ])->findOrFail($id);

        $currentUser = auth()->user();
        if (!$this->canAccessBastik($bastik, $currentUser)) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengunduh PDF dokumen ini.');
        }

        // Membuat QR Code
        $verifyUrl = route('form-bastik.verify', $bastik->qr_token);
        $qrCodeSvg = QrCode::size(80)->generate($verifyUrl);
        $qrCodeBase64 = base64_encode($qrCodeSvg);

        /*
        * Render pertama untuk menghitung total halaman.
        */
        $previewPdf = Pdf::loadView('form-bastik.pdf', [
            'bastik' => $bastik,
            'qrCodeBase64' => $qrCodeBase64,
            'totalPages' => 1,
        ]);

        $previewPdf->setPaper('a4', 'portrait');
        $previewPdf->render();

        $totalPages = $previewPdf
            ->getDomPDF()
            ->getCanvas()
            ->get_page_count();

        /*
        * Render kedua untuk menghasilkan PDF final.
        */
        $pdf = Pdf::loadView('form-bastik.pdf', [
            'bastik' => $bastik,
            'qrCodeBase64' => $qrCodeBase64,
            'totalPages' => $totalPages,
        ]);

        $pdf->setPaper('a4', 'portrait');

        // Inject print script so PDF immediately triggers print dialog on load
        $pdf->getDomPDF()->getCanvas()->javascript("this.print();");

        return $pdf->stream(
            "Berita_Acara_Penutupan_Tiket-{$bastik->id}.pdf",
            ["Attachment" => false]
        );
        }

        /**
         * Membuka atau mengunduh file lampiran.
         */
        public function openLampiran(FormBastikLampiran $lampiran)
        {
            $bastik = $lampiran->formBastik;
            $currentUser = auth()->user();

            if (!$bastik || !$this->canAccessBastik($bastik, $currentUser)) {
                abort(403, 'Anda tidak memiliki hak akses untuk membuka file lampiran ini.');
            }

            $disk = Storage::disk('public');

            // Pastikan file benar-benar ada
            abort_unless(
                $disk->exists($lampiran->file_path),
                404,
                'File lampiran tidak ditemukan.'
            );

            $absolutePath = $disk->path($lampiran->file_path);

            $mimeType = $disk->mimeType($lampiran->file_path)
                ?: 'application/octet-stream';

            // Gambar dan PDF dibuka di browser
            $canOpenInline =
                str_starts_with($mimeType, 'image/')
                || $mimeType === 'application/pdf';

            $disposition = $canOpenInline
                ? 'inline'
                : 'attachment';

            $fileName = $lampiran->original_name
                ?: basename($absolutePath);

            return response()->file(
                $absolutePath,
                [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' =>
                        $disposition .
                        '; filename="' .
                        str_replace('"', '', $fileName) .
                        '"',
                    'X-Content-Type-Options' => 'nosniff',
                ]
            );
        }
        /**
         * Generate Word/Docx version of the BASTIK.
         */
        public function downloadDocx($id)
        {
        $bastik = FormBastik::with(['petugas', 'pimpinan', 'items.lampirans'])->findOrFail($id);

        $currentUser = auth()->user();
        if (!$this->canAccessBastik($bastik, $currentUser)) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengunduh Word dokumen ini.');
        }

        // Backend guard: Word download is DENIED for signed or final status
        if (in_array($bastik->status, ['signed', 'final'])) {
            abort(403, 'Dokumen resmi yang telah disetujui (signed/final) tidak dapat diunduh dalam format Word.');
        }

        $phpWord = new PhpWord();
        
        // Arial font setting
        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(11);

        // Page setup: margin 4-3-3-3
        // 1 cm = 567 twips. Top = 2268 twips. Left/Right/Bottom = 1701 twips.
        $section = $phpWord->addSection([
            'marginTop' => 2268,
            'marginLeft' => 1701,
            'marginRight' => 1701,
            'marginBottom' => 1701,
            'pageSizeW' => 11907, // A4 Width in twips
            'pageSizeH' => 16840, // A4 Height in twips
        ]);

        // Add Kop Surat (PT KAI Header)
        $tableStyle = ['borderBottomSize' => 12, 'borderBottomColor' => '000000', 'cellMargin' => 50];
        $headerTable = $section->addTable($tableStyle);
        $headerTable->addRow();
        
        // Left Column (Logo and Text)
        $leftCell = $headerTable->addCell(6000);
        $leftCell->addText('PT. KERETA API INDONESIA (PERSERO)', ['bold' => true, 'size' => 12]);
        $leftCell->addText('SISTEM INFORMASI SERVICE DESK', ['size' => 10]);

        // Right Column (Metadata box)
        $rightCell = $headerTable->addCell(3000);
        $rightCell->addText('TERBATAS', ['bold' => true, 'color' => 'FF0000', 'size' => 9], ['alignment' => 'right']);
        $rightCell->addText('No. : SI-BASTIK/FR-01', ['size' => 9], ['alignment' => 'right']);
        $rightCell->addText('Tgl Terbit : ' . ($bastik->tanggal_surat ? date('d-m-Y', strtotime($bastik->tanggal_surat)) : '-'), ['size' => 9], ['alignment' => 'right']);
        $rightCell->addText('Halaman : 1 dari 1', ['size' => 9], ['alignment' => 'right']);

        $section->addTextBreak(1);

        // Title
        $section->addText('BERITA ACARA PENUTUPAN INCIDENT / WORK ORDER', ['bold' => true, 'size' => 14], ['alignment' => 'center']);
        $section->addText('Nomor: ' . ($bastik->nomor_surat ?? '[DRAFT - NOMOR BELUM DITERBITKAN]'), ['bold' => true, 'size' => 11], ['alignment' => 'center']);
        
        $section->addTextBreak(1);

        // Baku intro
        $hariText = $this->getHariName($bastik->tanggal_surat);
        $tanggalBakuText = $bastik->tanggal_surat ? $this->formatTanggalIndo($bastik->tanggal_surat) : '-';
        $section->addText("Pada hari ini, {$hariText}, {$tanggalBakuText}, yang bertandatangan di bawah ini:");

        // Identitas Petugas
        $section->addText("Nama\t: " . ($bastik->petugas->name ?? '-'), ['size' => 11]);
        $section->addText("NIPKWT\t: " . ($bastik->petugas->nip_kwt ?? '-'), ['size' => 11]);
        $section->addText("Jabatan\t: Petugas Service Desk — " . ($bastik->petugas->unit_kerja ?? '-'), ['size' => 11]);

        $section->addTextBreak(1);

        $section->addText("Menyatakan bahwa telah dilakukan konfirmasi sebanyak 3 (tiga) kali kepada user pemohon terkait tiket-tiket di bawah ini, namun hingga batas waktu yang ditentukan belum ada respon dari pihak terkait, sehingga tiket dinyatakan ditutup (closed) dengan rincian sebagai berikut:");

        // Item Table
        $itemTableStyle = [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 80
        ];
        $itemTable = $section->addTable($itemTableStyle);
        
        // Headers
        $itemTable->addRow();
        $itemTable->addCell(2000, ['bgColor' => 'F2F2F2'])->addText('No Tiket', ['bold' => true]);
        $itemTable->addCell(3000, ['bgColor' => 'F2F2F2'])->addText('Detail Tiket', ['bold' => true]);
        $itemTable->addCell(2000, ['bgColor' => 'F2F2F2'])->addText('User Pemohon', ['bold' => true]);
        $itemTable->addCell(1000, ['bgColor' => 'F2F2F2'])->addText('NIPP', ['bold' => true]);
        $itemTable->addCell(1500, ['bgColor' => 'F2F2F2'])->addText('Unit', ['bold' => true]);

        foreach ($bastik->items as $item) {
            $itemTable->addRow();
            $itemTable->addCell(2000)->addText($item->no_tiket);
            $itemTable->addCell(3000)->addText($item->detail_tiket);
            $itemTable->addCell(2000)->addText($item->user_pemohon);
            $itemTable->addCell(1000)->addText($item->nipp);
            $itemTable->addCell(1500)->addText($item->unit);
        }

        $section->addTextBreak(1);

        $section->addText("Demikian Berita Acara ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.");

        $section->addTextBreak(1);

        $kotaTanggal = ($bastik->kota ?? 'Bandung') . ', ' . ($bastik->tanggal_surat ? $this->formatTanggalIndo($bastik->tanggal_surat) : '');
        $section->addText($kotaTanggal, [], ['alignment' => 'right']);

        // Signatures Layout
        $sigTable = $section->addTable(['cellMargin' => 50]);
        $sigTable->addRow();
        
        $petugasCell = $sigTable->addCell(4500);
        $petugasCell->addText('Petugas Service Desk,');
        $petugasCell->addTextBreak(3);
        $petugasCell->addText('( ' . ($bastik->petugas->name ?? '-') . ' )', ['bold' => true]);
        $petugasCell->addText('NIPKWT: ' . ($bastik->petugas->nip_kwt ?? '-'));

        $pimpinanCell = $sigTable->addCell(4500);
        $pimpinanCell->addText('Mengetahui,');
        
        if ($bastik->status === 'signed') {
            $pimpinanCell->addText('[ QR CODE VERIFIED ]', ['bold' => true, 'color' => '008000']);
            $pimpinanCell->addText('Scan PDF for authenticity');
            $pimpinanCell->addTextBreak(1);
        } elseif ($bastik->status === 'final') {
            // Legacy support: final documents also show QR
            $pimpinanCell->addText('[ QR CODE VERIFIED ]', ['bold' => true, 'color' => '008000']);
            $pimpinanCell->addText('Scan PDF for authenticity');
            $pimpinanCell->addTextBreak(1);
        } else {
            $pimpinanCell->addTextBreak(3);
        }

        $pimpinanCell->addText('( ' . ($bastik->pimpinan->nama ?? '-') . ' )', ['bold' => true]);
        $pimpinanCell->addText('NIPP: ' . ($bastik->pimpinan->nipp ?? '-') . ' — ' . ($bastik->pimpinan->jabatan ?? '-'));

        // Save Word file
        $fileName = "Berita_Acara_Penutupan_Tiket-{$bastik->id}.docx";

        /*
        * Gunakan folder sementara milik aplikasi.
        * Lebih aman daripada sys_get_temp_dir() pada Windows/OneDrive.
        */
        $tempDirectory = storage_path('app/temp/word');

        if (!is_dir($tempDirectory)) {
            $directoryCreated = mkdir(
                $tempDirectory,
                0775,
                true
            );

            if (!$directoryCreated && !is_dir($tempDirectory)) {
                throw new \RuntimeException(
                    'Folder sementara Word tidak dapat dibuat.'
                );
            }
        }

        /*
        * Nama file sementara tetap memakai ekstensi .docx.
        */
        $tempFile = $tempDirectory
            . DIRECTORY_SEPARATOR
            . 'bastik_'
            . $bastik->id
            . '_'
            . Str::uuid()
            . '.docx';

        $objWriter = IOFactory::createWriter(
            $phpWord,
            'Word2007'
        );

        $objWriter->save($tempFile);

        return response()->download(
            $tempFile,
            $fileName,
            [
                'Content-Type' =>
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ]
        )->deleteFileAfterSend(true);
    }

    /**
     * QR Verification Page (public).
     * Handles both valid and invalid tokens gracefully.
     */
    public function verify($qr_token)
    {
        $bastik = FormBastik::with(['petugas', 'pimpinan', 'approver'])
            ->where('qr_token', $qr_token)
            ->first();

        // Invalid token: show dedicated invalid verification page
        if (!$bastik) {
            return response()->view('form-bastik.verify-invalid', [], 404);
        }

        // Log scan activity using existing QrValidationLog
        QrValidationLog::create([
            'form_bastik_id' => $bastik->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return view('form-bastik.verify', compact('bastik'));
    }

    /**
     * Parse Excel ticket items.
     */
    public function parseExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120',
        ]);

        $import = new \App\Imports\FormBastik\FormBastikItemsImport;
        
        try {
            $data = \Maatwebsite\Excel\Facades\Excel::toArray($import, $request->file('file'));
            
            $rows = [];
            if (!empty($data) && isset($data[0])) {
                foreach ($data[0] as $row) {
                    // Check if row is empty
                    if (empty(array_filter($row))) {
                        continue;
                    }
                    $noTiket = $row['no_tiket'] ?? $row['nomor_tiket'] ?? $row['tiket'] ?? '';
                    if (empty($noTiket)) {
                        $noTiket = 'INC' . sprintf('%06d', rand(100000, 999999));
                    }
                    $rows[] = [
                        'no_tiket' => $noTiket,
                        'detail_tiket' => $row['detail_tiket'] ?? $row['rincian_tiket'] ?? $row['detail'] ?? '',
                        'user_pemohon' => $row['user_pemohon'] ?? $row['pemohon'] ?? $row['user'] ?? '',
                        'nipp' => $row['nipp'] ?? $row['nip'] ?? '',
                        'unit' => $row['unit'] ?? $row['unit_kerja'] ?? $row['unit'] ?? '',
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'data' => $rows
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membaca file excel: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Download empty Excel template.
     */
    public function templateItems()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\FormBastik\FormBastikTemplateExport, 'template_import_tiket.xlsx');
    }

    // Date formatting helpers
    private function getHariName($dateString)
    {
        if (!$dateString) return '-';
        $timestamp = strtotime($dateString);
        $hariArr = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        return $hariArr[date('w', $timestamp)];
    }

    private function formatTanggalIndo($dateString)
    {
        if (!$dateString) return '-';
        $timestamp = strtotime($dateString);
        $bulanArr = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        
        $tgl = date('d', $timestamp);
        $bln = $bulanArr[(int)date('m', $timestamp)];
        $thn = date('Y', $timestamp);

        return "{$tgl} {$bln} {$thn}";
    }

    /**
     * Authorization helper for BASTIK document access.
     */
    private function canAccessBastik(FormBastik $bastik, ?\App\Models\User $user): bool
    {
        if (!$user) {
            $user = auth()->user();
        }

        if (!$user) {
            return false;
        }

        // Admin can access all documents
        if ($user->role === 'admin') {
            return true;
        }

        // Petugas can only access documents they created
        if ($user->role === 'petugas') {
            return (int)$bastik->petugas_id === (int)$user->id;
        }

        // Pimpinan can access documents assigned to them, approved by them, or created by them
        if ($user->role === 'pimpinan') {
            if ((int)$bastik->petugas_id === (int)$user->id) {
                return true;
            }

            if ((int)$bastik->approved_by === (int)$user->id) {
                return true;
            }

            if ($bastik->pimpinan) {
                if ($bastik->pimpinan->nipp && $user->nip_kwt && $bastik->pimpinan->nipp === $user->nip_kwt) {
                    return true;
                }
                if ($bastik->pimpinan->nama && $user->name && $bastik->pimpinan->nama === $user->name) {
                    return true;
                }
            }

            return false;
        }

        return false;
    }
}
