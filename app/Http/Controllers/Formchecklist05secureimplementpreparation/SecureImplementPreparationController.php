<?php

namespace App\Http\Controllers;

use App\Models\SecureImplementPreparation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class SecureImplementPreparationController extends Controller
{
    /**
     * Menampilkan daftar formulir + pencarian.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $forms = SecureImplementPreparation::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('no_ref', 'like', "%{$search}%")
                        ->orWhere('nama_aplikasi', 'like', "%{$search}%")
                        ->orWhere('business_area', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'secure-implement-preparation.index',
            compact('forms', 'search')
        );
    }


    /**
     * Menampilkan halaman tambah formulir.
     */
    public function create()
    {
        $form = new SecureImplementPreparation();

        return view(
            'secure-implement-preparation.create',
            compact('form')
        );
    }


    /**
     * Menyimpan formulir baru.
     */
    public function store(Request $request)
    {
        $data = $this->validateForm($request);

        SecureImplementPreparation::create($data);

        return redirect()
            ->route('secure-implement-preparation.index')
            ->with(
                'success',
                'Formulir berhasil disimpan.'
            );
    }


    /**
     * Menampilkan detail formulir.
     */
    public function show(
        SecureImplementPreparation $secure_implement_preparation
    ) {
        $form = $secure_implement_preparation;

        return view(
            'secure-implement-preparation.show',
            compact('form')
        );
    }


    /**
     * Menampilkan halaman edit.
     */
    public function edit(
        SecureImplementPreparation $secure_implement_preparation
    ) {
        $form = $secure_implement_preparation;

        return view(
            'secure-implement-preparation.edit',
            compact('form')
        );
    }


    /**
     * Memperbarui formulir.
     */
    public function update(
        Request $request,
        SecureImplementPreparation $secure_implement_preparation
    ) {
        $data = $this->validateForm(
            $request,
            $secure_implement_preparation->id
        );

        $secure_implement_preparation->update($data);

        return redirect()
            ->route('secure-implement-preparation.index')
            ->with(
                'success',
                'Formulir berhasil diperbarui.'
            );
    }


    /**
     * Menghapus formulir.
     */
    public function destroy(
        SecureImplementPreparation $secure_implement_preparation
    ) {
        $secure_implement_preparation->delete();

        return redirect()
            ->route('secure-implement-preparation.index')
            ->with(
                'success',
                'Formulir berhasil dihapus.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | IMPORT DATA
    |--------------------------------------------------------------------------
    */

    /**
     * Import data dari Excel / CSV.
     */
    public function import(Request $request)
    {
        /*
         * Validasi file.
         */
        $request->validate([
            'import_file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:5120',
            ],
        ]);


        try {

            /*
             * Ambil file.
             */
            $file = $request->file('import_file');


            /*
             * Baca spreadsheet.
             */
            $spreadsheet = IOFactory::load(
                $file->getRealPath()
            );

            $sheet = $spreadsheet
                ->getActiveSheet()
                ->toArray(
                    null,
                    true,
                    true,
                    false
                );


            /*
             * Minimal:
             * baris 1 = header
             * baris 2 = data
             */
            if (count($sheet) < 2) {

                return back()->with(
                    'error',
                    'File tidak memiliki data untuk diimport.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | HEADER
            |--------------------------------------------------------------------------
            */

            $header = array_map(
                function ($value) {

                    return strtolower(
                        trim((string) $value)
                    );

                },
                $sheet[0]
            );


            /*
             * Header yang harus tersedia.
             */
            $requiredHeaders = [
                'no_ref',
                'tanggal',
                'business_area',
                'nama_aplikasi',
                'tanggal_checklist',
                'deskripsi',
                'versi_aplikasi',
                'modul',
                'fungsi',
                'check_tsd',
                'check_user_manual',
                'tempat',
                'tanggal_ttd',
                'mengetahui_nama',
                'mengetahui_nipp',
                'pelaksana_nama',
                'pelaksana_nipp',
            ];


            /*
             * Pastikan struktur file benar.
             */
            foreach ($requiredHeaders as $requiredHeader) {

                if (!in_array(
                    $requiredHeader,
                    $header,
                    true
                )) {

                    return back()->with(
                        'error',
                        "Kolom '{$requiredHeader}' tidak ditemukan. " .
                        "Silakan gunakan template import yang tersedia."
                    );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | IMPORT ROW
            |--------------------------------------------------------------------------
            */

            $success = 0;
            $failed = 0;

            $errors = [];


            foreach (
                array_slice($sheet, 1)
                as $index => $row
            ) {

                /*
                 * Nomor baris asli di Excel.
                 */
                $excelRow = $index + 2;


                /*
                 * Abaikan baris yang benar-benar kosong.
                 */
                $hasValue = false;

                foreach ($row as $value) {

                    if (
                        $value !== null &&
                        trim((string) $value) !== ''
                    ) {

                        $hasValue = true;
                        break;
                    }
                }


                if (!$hasValue) {
                    continue;
                }


                /*
                 * Samakan jumlah kolom.
                 */
                $row = array_pad(
                    $row,
                    count($header),
                    null
                );


                /*
                 * Gabungkan header dan data.
                 */
                $data = array_combine(
                    $header,
                    array_slice(
                        $row,
                        0,
                        count($header)
                    )
                );


                /*
                |--------------------------------------------------------------------------
                | CLEAN DATA
                |--------------------------------------------------------------------------
                */

                foreach ($data as $key => $value) {

                    if (is_string($value)) {

                        $data[$key] =
                            trim($value);
                    }
                }


                /*
                 * Normalisasi YA / TIDAK.
                 */
                $data['check_tsd'] =
                    strtoupper(
                        trim(
                            (string) (
                                $data['check_tsd']
                                ?? ''
                            )
                        )
                    );


                $data['check_user_manual'] =
                    strtoupper(
                        trim(
                            (string) (
                                $data['check_user_manual']
                                ?? ''
                            )
                        )
                    );


                /*
                 * Normalisasi tanggal.
                 */
                $data['tanggal'] =
                    $this->normalizeImportedDate(
                        $data['tanggal'] ?? null
                    );


                $data['tanggal_checklist'] =
                    $this->normalizeImportedDate(
                        $data['tanggal_checklist']
                            ?? null
                    );


                $data['tanggal_ttd'] =
                    $this->normalizeImportedDate(
                        $data['tanggal_ttd']
                            ?? null
                    );


                /*
                |--------------------------------------------------------------------------
                | VALIDATION
                |--------------------------------------------------------------------------
                */

                $validator = Validator::make(
                    $data,
                    [
                        'no_ref' => [
                            'required',
                            'string',
                            'max:100',
                            'unique:secure_implement_preparations,no_ref',
                        ],

                        'tanggal' => [
                            'required',
                            'date',
                        ],

                        'business_area' => [
                            'nullable',
                            'string',
                            'max:100',
                        ],

                        'nama_aplikasi' => [
                            'required',
                            'string',
                            'max:255',
                        ],

                        'tanggal_checklist' => [
                            'required',
                            'date',
                        ],

                        'deskripsi' => [
                            'nullable',
                            'string',
                        ],

                        'versi_aplikasi' => [
                            'nullable',
                            'string',
                            'max:100',
                        ],

                        'modul' => [
                            'nullable',
                            'string',
                            'max:255',
                        ],

                        'fungsi' => [
                            'nullable',
                            'string',
                        ],

                        'check_tsd' => [
                            'required',
                            'in:YA,TIDAK',
                        ],

                        'check_user_manual' => [
                            'required',
                            'in:YA,TIDAK',
                        ],

                        'tempat' => [
                            'nullable',
                            'string',
                            'max:100',
                        ],

                        'tanggal_ttd' => [
                            'nullable',
                            'date',
                        ],

                        'mengetahui_nama' => [
                            'nullable',
                            'string',
                            'max:255',
                        ],

                        'mengetahui_nipp' => [
                            'nullable',
                            'string',
                            'max:100',
                        ],

                        'pelaksana_nama' => [
                            'nullable',
                            'string',
                            'max:255',
                        ],

                        'pelaksana_nipp' => [
                            'nullable',
                            'string',
                            'max:100',
                        ],
                    ],
                    [
                        /*
                         * Pesan khusus agar hasil import
                         * lebih mudah dibaca user.
                         */

                        'no_ref.required' =>
                            'No. Ref wajib diisi.',

                        'no_ref.unique' =>
                            'No. Ref sudah digunakan.',

                        'tanggal.required' =>
                            'Tanggal wajib diisi.',

                        'tanggal.date' =>
                            'Format tanggal tidak valid.',

                        'nama_aplikasi.required' =>
                            'Nama aplikasi wajib diisi.',

                        'tanggal_checklist.required' =>
                            'Tanggal checklist wajib diisi.',

                        'tanggal_checklist.date' =>
                            'Format tanggal checklist tidak valid.',

                        'check_tsd.required' =>
                            'TSD wajib diisi.',

                        'check_tsd.in' =>
                            'TSD harus berisi YA atau TIDAK.',

                        'check_user_manual.required' =>
                            'User Manual wajib diisi.',

                        'check_user_manual.in' =>
                            'User Manual harus berisi YA atau TIDAK.',

                        'tanggal_ttd.date' =>
                            'Format tanggal tanda tangan tidak valid.',
                    ]
                );


                /*
                 * Jika baris gagal validasi,
                 * lanjutkan ke baris berikutnya.
                 */
                if ($validator->fails()) {

                    $failed++;

                    $errors[] =
                        "Baris {$excelRow}: " .
                        implode(
                            ' ',
                            $validator
                                ->errors()
                                ->all()
                        );

                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | SAVE
                |--------------------------------------------------------------------------
                */

                try {

                    SecureImplementPreparation::create(
                        $validator->validated()
                    );

                    $success++;

                } catch (\Throwable $e) {

                    $failed++;

                    $errors[] =
                        "Baris {$excelRow}: " .
                        "data gagal disimpan.";

                }
            }


            /*
            |--------------------------------------------------------------------------
            | RESULT
            |--------------------------------------------------------------------------
            */

            if ($success === 0) {

                return redirect()
                    ->route(
                        'secure-implement-preparation.index'
                    )
                    ->with(
                        'error',
                        "Tidak ada data yang berhasil diimport. " .
                        "{$failed} baris gagal."
                    )
                    ->with(
                        'import_errors',
                        $errors
                    );
            }


            $message =
                "{$success} data berhasil diimport.";


            if ($failed > 0) {

                $message .=
                    " {$failed} baris tidak berhasil diimport.";
            }


            return redirect()
                ->route(
                    'secure-implement-preparation.index'
                )
                ->with(
                    'success',
                    $message
                )
                ->with(
                    'import_errors',
                    $errors
                );


        } catch (\Throwable $e) {

            return redirect()
                ->route(
                    'secure-implement-preparation.index'
                )
                ->with(
                    'error',
                    'File gagal diproses. Pastikan file ' .
                    'menggunakan template yang tersedia.'
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD TEMPLATE
    |--------------------------------------------------------------------------
    */

    /**
     * Download template Excel untuk import.
     */
    public function downloadTemplate()
    {
        /*
         * Buat workbook.
         */
        $spreadsheet = new Spreadsheet();

        $sheet =
            $spreadsheet->getActiveSheet();

        $sheet->setTitle(
            'Import Formulir'
        );


        /*
        |--------------------------------------------------------------------------
        | HEADER
        |--------------------------------------------------------------------------
        */

        $headers = [
            'no_ref',
            'tanggal',
            'business_area',
            'nama_aplikasi',
            'tanggal_checklist',
            'deskripsi',
            'versi_aplikasi',
            'modul',
            'fungsi',
            'check_tsd',
            'check_user_manual',
            'tempat',
            'tanggal_ttd',
            'mengetahui_nama',
            'mengetahui_nipp',
            'pelaksana_nama',
            'pelaksana_nipp',
        ];


        foreach (
            $headers as $index => $header
        ) {

            $column =
                Coordinate::stringFromColumnIndex(
                    $index + 1
                );

            $sheet->setCellValue(
                $column . '1',
                $header
            );
        }


        /*
        |--------------------------------------------------------------------------
        | EXAMPLE
        |--------------------------------------------------------------------------
        */

        $example = [
            'SIP-001',
            '2026-10-02',
            'Teknologi Informasi',
            'Aplikasi Contoh',
            '2026-10-02',
            'Deskripsi aplikasi',
            '1.0',
            'Modul Utama',
            'Fungsi utama aplikasi',
            'YA',
            'YA',
            'Jakarta',
            '2026-10-02',
            'Nama Mengetahui',
            '123456',
            'Nama Pelaksana',
            '654321',
        ];


        foreach (
            $example as $index => $value
        ) {

            $column =
                Coordinate::stringFromColumnIndex(
                    $index + 1
                );

            $sheet->setCellValue(
                $column . '2',
                $value
            );
        }


        /*
        |--------------------------------------------------------------------------
        | HEADER STYLE
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getStyle('A1:Q1')
            ->getFont()
            ->setBold(true);


        /*
         * Freeze header.
         */
        $sheet->freezePane('A2');


        /*
         * Auto filter.
         */
        $sheet->setAutoFilter('A1:Q1');


        /*
         * Lebar kolom otomatis.
         */
        for ($i = 1; $i <= count($headers); $i++) {

            $column =
                Coordinate::stringFromColumnIndex($i);

            $sheet
                ->getColumnDimension($column)
                ->setAutoSize(true);
        }


        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD
        |--------------------------------------------------------------------------
        */

        $fileName =
            'template_import_secure_implement_preparation.xlsx';


        $tempFile =
            tempnam(
                sys_get_temp_dir(),
                'secure_import_'
            );


        $writer =
            new Xlsx($spreadsheet);

        $writer->save($tempFile);


        /*
         * Bersihkan object spreadsheet.
         */
        $spreadsheet
            ->disconnectWorksheets();

        unset($spreadsheet);


        return response()
            ->download(
                $tempFile,
                $fileName
            )
            ->deleteFileAfterSend(true);
    }


    /*
    |--------------------------------------------------------------------------
    | NORMALIZE IMPORTED DATE
    |--------------------------------------------------------------------------
    */

    /**
     * Mengubah tanggal dari Excel/CSV menjadi YYYY-MM-DD.
     */
    private function normalizeImportedDate($value)
    {
        /*
         * Nullable.
         */
        if (
            $value === null ||
            $value === ''
        ) {
            return null;
        }


        /*
         * Excel dapat menyimpan tanggal
         * sebagai serial number.
         */
        if (is_numeric($value)) {

            try {

                return ExcelDate::excelToDateTimeObject(
                    $value
                )->format('Y-m-d');

            } catch (\Throwable $e) {

                return $value;
            }
        }


        /*
         * Jika sudah YYYY-MM-DD,
         * langsung gunakan.
         */
        $value =
            trim((string) $value);


        $date =
            \DateTime::createFromFormat(
                '!Y-m-d',
                $value
            );


        if (
            $date &&
            $date->format('Y-m-d') === $value
        ) {

            return $value;
        }


        /*
         * Mendukung DD-MM-YYYY.
         */
        $date =
            \DateTime::createFromFormat(
                '!d-m-Y',
                $value
            );


        if (
            $date &&
            $date->format('d-m-Y') === $value
        ) {

            return $date->format(
                'Y-m-d'
            );
        }


        /*
         * Mendukung DD/MM/YYYY.
         */
        $date =
            \DateTime::createFromFormat(
                '!d/m/Y',
                $value
            );


        if (
            $date &&
            $date->format('d/m/Y') === $value
        ) {

            return $date->format(
                'Y-m-d'
            );
        }


        /*
         * Biarkan validator menentukan
         * apakah format lainnya valid.
         */
        return $value;
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDASI FORM MANUAL
    |--------------------------------------------------------------------------
    */

    /**
     * Validasi create dan edit.
     */
    private function validateForm(
        Request $request,
        $id = null
    ) {
        return $request->validate([

            'no_ref' => [
                'required',
                'string',
                'max:100',
                'unique:secure_implement_preparations,no_ref,' . $id,
            ],

            'tanggal' =>
                'required|date',

            'business_area' =>
                'nullable|string|max:100',

            'nama_aplikasi' =>
                'required|string|max:255',

            'tanggal_checklist' =>
                'required|date',

            'deskripsi' =>
                'nullable|string',

            'versi_aplikasi' =>
                'nullable|string|max:100',

            'modul' =>
                'nullable|string|max:255',

            'fungsi' =>
                'nullable|string',

            'check_tsd' =>
                'required|in:YA,TIDAK',

            'check_user_manual' =>
                'required|in:YA,TIDAK',

            'tempat' =>
                'nullable|string|max:100',

            'tanggal_ttd' =>
                'nullable|date',

            'mengetahui_nama' =>
                'nullable|string|max:255',

            'mengetahui_nipp' =>
                'nullable|string|max:100',

            'pelaksana_nama' =>
                'nullable|string|max:255',

            'pelaksana_nipp' =>
                'nullable|string|max:100',
        ]);
    }
}