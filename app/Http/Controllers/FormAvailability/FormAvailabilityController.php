<?php

namespace App\Http\Controllers\FormAvailability;

use App\Exports\FormAvailability\FormAvailabilityExport;
use App\Http\Controllers\Controller;
use App\Models\FormAvailability\FormAvailability;
use App\Models\FormAvailability\MasterBusinessArea;
use App\Models\FormCctv\MasterSigner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class FormAvailabilityController extends Controller
{
    public function index(Request $request)
    {
        /*
         * Pencarian daftar formulir.
         */
        $search = trim(
            (string) $request->query('search', '')
        );

        /*
         * Pencarian Master Signer.
         */
        $signerSearch = trim(
            (string) $request->query(
                'signer_search',
                ''
            )
        );

        /*
         * Pencarian Master Business Area.
         */
        $baSearch = trim(
            (string) $request->query(
                'ba_search',
                ''
            )
        );

        $forms = FormAvailability::with([
            'items',
            'mengetahui',
        ])
            ->when(
                $search !== '',
                function ($query) use ($search) {
                    $query->where(
                        function ($subQuery) use ($search) {
                            $subQuery
                                ->where(
                                    'no_ref',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'business_area',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'daop_divre',
                                    'like',
                                    "%{$search}%"
                                );
                        }
                    );
                }
            )
            ->latest()
            ->paginate(
                10,
                ['*'],
                'page'
            )
            ->withQueryString();

        $masterSigners = MasterSigner::query()
            ->when(
                $signerSearch !== '',
                function ($query) use ($signerSearch) {
                    $query->where(
                        function ($subQuery) use (
                            $signerSearch
                        ) {
                            $subQuery
                                ->where(
                                    'nama',
                                    'like',
                                    "%{$signerSearch}%"
                                )
                                ->orWhere(
                                    'nipp',
                                    'like',
                                    "%{$signerSearch}%"
                                )
                                ->orWhere(
                                    'jabatan',
                                    'like',
                                    "%{$signerSearch}%"
                                );
                        }
                    );
                }
            )
            ->orderBy('nama')
            ->paginate(
                10,
                ['*'],
                'signer_page'
            )
            ->withQueryString();

        $masterBusinessAreas = MasterBusinessArea::query()
            ->when(
                $baSearch !== '',
                function ($query) use ($baSearch) {
                    $query->where(
                        function ($subQuery) use ($baSearch) {
                            $subQuery
                                ->where(
                                    'kode',
                                    'like',
                                    "%{$baSearch}%"
                                )
                                ->orWhere(
                                    'daop_divre',
                                    'like',
                                    "%{$baSearch}%"
                                );
                        }
                    );
                }
            )
            ->orderBy('kode')
            ->paginate(
                10,
                ['*'],
                'ba_page'
            )
            ->withQueryString();

        return view(
            'form-availability.index',
            compact(
                'forms',
                'masterSigners',
                'masterBusinessAreas',
                'search',
                'signerSearch',
                'baSearch'
            )
        );
    }

    public function create()
    {
        $masterSigners = MasterSigner::orderBy('nama')->get();
        $masterBusinessAreas = MasterBusinessArea::orderBy('kode')->get();

        return view(
            'form-availability.create',
            compact('masterSigners', 'masterBusinessAreas')
        );
    }

    public function store(Request $request)
    {
        $validated = $this->validateForm($request);

        DB::transaction(function () use ($validated) {
            $form = FormAvailability::create([
                'no_ref' =>
                    $validated['no_ref'] ?? null,

                'tanggal' =>
                    $validated['tanggal'],

                'business_area' =>
                    $validated['business_area'],

                'daop_divre' =>
                    $validated['daop_divre'],

                'jumlah_total_station' =>
                    $validated['jumlah_total_station'],

                'jumlah_perangkat_ticketing' =>
                    $validated['jumlah_perangkat_ticketing'],

                'catatan' =>
                    $validated['catatan'] ?? null,

                'petugas_name' =>
                    $validated['petugas_name'] ?? null,

                'petugas_nipp' =>
                    $validated['petugas_nipp'] ?? null,

                'mengetahui_id' =>
                    $validated['mengetahui_id'] ?? null,

                'mengetahui_nipp_mode' => 'master',

                'mengetahui_nama_override' => null,

                'mengetahui_nipp_override' => null,

                'status' => 'draft',
            ]);

            foreach (
                $validated['items'] as $index => $item
            ) {
                $form->items()->create([
                    'nomor' => $index + 1,

                    'station' =>
                        $item['station'],

                    'rts_pts_ng' =>
                        $item['rts_pts_ng'],

                    'jumlah_perangkat_ticketing' =>
                        $item['jumlah_perangkat_ticketing'],

                    'jumlah_gangguan' =>
                        $item['jumlah_gangguan'],

                    'lama_gangguan' =>
                        $item['lama_gangguan'],

                    'keterangan' =>
                        $item['keterangan'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('form-availability.index')
            ->with(
                'success',
                'Form Availability berhasil dibuat.'
            );
    }

    public function show(
        FormAvailability $form_availability
    ) {
        $form_availability->load([
            'items',
            'mengetahui',
        ]);

        return view(
            'form-availability.show',
            compact('form_availability')
        );
    }

    public function edit(
        FormAvailability $form_availability
    ) {
        $form_availability->load([
            'items',
            'mengetahui',
        ]);

        $masterSigners = MasterSigner::orderBy('nama')->get();
        $masterBusinessAreas = MasterBusinessArea::orderBy('kode')->get();

        return view(
            'form-availability.edit',
            compact(
                'form_availability',
                'masterSigners',
                'masterBusinessAreas'
            )
        );
    }

    public function update(
        Request $request,
        FormAvailability $form_availability
    ) {
        $validated = $this->validateForm($request);

        DB::transaction(function () use (
            $validated,
            $form_availability
        ) {
            $form_availability->update([
                'no_ref' =>
                    $validated['no_ref'] ?? null,

                'tanggal' =>
                    $validated['tanggal'],

                'business_area' =>
                    $validated['business_area'],

                'daop_divre' =>
                    $validated['daop_divre'],

                'jumlah_total_station' =>
                    $validated['jumlah_total_station'],

                'jumlah_perangkat_ticketing' =>
                    $validated['jumlah_perangkat_ticketing'],

                'catatan' =>
                    $validated['catatan'] ?? null,

                'petugas_name' =>
                    $validated['petugas_name'] ?? null,

                'petugas_nipp' =>
                    $validated['petugas_nipp'] ?? null,

                'mengetahui_id' =>
                    $validated['mengetahui_id'] ?? null,

                'mengetahui_nipp_mode' => 'master',

                'mengetahui_nama_override' => null,

                'mengetahui_nipp_override' => null,
            ]);

            /*
             * Detail lama dihapus lalu dibuat ulang.
             */
            $form_availability->items()->delete();

            foreach (
                $validated['items'] as $index => $item
            ) {
                $form_availability->items()->create([
                    'nomor' => $index + 1,

                    'station' =>
                        $item['station'],

                    'rts_pts_ng' =>
                        $item['rts_pts_ng'],

                    'jumlah_perangkat_ticketing' =>
                        $item['jumlah_perangkat_ticketing'],

                    'jumlah_gangguan' =>
                        $item['jumlah_gangguan'],

                    'lama_gangguan' =>
                        $item['lama_gangguan'],

                    'keterangan' =>
                        $item['keterangan'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route(
                'form-availability.show',
                $form_availability
            )
            ->with(
                'success',
                'Form Availability berhasil diperbarui.'
            );
    }

    public function confirm(
        FormAvailability $form_availability
    ) {
        $mode =
            $form_availability->mode_penandatangan;

        if (
            $mode === 'master'
            && !$form_availability->mengetahui_id
        ) {
            return back()->withErrors([
                'mengetahui_id' =>
                    'Master Sign harus dipilih sebelum form diselesaikan.',
            ]);
        }

        if (
            $mode === 'custom'
            && blank(
                $form_availability
                    ->mengetahui_nama_override
            )
        ) {
            return back()->withErrors([
                'mengetahui_nama_override' =>
                    'Jabatan dan nama manual harus diisi sebelum form diselesaikan.',
            ]);
        }

        $form_availability->update([
            'status' => 'selesai',
        ]);

        return back()->with(
            'success',
            'Form berhasil dikonfirmasi sebagai selesai.'
        );
    }

    public function exportExcel(
        FormAvailability $form_availability
    ) {
        $form_availability->load([
            'items',
            'mengetahui',
        ]);

        $reference = $form_availability->no_ref
            ?: (string) $form_availability->id;

        $safeReference = preg_replace(
            '/[^A-Za-z0-9_-]+/',
            '-',
            $reference
        );

        $fileName =
            "availability-ticketing-{$safeReference}.xlsx";

        return Excel::download(
            new FormAvailabilityExport(
                $form_availability
            ),
            $fileName
        );
    }

    public function destroy(
        FormAvailability $form_availability
    ) {
        $form_availability->delete();

        return redirect()
            ->route('form-availability.index')
            ->with(
                'success',
                'Form Availability berhasil dihapus.'
            );
    }

    private function validateForm(
        Request $request
    ): array {
        return $request->validate([
            'no_ref' => [
                'nullable',
                'string',
                'max:255',
            ],

            'tanggal' => [
                'required',
                'date',
            ],

            'business_area' => [
                'required',
                'string',
                'max:255',
            ],

            'daop_divre' => [
                'required',
                'string',
                'max:255',
            ],

            'jumlah_total_station' => [
                'required',
                'integer',
                'min:0',
            ],

            'jumlah_perangkat_ticketing' => [
                'required',
                'integer',
                'min:0',
            ],

            'catatan' => [
                'nullable',
                'string',
            ],

            'petugas_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'petugas_nipp' => [
                'nullable',
                'string',
                'max:50',
            ],

            'mengetahui_id' => [
                'required',
                'integer',
                'exists:master_signers,id',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.nomor' => [
                'nullable',
                'integer',
            ],

            'items.*.station' => [
                'required',
                'string',
                'max:255',
            ],

            'items.*.rts_pts_ng' => [
                'required',
                'string',
                'max:50',
            ],

            'items.*.jumlah_perangkat_ticketing' => [
                'required',
                'integer',
                'min:0',
            ],

            'items.*.jumlah_gangguan' => [
                'required',
                'integer',
                'min:0',
            ],

            'items.*.lama_gangguan' => [
                'required',
                'integer',
                'min:0',
            ],

            'items.*.keterangan' => [
                'nullable',
                'string',
            ],
        ], [
            'tanggal.required' =>
                'Tanggal laporan wajib diisi.',

            'business_area.required' =>
                'Business Area wajib diisi.',

            'daop_divre.required' =>
                'DAOP/DIVRE wajib diisi.',

            'jumlah_total_station.required' =>
                'Jumlah total stasiun wajib diisi.',

            'jumlah_perangkat_ticketing.required' =>
                'Jumlah total perangkat wajib diisi.',

            'mengetahui_id.required' =>
                'Master Sign wajib dipilih.',

            'mengetahui_id.exists' =>
                'Pejabat yang dipilih tidak ditemukan.',

            'items.required' =>
                'Minimal harus ada satu data stasiun.',

            'items.min' =>
                'Minimal harus ada satu data stasiun.',

            'items.*.station.required' =>
                'Nama stasiun wajib diisi.',

            'items.*.rts_pts_ng.required' =>
                'Jenis RTS wajib dipilih.',

            'items.*.jumlah_perangkat_ticketing.required' =>
                'Jumlah perangkat setiap stasiun wajib diisi.',

            'items.*.jumlah_gangguan.required' =>
                'Jumlah gangguan wajib diisi.',

            'items.*.lama_gangguan.required' =>
                'Lama gangguan wajib diisi.',
        ]);
    }

    public function storeBusinessArea(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:100',
            'daop_divre' => 'required|string|max:255',
        ], [
            'kode.required' => 'Kode Business Area wajib diisi.',
            'daop_divre.required' => 'DAOP/DIVRE wajib diisi.',
        ]);

        MasterBusinessArea::create($validated);

        return redirect()
            ->route('form-availability.index')
            ->with('success', 'Master Business Area berhasil ditambahkan.');
    }

    public function updateBusinessArea(Request $request, MasterBusinessArea $masterBusinessArea)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:100',
            'daop_divre' => 'required|string|max:255',
        ], [
            'kode.required' => 'Kode Business Area wajib diisi.',
            'daop_divre.required' => 'DAOP/DIVRE wajib diisi.',
        ]);

        $masterBusinessArea->update($validated);

        return redirect()
            ->route('form-availability.index')
            ->with('success', 'Master Business Area berhasil diperbarui.');
    }

    public function destroyBusinessArea(MasterBusinessArea $masterBusinessArea)
    {
        $masterBusinessArea->delete();

        return redirect()
            ->route('form-availability.index')
            ->with('success', 'Master Business Area berhasil dihapus.');
    }

    public function getBusinessAreas()
    {
        $data = MasterBusinessArea::orderBy('kode')->get();
        return response()->json($data);
    }
}
