<?php

namespace App\Http\Controllers\FormSerahTerimaUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormSerahTerimaUser\FormSerahTerimaUser;
use App\Models\FormSerahTerimaUser\FormSerahTerimaUserItem;
use App\Models\FormSerahTerimaUser\MasterSerahTerimaUser;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FormSerahTerimaUserController extends Controller
{
    public function index()
    {
        $forms = FormSerahTerimaUser::orderBy('created_at', 'desc')->paginate(5, ['*'], 'form_page');
        $masterUsers = MasterSerahTerimaUser::orderBy('created_at', 'desc')->paginate(5, ['*'], 'master_page');
        return view('form-serah-terima-user.index', compact('forms', 'masterUsers'));
    }

    public function create()
    {
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Berita Acara Serah Terima User Aplikasi')
            ->orWhere('nama', 'like', '%Serah Terima User%')
            ->first();
            
        $form = new FormSerahTerimaUser();
        $masterUsers = MasterSerahTerimaUser::orderBy('nama', 'asc')->get();
        
        // Distinct lists for autocomplete/dropdowns
        $businessAreaList = FormSerahTerimaUser::whereNotNull('business_area')->distinct()->pluck('business_area');
        $tempatKedudukanList = FormSerahTerimaUser::whereNotNull('tempat_kedudukan_penyerah')->distinct()->pluck('tempat_kedudukan_penyerah');
        $personalAreaList = FormSerahTerimaUser::whereNotNull('personal_area_penyerah')->distinct()->pluck('personal_area_penyerah');

        return view('form-serah-terima-user.create', compact(
            'formTemplate', 'form', 'masterUsers', 
            'businessAreaList', 'tempatKedudukanList', 'personalAreaList'
        ));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_ref' => 'nullable|string|max:255',
            'tanggal_ref' => 'nullable|string',
            'business_area' => 'nullable|string|max:255',
            'hari' => 'nullable|string|max:255',
            'tanggal' => 'nullable|string',
            
            // Penyerah
            'nama_penyerah' => 'nullable|string|max:255',
            'nipp_penyerah' => 'nullable|string|max:255',
            'jabatan_penyerah' => 'nullable|string|max:255',
            'tempat_kedudukan_penyerah' => 'nullable|string|max:255',
            'personal_area_penyerah' => 'nullable|string|max:255',
            
            // Penerima
            'nama_penerima' => 'nullable|string|max:255',
            'nipp_penerima' => 'nullable|string|max:255',
            'jabatan_penerima' => 'nullable|string|max:255',
            'tempat_kedudukan_penerima' => 'nullable|string|max:255',
            'personal_area_penerima' => 'nullable|string|max:255',
            'owner_responsible_penerima' => 'nullable|string|max:255',
            'custodian_penerima' => 'nullable|string|max:255',
            
            'keperluan' => 'nullable|string',
            'masa_aktif_mulai' => 'nullable|string',
            'masa_aktif_selesai' => 'nullable|string',
            
            // Tanda Tangan
            'nama_yang_menyerahkan' => 'nullable|string|max:255',
            'nipp_yang_menyerahkan' => 'nullable|string|max:255',
            'nama_yang_menerima' => 'nullable|string|max:255',
            'nipp_yang_menerima' => 'nullable|string|max:255',
            'tempat_ttd' => 'nullable|string|max:255',
            'tanggal_ttd' => 'nullable|string',
            
            'items' => 'nullable|array',
            'items.*.nama_aplikasi' => 'nullable|string|max:255',
            'items.*.username' => 'nullable|string|max:255',
            'items.*.password' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validatedData) {
            $form = FormSerahTerimaUser::create([
                'no_ref' => $validatedData['no_ref'] ?? null,
                'tanggal_ref' => $this->parseIndonesianDate($validatedData['tanggal_ref'] ?? null),
                'business_area' => $validatedData['business_area'] ?? null,
                'hari' => $validatedData['hari'] ?? null,
                'tanggal' => $this->parseIndonesianDate($validatedData['tanggal'] ?? null),
                
                'nama_penyerah' => $validatedData['nama_penyerah'] ?? null,
                'nipp_penyerah' => $validatedData['nipp_penyerah'] ?? null,
                'jabatan_penyerah' => $validatedData['jabatan_penyerah'] ?? null,
                'tempat_kedudukan_penyerah' => $validatedData['tempat_kedudukan_penyerah'] ?? null,
                'personal_area_penyerah' => $validatedData['personal_area_penyerah'] ?? null,
                
                'nama_penerima' => $validatedData['nama_penerima'] ?? null,
                'nipp_penerima' => $validatedData['nipp_penerima'] ?? null,
                'jabatan_penerima' => $validatedData['jabatan_penerima'] ?? null,
                'tempat_kedudukan_penerima' => $validatedData['tempat_kedudukan_penerima'] ?? null,
                'personal_area_penerima' => $validatedData['personal_area_penerima'] ?? null,
                'owner_responsible_penerima' => $validatedData['owner_responsible_penerima'] ?? null,
                'custodian_penerima' => $validatedData['custodian_penerima'] ?? null,
                
                'keperluan' => $validatedData['keperluan'] ?? null,
                'masa_aktif_mulai' => $this->parseIndonesianDate($validatedData['masa_aktif_mulai'] ?? null),
                'masa_aktif_selesai' => $this->parseIndonesianDate($validatedData['masa_aktif_selesai'] ?? null),
                
                'nama_yang_menyerahkan' => $validatedData['nama_yang_menyerahkan'] ?? $validatedData['nama_penyerah'] ?? null,
                'nipp_yang_menyerahkan' => $validatedData['nipp_yang_menyerahkan'] ?? $validatedData['nipp_penyerah'] ?? null,
                'nama_yang_menerima' => $validatedData['nama_yang_menerima'] ?? $validatedData['nama_penerima'] ?? null,
                'nipp_yang_menerima' => $validatedData['nipp_yang_menerima'] ?? $validatedData['nipp_penerima'] ?? null,
                'tempat_ttd' => $validatedData['tempat_ttd'] ?? $validatedData['tempat_kedudukan_penyerah'] ?? null,
                'tanggal_ttd' => $this->parseIndonesianDate($validatedData['tanggal_ttd'] ?? $validatedData['tanggal'] ?? null),
            ]);

            if (isset($validatedData['items']) && is_array($validatedData['items'])) {
                foreach ($validatedData['items'] as $itemData) {
                    if (empty($itemData['nama_aplikasi']) && empty($itemData['username']) && empty($itemData['password'])) {
                        continue;
                    }
                    FormSerahTerimaUserItem::create([
                        'form_serah_terima_user_id' => $form->id,
                        'nama_aplikasi' => $itemData['nama_aplikasi'] ?? null,
                        'username' => $itemData['username'] ?? null,
                        'password' => $itemData['password'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('form-serah-terima-user.index')->with('success', 'Formulir Serah Terima User Aplikasi Berhasil Ditambahkan.');
    }

    public function show(string $id)
    {
        $form = FormSerahTerimaUser::with('items')->findOrFail($id);
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Berita Acara Serah Terima User Aplikasi')
            ->orWhere('nama', 'like', '%Serah Terima User%')
            ->first();
        $masterUsers = MasterSerahTerimaUser::orderBy('nama', 'asc')->get();
        return view('form-serah-terima-user.show', compact('form', 'formTemplate', 'masterUsers'));
    }

    public function preview(string $id)
    {
        $form = FormSerahTerimaUser::with('items')->findOrFail($id);
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Berita Acara Serah Terima User Aplikasi')
            ->orWhere('nama', 'like', '%Serah Terima User%')
            ->first();
        return view('form-serah-terima-user.preview', compact('form', 'formTemplate'));
    }

    public function edit(string $id)
    {
        $form = FormSerahTerimaUser::with('items')->findOrFail($id);
        $formTemplate = \App\Models\FormTemplate::where('nama', 'Berita Acara Serah Terima User Aplikasi')
            ->orWhere('nama', 'like', '%Serah Terima User%')
            ->first();
            
        $masterUsers = MasterSerahTerimaUser::orderBy('nama', 'asc')->get();
        
        $businessAreaList = FormSerahTerimaUser::whereNotNull('business_area')->distinct()->pluck('business_area');
        $tempatKedudukanList = FormSerahTerimaUser::whereNotNull('tempat_kedudukan_penyerah')->distinct()->pluck('tempat_kedudukan_penyerah');
        $personalAreaList = FormSerahTerimaUser::whereNotNull('personal_area_penyerah')->distinct()->pluck('personal_area_penyerah');

        return view('form-serah-terima-user.edit', compact(
            'form', 'formTemplate', 'masterUsers', 
            'businessAreaList', 'tempatKedudukanList', 'personalAreaList'
        ));
    }

    public function update(Request $request, string $id)
    {
        $form = FormSerahTerimaUser::findOrFail($id);

        $validatedData = $request->validate([
            'no_ref' => 'nullable|string|max:255',
            'tanggal_ref' => 'nullable|string',
            'business_area' => 'nullable|string|max:255',
            'hari' => 'nullable|string|max:255',
            'tanggal' => 'nullable|string',
            
            // Penyerah
            'nama_penyerah' => 'nullable|string|max:255',
            'nipp_penyerah' => 'nullable|string|max:255',
            'jabatan_penyerah' => 'nullable|string|max:255',
            'tempat_kedudukan_penyerah' => 'nullable|string|max:255',
            'personal_area_penyerah' => 'nullable|string|max:255',
            
            // Penerima
            'nama_penerima' => 'nullable|string|max:255',
            'nipp_penerima' => 'nullable|string|max:255',
            'jabatan_penerima' => 'nullable|string|max:255',
            'tempat_kedudukan_penerima' => 'nullable|string|max:255',
            'personal_area_penerima' => 'nullable|string|max:255',
            'owner_responsible_penerima' => 'nullable|string|max:255',
            'custodian_penerima' => 'nullable|string|max:255',
            
            'keperluan' => 'nullable|string',
            'focus_keperluan' => 'nullable|string', // hidden indicator if updating from show view
            'masa_aktif_mulai' => 'nullable|string',
            'masa_aktif_selesai' => 'nullable|string',
            
            // Tanda Tangan
            'nama_yang_menyerahkan' => 'nullable|string|max:255',
            'nipp_yang_menyerahkan' => 'nullable|string|max:255',
            'nama_yang_menerima' => 'nullable|string|max:255',
            'nipp_yang_menerima' => 'nullable|string|max:255',
            'tempat_ttd' => 'nullable|string|max:255',
            'tanggal_ttd' => 'nullable|string',
            
            'items' => 'nullable|array',
            'items.*.nama_aplikasi' => 'nullable|string|max:255',
            'items.*.username' => 'nullable|string|max:255',
            'items.*.password' => 'nullable|string|max:255',
        ]);

        // Detect if update is coming from signature edit (show view) or main edit form
        $isFromSignatureEdit = $request->has('from_show') || $request->has('nama_yang_menyerahkan');

        DB::transaction(function () use ($form, $validatedData, $isFromSignatureEdit) {
            $namaPenyerah = $validatedData['nama_penyerah'] ?? $form->nama_penyerah;
            $nippPenyerah = $validatedData['nipp_penyerah'] ?? $form->nipp_penyerah;
            $namaPenerima = $validatedData['nama_penerima'] ?? $form->nama_penerima;
            $nippPenerima = $validatedData['nipp_penerima'] ?? $form->nipp_penerima;

            $updateData = [
                'no_ref' => $validatedData['no_ref'] ?? $form->no_ref,
                'tanggal_ref' => isset($validatedData['tanggal_ref']) ? $this->parseIndonesianDate($validatedData['tanggal_ref']) : $form->tanggal_ref,
                'business_area' => $validatedData['business_area'] ?? $form->business_area,
                'hari' => $validatedData['hari'] ?? $form->hari,
                'tanggal' => isset($validatedData['tanggal']) ? $this->parseIndonesianDate($validatedData['tanggal']) : $form->tanggal,
                
                'nama_penyerah' => $namaPenyerah,
                'nipp_penyerah' => $nippPenyerah,
                'jabatan_penyerah' => $validatedData['jabatan_penyerah'] ?? $form->jabatan_penyerah,
                'tempat_kedudukan_penyerah' => $validatedData['tempat_kedudukan_penyerah'] ?? $form->tempat_kedudukan_penyerah,
                'personal_area_penyerah' => $validatedData['personal_area_penyerah'] ?? $form->personal_area_penyerah,
                
                'nama_penerima' => $namaPenerima,
                'nipp_penerima' => $nippPenerima,
                'jabatan_penerima' => $validatedData['jabatan_penerima'] ?? $form->jabatan_penerima,
                'tempat_kedudukan_penerima' => $validatedData['tempat_kedudukan_penerima'] ?? $form->tempat_kedudukan_penerima,
                'personal_area_penerima' => $validatedData['personal_area_penerima'] ?? $form->personal_area_penerima,
                'owner_responsible_penerima' => $validatedData['owner_responsible_penerima'] ?? $form->owner_responsible_penerima,
                'custodian_penerima' => $validatedData['custodian_penerima'] ?? $form->custodian_penerima,
                
                'keperluan' => $validatedData['keperluan'] ?? $form->keperluan,
                'masa_aktif_mulai' => isset($validatedData['masa_aktif_mulai']) ? $this->parseIndonesianDate($validatedData['masa_aktif_mulai']) : $form->masa_aktif_mulai,
                'masa_aktif_selesai' => isset($validatedData['masa_aktif_selesai']) ? $this->parseIndonesianDate($validatedData['masa_aktif_selesai']) : $form->masa_aktif_selesai,
                
                // When editing from main edit form, sync signature fields with penyerah/penerima
                // When editing from signature view (show), use the dedicated signature fields
                'nama_yang_menyerahkan' => $isFromSignatureEdit
                    ? ($validatedData['nama_yang_menyerahkan'] ?? $form->nama_yang_menyerahkan)
                    : $namaPenyerah,
                'nipp_yang_menyerahkan' => $isFromSignatureEdit
                    ? ($validatedData['nipp_yang_menyerahkan'] ?? $form->nipp_yang_menyerahkan)
                    : $nippPenyerah,
                'nama_yang_menerima' => $isFromSignatureEdit
                    ? ($validatedData['nama_yang_menerima'] ?? $form->nama_yang_menerima)
                    : $namaPenerima,
                'nipp_yang_menerima' => $isFromSignatureEdit
                    ? ($validatedData['nipp_yang_menerima'] ?? $form->nipp_yang_menerima)
                    : $nippPenerima,
                'tempat_ttd' => $isFromSignatureEdit
                    ? ($validatedData['tempat_ttd'] ?? $form->tempat_ttd)
                    : ($validatedData['tempat_kedudukan_penyerah'] ?? $form->tempat_kedudukan_penyerah),
                'tanggal_ttd' => $isFromSignatureEdit
                    ? (isset($validatedData['tanggal_ttd']) ? $this->parseIndonesianDate($validatedData['tanggal_ttd']) : $form->tanggal_ttd)
                    : (isset($validatedData['tanggal']) ? $this->parseIndonesianDate($validatedData['tanggal']) : $form->tanggal),
            ];

            $form->update($updateData);

            // Only recreate items if items array is explicitly submitted in the request
            // This avoids deletion of items when updating signatures from the show view
            if (isset($validatedData['items'])) {
                $form->items()->delete();
                foreach ($validatedData['items'] as $itemData) {
                    if (empty($itemData['nama_aplikasi']) && empty($itemData['username']) && empty($itemData['password'])) {
                        continue;
                    }
                    FormSerahTerimaUserItem::create([
                        'form_serah_terima_user_id' => $form->id,
                        'nama_aplikasi' => $itemData['nama_aplikasi'] ?? null,
                        'username' => $itemData['username'] ?? null,
                        'password' => $itemData['password'] ?? null,
                    ]);
                }
            }
        });

        // Redirect back if request is from the show/print view
        if ($request->has('from_show') || $request->has('nama_yang_menyerahkan')) {
            return redirect()->route('form-serah-terima-user.show', $form->id)->with('success', 'Tanda Tangan Berhasil Disimpan.');
        }

        return redirect()->route('form-serah-terima-user.index')->with('success', 'Formulir Serah Terima User Aplikasi Berhasil Diperbarui.');
    }

    public function destroy(string $id)
    {
        $form = FormSerahTerimaUser::findOrFail($id);
        $form->delete();
        return redirect()->route('form-serah-terima-user.index')->with('success', 'Formulir Serah Terima User Aplikasi Berhasil Dihapus.');
    }

    private function parseIndonesianDate($dateStr)
    {
        if (empty($dateStr)) return null;
        
        $months = [
            'Januari' => '01', 'Februari' => '02', 'Maret' => '03', 'April' => '04',
            'Mei' => '05', 'Juni' => '06', 'Juli' => '07', 'Agustus' => '08',
            'September' => '09', 'Oktober' => '10', 'November' => '11', 'Desember' => '12',
            'Jan' => '01', 'Feb' => '02', 'Mar' => '03', 'Apr' => '04',
            'Jun' => '06', 'Jul' => '07', 'Agu' => '08', 'Sep' => '09',
            'Okt' => '10', 'Nov' => '11', 'Des' => '12',
            'January' => '01', 'February' => '02', 'March' => '03', 'May' => '05',
            'June' => '06', 'July' => '07', 'August' => '08', 'October' => '10', 'December' => '12'
        ];
        
        $tempStr = str_replace('-', ' ', $dateStr);
        
        foreach ($months as $id => $num) {
            if (stripos($tempStr, $id) !== false) {
                $tempStr = str_ireplace($id, $num, $tempStr);
                $parts = array_values(array_filter(explode(' ', trim($tempStr))));
                if (count($parts) >= 3) {
                    return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                }
            }
        }
        
        return (strtotime($dateStr) !== false) ? date('Y-m-d', strtotime($dateStr)) : null;
    }
}
