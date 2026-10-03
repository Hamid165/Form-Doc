<?php

namespace App\Http\Controllers\FormPemusnahan;

use App\Http\Controllers\Controller;
use App\Models\FormPemusnahan\FormPemusnahan;
use App\Models\FormPemusnahan\FormPemusnahanItem;
use App\Models\FormPemusnahan\DataAset;
use App\Models\FormPemusnahan\DataPemohon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormPemusnahanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $forms = FormPemusnahan::when($search, function ($query) use ($search) {
            $query->where('no_ref', 'like', "%{$search}%")
                  ->orWhere('nama_nip', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('business_area', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(10, ['*'], 'form_page');

        $dataAsets = DataAset::orderBy('id_aset', 'asc')->paginate(10, ['*'], 'aset_page');
        $dataPemohons = DataPemohon::orderBy('nama', 'asc')->paginate(10, ['*'], 'pemohon_page');

        return view('form-pemusnahan.index', compact('forms', 'search', 'dataAsets', 'dataPemohons'));
    }

   public function create()
{
    return view('form-pemusnahan.create', [
        'isEdit' => false,
        'dataPemohons' => \App\Models\FormPemusnahan\DataPemohon::orderBy('nama')->get(),
        'dataAsets' => \App\Models\FormPemusnahan\DataAset::orderBy('nama_aset')->get(),
    ]);
}

    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'no_ref' => 'nullable|string|max:100',
            'tanggal_ref' => 'nullable|date',
            'business_area' => 'nullable|string|max:255',

            'tanggal_permohonan' => 'nullable|date',
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:100',
            'unit_kerja' => 'required|string|max:255',

            'items' => 'nullable|array',
            'items.*.nama_aset' => 'nullable|string|max:255',
            'items.*.jenis_aset' => 'nullable|string|max:255',
            'items.*.id_aset' => 'nullable|string|max:255',
            'items.*.alasan_pemusnahan' => 'nullable|string',

            'tempat_persetujuan' => 'nullable|string|max:255',
            'tanggal_persetujuan' => 'nullable|date',
            'nama_atasan' => 'nullable|string|max:255',
            'nama_pengelola' => 'nullable|string|max:255',
            'keputusan' => 'nullable|in:setuju,tidak_setuju',
            'nama_vp' => 'nullable|string|max:255',
        ]);

        // Tanggal hanya 1 input (tanggal_ref) — tanggal_permohonan & tanggal_persetujuan
        // selalu disamakan di server, supaya tidak bisa berbeda meskipun input di form-nya di-bypass.
        $validated['tanggal_permohonan'] = $validated['tanggal_ref'] ?? null;
        $validated['tanggal_persetujuan'] = $validated['tanggal_ref'] ?? null;

        // Nama & NIP disimpan terpisah di database (untuk kejelasan input & query),
        // tapi digabung lagi jadi satu string "Nama (NIP)" untuk ditampilkan di formulir/PDF
        // — supaya tampilan hasil cetak tetap identik dengan sebelumnya / template asli.
        $nama = trim($validated['nama']);
        $nip = trim($validated['nip'] ?? '');
        $validated['nama_nip'] = $nip !== '' ? "{$nama} ({$nip})" : $nama;

        return $validated;
    }

    /**
     * Sinkronkan nilai "Nama & NIP" dari formulir ke tabel data_pemohons,
     * supaya master data Data Pemohon selalu ikut ter-update otomatis.
     * Format yang dikenali: "Nama (NIP)" — kalau tidak cocok pola itu,
     * seluruh teks disimpan sebagai nama saja.
     */
    private function syncDataPemohon(?string $nama, ?string $nip): void
    {
        $nama = trim((string) $nama);
        $nip = $nip !== null ? trim($nip) : null;
        $nip = $nip === '' ? null : $nip;

        if ($nama === '') {
            return;
        }

        \App\Models\FormPemusnahan\DataPemohon::firstOrCreate([
            'nama' => $nama,
            'nip' => $nip,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        DB::transaction(function () use ($validated) {

            $form = FormPemusnahan::create([
                'no_ref' => $validated['no_ref'] ?? null,
                'tanggal_ref' => $validated['tanggal_ref'] ?? null,
                'business_area' => $validated['business_area'] ?? null,
                'tanggal_permohonan' => $validated['tanggal_permohonan'] ?? null,
                'nama' => $validated['nama'],
                'nip' => $validated['nip'] ?? null,
                'nama_nip' => $validated['nama_nip'],
                'unit_kerja' => $validated['unit_kerja'],
                'tempat_persetujuan' => $validated['tempat_persetujuan'] ?? null,
                'tanggal_persetujuan' => $validated['tanggal_persetujuan'] ?? null,
                'nama_atasan' => $validated['nama_atasan'] ?? null,
                'nama_pengelola' => $validated['nama_pengelola'] ?? null,
                'keputusan' => $validated['keputusan'] ?? null,
                'nama_vp' => $validated['nama_vp'] ?? null,
                'status' => 'draft',
            ]);

            $this->syncDataPemohon($validated['nama'] ?? null, $validated['nip'] ?? null);

            foreach (($validated['items'] ?? []) as $item) {
                // Lewati baris kosong (baris kosong yang tidak diisi pengguna)
                if (empty($item['nama_aset']) && empty($item['jenis_aset']) && empty($item['id_aset']) && empty($item['alasan_pemusnahan'])) {
                    continue;
                }

                FormPemusnahanItem::create([
                    'form_pemusnahan_id' => $form->id,
                    'nama_aset' => $item['nama_aset'] ?? '',
                    'jenis_aset' => $item['jenis_aset'] ?? '',
                    'id_aset' => $item['id_aset'] ?? '',
                    'alasan_pemusnahan' => $item['alasan_pemusnahan'] ?? '',
                ]);
            }
        });

        return redirect()
            ->route('form-pemusnahan.index')
            ->with('success', 'Form berhasil disimpan.');
    }

    public function show(FormPemusnahan $form_pemusnahan)
    {
        $form_pemusnahan->load('items');

        return view('form-pemusnahan.show', compact('form_pemusnahan'));
    }

    public function edit(FormPemusnahan $form_pemusnahan)
{
    $form_pemusnahan->load('items');

    return view('form-pemusnahan.edit', [
        'form_pemusnahan' => $form_pemusnahan,
        'isEdit' => true,
        'dataPemohons' => \App\Models\FormPemusnahan\DataPemohon::orderBy('nama')->get(),
        'dataAsets' => \App\Models\FormPemusnahan\DataAset::orderBy('nama_aset')->get(),
    ]);
}

    public function update(Request $request, FormPemusnahan $form_pemusnahan)
    {
        $validated = $this->validated($request);

        DB::transaction(function () use ($validated, $form_pemusnahan) {

            $form_pemusnahan->update([
                'no_ref' => $validated['no_ref'] ?? null,
                'tanggal_ref' => $validated['tanggal_ref'] ?? null,
                'business_area' => $validated['business_area'] ?? null,
                'tanggal_permohonan' => $validated['tanggal_permohonan'] ?? null,
                'nama' => $validated['nama'],
                'nip' => $validated['nip'] ?? null,
                'nama_nip' => $validated['nama_nip'],
                'unit_kerja' => $validated['unit_kerja'],
                'tempat_persetujuan' => $validated['tempat_persetujuan'] ?? null,
                'tanggal_persetujuan' => $validated['tanggal_persetujuan'] ?? null,
                'nama_atasan' => $validated['nama_atasan'] ?? null,
                'nama_pengelola' => $validated['nama_pengelola'] ?? null,
                'keputusan' => $validated['keputusan'] ?? null,
                'nama_vp' => $validated['nama_vp'] ?? null,
            ]);

            $this->syncDataPemohon($validated['nama'] ?? null, $validated['nip'] ?? null);

            // Ganti seluruh item lama dengan data baru dari form
            $form_pemusnahan->items()->delete();

            foreach (($validated['items'] ?? []) as $item) {
                if (empty($item['nama_aset']) && empty($item['jenis_aset']) && empty($item['id_aset']) && empty($item['alasan_pemusnahan'])) {
                    continue;
                }

                FormPemusnahanItem::create([
                    'form_pemusnahan_id' => $form_pemusnahan->id,
                    'nama_aset' => $item['nama_aset'] ?? '',
                    'jenis_aset' => $item['jenis_aset'] ?? '',
                    'id_aset' => $item['id_aset'] ?? '',
                    'alasan_pemusnahan' => $item['alasan_pemusnahan'] ?? '',
                ]);
            }
        });

        return redirect()
            ->route('form-pemusnahan.index')
            ->with('success', 'Form berhasil diperbarui.');
    }

    public function destroy(FormPemusnahan $form_pemusnahan)
    {
        $form_pemusnahan->delete();

        return redirect()
            ->route('form-pemusnahan.index')
            ->with('success', 'Form berhasil dihapus.');
    }
}