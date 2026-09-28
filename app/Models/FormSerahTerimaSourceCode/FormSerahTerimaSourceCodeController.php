<?php

namespace App\Http\Controllers\FormSerahTerimaSourceCode;

use App\Http\Controllers\Controller;
use App\Models\FormSerahTerimaSourceCode\FormSerahTerimaSourceCode;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class FormSerahTerimaSourceCodeController extends Controller
{
    private function normalizeFormPayload(array $payload): array
    {
        $payload['hari_serah_terima'] = $payload['hari_serah_terima'] ?? ($payload['hari'] ?? null);
        $payload['tanggal_serah_terima'] = $payload['tanggal_serah_terima'] ?? ($payload['tanggal_dibuat'] ?? null);
        $payload['pihak_pertama_nama'] = $payload['pihak_pertama_nama'] ?? ($payload['pihak_pertama_diwakili'] ?? null);
        $payload['pihak_kedua_diwakili_nama'] = $payload['pihak_kedua_diwakili_nama'] ?? ($payload['pihak_kedua_diwakili'] ?? null);
        $payload['pihak_kedua_diwakili_jabatan'] = $payload['pihak_kedua_diwakili_jabatan'] ?? ($payload['pihak_kedua_jabatan'] ?? null);
        $payload['database_yang_digunakan'] = $payload['database_yang_digunakan'] ?? ($payload['database_digunakan'] ?? null);
        $payload['jenis_serah_terima_lain'] = $payload['jenis_serah_terima_lain'] ?? ($payload['jenis_serah_terima_lainnya'] ?? null);
        $payload['halaman_dokumen'] = $payload['halaman_dokumen'] ?? ($payload['halaman'] ?? null);

        if (isset($payload['pihak_pertama_diwakili']) && empty($payload['pihak_pertama_nama'])) {
            $payload['pihak_pertama_nama'] = $payload['pihak_pertama_diwakili'];
        }

        if (isset($payload['jenis_serah_terima']) && is_array($payload['jenis_serah_terima'])) {
            $payload['jenis_serah_terima'] = implode(',', array_filter($payload['jenis_serah_terima']));
        }

        if (isset($payload['modul_aplikasi']) && is_array($payload['modul_aplikasi'])) {
            $payload['modul_aplikasi'] = implode("\n", array_filter($payload['modul_aplikasi'], fn ($value) => $value !== null && $value !== ''));
        }

        if (isset($payload['no_ref']) && empty($payload['nomor_dokumen'])) {
            $payload['nomor_dokumen'] = $payload['no_ref'];
        }

        if (isset($payload['tanggal']) && empty($payload['tanggal_serah_terima'])) {
            $payload['tanggal_serah_terima'] = $payload['tanggal'];
        }

        return $payload;
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
        $forms = FormSerahTerimaSourceCode::when($search, function ($query, $search) {
            return $query->where('nama_aplikasi', 'like', "%{$search}%")
                         ->orWhere('pihak_kedua_nama', 'like', "%{$search}%")
                         ->orWhere('pihak_kedua_alamat', 'like', "%{$search}%");
        })->orderBy('created_at', 'desc')->paginate(10, ['*'], 'form_page');

        $forms->appends(['search' => $search]);

        return view('form-serah-terima-source-code.index', compact('forms', 'search'));
    }

    public function create()
    {
        $form = new FormSerahTerimaSourceCode();
        return view('form-serah-terima-source-code.create', compact('form'));
    }

    public function store(Request $request)
    {
        $validated = $this->normalizeFormPayload($request->validate([
            'nomor_dokumen' => 'nullable|string|max:255',
            'tanggal_terbit' => 'nullable|date',
            'versi_dokumen' => 'nullable|string|max:255',
            'halaman_dokumen' => 'nullable|string|max:255',
            'halaman' => 'nullable|string|max:255',
            'hari_serah_terima' => 'nullable|string|max:255',
            'hari' => 'nullable|string|max:255',
            'tanggal_serah_terima' => 'nullable|date',
            'tanggal_dibuat' => 'nullable|date',
            'tanggal' => 'nullable|date',
            'tanggal_str' => 'nullable|string|max:2',
            'bulan' => 'nullable|string|max:255',
            'tahun' => 'nullable|string|max:255',
            'no_ref' => 'nullable|string|max:255',
            'business_area' => 'nullable|string|max:255',
            'pihak_pertama_nama' => 'nullable|string|max:255',
            'pihak_pertama_diwakili' => 'nullable|string|max:255',
            'pihak_pertama_jabatan' => 'nullable|string|max:255',
            'pihak_kedua_nama' => 'nullable|string|max:255',
            'pihak_kedua_alamat' => 'nullable|string|max:500',
            'pihak_kedua_diwakili' => 'nullable|string|max:255',
            'pihak_kedua_diwakili_nama' => 'nullable|string|max:255',
            'pihak_kedua_jabatan' => 'nullable|string|max:255',
            'pihak_kedua_diwakili_jabatan' => 'nullable|string|max:255',
            'jenis_serah_terima' => 'nullable',
            'jenis_serah_terima_lain' => 'nullable|string|max:255',
            'jenis_serah_terima_lainnya' => 'nullable|string|max:255',
            'nama_aplikasi' => 'nullable|string|max:255',
            'versi_aplikasi' => 'nullable|string|max:255',
            'deskripsi_aplikasi' => 'nullable|string',
            'modul_aplikasi' => 'nullable',
            'bahasa_pemrograman' => 'nullable|string|max:255',
            'database_yang_digunakan' => 'nullable|string|max:255',
            'database_digunakan' => 'nullable|string|max:255',
            'development_platform' => 'nullable|string|max:255',
            'catatan_lain' => 'nullable|string',
            'nama_ttd_pihak_pertama' => 'nullable|string|max:255',
            'nama_ttd_pihak_kedua' => 'nullable|string|max:255',
        ]));

        FormSerahTerimaSourceCode::create($validated);

        return redirect()->route('form-serah-terima-source-code.index')->with('success', 'Formulir Serah Terima Source Code berhasil disimpan.');
    }

    public function show(FormSerahTerimaSourceCode $form_serah_terima_source_code)
    {
        return view('form-serah-terima-source-code.show', ['form' => $form_serah_terima_source_code]);
    }

    public function print(FormSerahTerimaSourceCode $form_serah_terima_source_code)
    {
        return view('form-serah-terima-source-code.print', ['form' => $form_serah_terima_source_code]);
    }

    public function edit(FormSerahTerimaSourceCode $form_serah_terima_source_code)
    {
        return view('form-serah-terima-source-code.edit', ['form' => $form_serah_terima_source_code]);
    }

    public function update(Request $request, FormSerahTerimaSourceCode $form_serah_terima_source_code)
    {
        $validated = $this->normalizeFormPayload($request->validate([
            'nomor_dokumen' => 'nullable|string|max:255',
            'tanggal_terbit' => 'nullable|date',
            'versi_dokumen' => 'nullable|string|max:255',
            'halaman_dokumen' => 'nullable|string|max:255',
            'halaman' => 'nullable|string|max:255',
            'hari_serah_terima' => 'nullable|string|max:255',
            'hari' => 'nullable|string|max:255',
            'tanggal_serah_terima' => 'nullable|date',
            'tanggal_dibuat' => 'nullable|date',
            'tanggal' => 'nullable|date',
            'tanggal_str' => 'nullable|string|max:2',
            'bulan' => 'nullable|string|max:255',
            'tahun' => 'nullable|string|max:255',
            'no_ref' => 'nullable|string|max:255',
            'business_area' => 'nullable|string|max:255',
            'pihak_pertama_nama' => 'nullable|string|max:255',
            'pihak_pertama_diwakili' => 'nullable|string|max:255',
            'pihak_pertama_jabatan' => 'nullable|string|max:255',
            'pihak_kedua_nama' => 'nullable|string|max:255',
            'pihak_kedua_alamat' => 'nullable|string|max:500',
            'pihak_kedua_diwakili' => 'nullable|string|max:255',
            'pihak_kedua_diwakili_nama' => 'nullable|string|max:255',
            'pihak_kedua_jabatan' => 'nullable|string|max:255',
            'pihak_kedua_diwakili_jabatan' => 'nullable|string|max:255',
            'jenis_serah_terima' => 'nullable',
            'jenis_serah_terima_lain' => 'nullable|string|max:255',
            'jenis_serah_terima_lainnya' => 'nullable|string|max:255',
            'nama_aplikasi' => 'nullable|string|max:255',
            'versi_aplikasi' => 'nullable|string|max:255',
            'deskripsi_aplikasi' => 'nullable|string',
            'modul_aplikasi' => 'nullable',
            'bahasa_pemrograman' => 'nullable|string|max:255',
            'database_yang_digunakan' => 'nullable|string|max:255',
            'database_digunakan' => 'nullable|string|max:255',
            'development_platform' => 'nullable|string|max:255',
            'catatan_lain' => 'nullable|string',
            'nama_ttd_pihak_pertama' => 'nullable|string|max:255',
            'nama_ttd_pihak_kedua' => 'nullable|string|max:255',
        ]));

        $form_serah_terima_source_code->update($validated);

        return redirect()->route('form-serah-terima-source-code.index')->with('success', 'Formulir berhasil diperbarui.');
    }

    public function destroy(FormSerahTerimaSourceCode $form_serah_terima_source_code)
    {
        $form_serah_terima_source_code->delete();
        return redirect()->route('form-serah-terima-source-code.index')->with('success', 'Formulir berhasil dihapus.');
    }

    public function exportDocx(FormSerahTerimaSourceCode $form_serah_terima_source_code)
    {
        try {
            $phpWord = new PhpWord();
            $section = $phpWord->addSection([
                'pageSizeW' => 11906, // A4 width in twip ~210mm
                'pageSizeH' => 16838,
                'marginTop' => 900,
                'marginBottom' => 900,
                'marginLeft' => 900,
                'marginRight' => 900,
            ]);

            $tableStyle = ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50];
            $phpWord->addTableStyle('HeaderTable', $tableStyle, []);
            $table = $section->addTable('HeaderTable');
            $table->addRow();
            $table->addCell(3000)->addImage(public_path('images/logo-kai.svg'), ['width' => 120, 'height' => 60]);
            $table->addCell(3500)->addText("PT KERETA API INDONESIA\n(PERSERO)\nSISTEM INFORMASI", ['bold' => true, 'size' => 10], ['align' => 'center']);
            $cell = $table->addCell(3000);
            $cell->addText('Nomor: ' . ($form_serah_terima_source_code->nomor_dokumen ?: '__________'));
            $cell->addText('Tanggal Terbit: ' . ($form_serah_terima_source_code->tanggal_terbit?->format('d F Y') ?: '__________'));
            $cell->addText('Versi: ' . ($form_serah_terima_source_code->versi_dokumen ?: '__________'));
            $cell->addText('Halaman: ' . ($form_serah_terima_source_code->halaman_dokumen ?: '__________'));

            $section->addTextBreak(1);
            $section->addText('BERITA ACARA SERAH TERIMA SOURCE CODE APLIKASI', ['bold' => true, 'size' => 14], ['align' => 'center']);
            $section->addTextBreak(1);

            $section->addText("Berita Acara Serah Terima ini dibuat pada hari: " . ($form_serah_terima_source_code->hari_serah_terima ?: '______________'));
            $section->addText("Tanggal: " . ($form_serah_terima_source_code->tanggal_serah_terima?->format('d F Y') ?: '______________'));

            $section->addTextBreak(1);
            $section->addText("PIHAK PERTAMA: " . ($form_serah_terima_source_code->pihak_pertama_nama ?: '______________') . ' - ' . ($form_serah_terima_source_code->pihak_pertama_jabatan ?: '______________'));
            $section->addText("PIHAK KEDUA: " . ($form_serah_terima_source_code->pihak_kedua_nama ?: '______________') . ' - ' . ($form_serah_terima_source_code->pihak_kedua_alamat ?: '______________'));

            $section->addTextBreak(1);
            $section->addText('Jenis Serah Terima:');
            $jenis = $form_serah_terima_source_code->jenis_serah_terima ?? '';
            $section->addText(' - Aplikasi termasuk source code dan struktur database: ' . ($jenis === 'app_dan_db' ? 'V' : ''));
            $section->addText(' - Source code aplikasi/modul atau fungsi/services: ' . ($jenis === 'sourcecode_modul' ? 'V' : ''));
            $section->addText(' - Lain-lain: ' . ($form_serah_terima_source_code->jenis_serah_terima_lain ?: ''));

            $section->addTextBreak(1);
            $section->addText('Nama Aplikasi: ' . ($form_serah_terima_source_code->nama_aplikasi ?: '______________'));
            $section->addText('Versi Aplikasi: ' . ($form_serah_terima_source_code->versi_aplikasi ?: '______________'));
            $section->addText('Deskripsi Aplikasi: ' . ($form_serah_terima_source_code->deskripsi_aplikasi ?: '______________'));
            $section->addText('Modul dalam Aplikasi: ' . ($form_serah_terima_source_code->modul_aplikasi ?: '______________'));
            $section->addText('Bahasa Pemrograman: ' . ($form_serah_terima_source_code->bahasa_pemrograman ?: '______________'));
            $section->addText('Database yang digunakan: ' . ($form_serah_terima_source_code->database_yang_digunakan ?: '______________'));
            $section->addText('Development Platform: ' . ($form_serah_terima_source_code->development_platform ?: '______________'));

            $section->addTextBreak(2);
            $table2 = $section->addTable(['borderSize' => 0]);
            $table2->addRow();
            $table2->addCell(5000)->addText('PIHAK PERTAMA');
            $table2->addCell(5000)->addText('PIHAK KEDUA');
            $table2->addRow();
            $table2->addCell(5000)->addTextBreak(4);
            $table2->addCell(5000)->addTextBreak(4);
            $table2->addRow();
            $table2->addCell(5000)->addText('Nama dan Tanda Tangan');
            $table2->addCell(5000)->addText('Nama dan Tanda Tangan');

            $fileName = 'Berita_Acara_Serah_Terima_SourceCode_' . $form_serah_terima_source_code->id . '.docx';
            $tempPath = sys_get_temp_dir() . '/' . $fileName;

            $writer = IOFactory::createWriter($phpWord, 'Word2007');
            $writer->save($tempPath);

            return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Ekspor .docx gagal. Pastikan paket phpoffice/phpword telah diinstal.');
        }
    }
}
