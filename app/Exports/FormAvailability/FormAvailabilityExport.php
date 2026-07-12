<?php

namespace App\Exports\FormAvailability;

use App\Models\FormAvailability\FormAvailability;
use App\Models\FormTemplate;
use Carbon\Carbon;
use DateTimeInterface;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Throwable;

class FormAvailabilityExport implements
    FromArray,
    WithColumnWidths,
    WithEvents,
    WithTitle
{
    /**
     * Baris pertama data tabel.
     */
    private const DETAIL_START_ROW = 19;

    private FormAvailability $form;

    private ?FormTemplate $template;

    private int $detailEndRow;

    private int $noteTitleRow;

    private int $noteValueRow;

    private int $footerStartRow;

    private int $signatureTitleRow;

    private int $signatureNameRow;

    private int $signatureNippRow;

    private int $officerRow;

    public function __construct(FormAvailability $form)
    {
        $this->form = $form;

        /*
         * Ambil data yang diinput melalui web.
         */
        $this->form->loadMissing([
            'items',
            'mengetahui',
        ]);

        /*
         * Metadata dokumen.
         */
        $this->template = FormTemplate::query()
            ->where(
                'nama',
                'Availability System Ticketing'
            )
            ->first();

        /*
         * Jumlah baris tabel mengikuti jumlah data dari web.
         * Tidak dipaksa menjadi 20 baris.
         */
        $detailRowCount = max(
            1,
            $this->form->items->count()
        );

        $this->detailEndRow =
            self::DETAIL_START_ROW
            + $detailRowCount
            - 1;

        /*
         * Posisi footer otomatis mengikuti baris data terakhir.
         */
        $this->noteTitleRow =
            $this->detailEndRow + 2;

        $this->noteValueRow =
            $this->noteTitleRow + 1;

        $this->footerStartRow =
            $this->noteValueRow + 2;

        $this->signatureTitleRow =
            $this->footerStartRow + 1;

        /*
         * Memberikan ruang dua baris untuk tanda tangan.
         */
        $this->signatureNameRow =
            $this->footerStartRow + 4;

        $this->signatureNippRow =
            $this->footerStartRow + 5;

        $this->officerRow =
            $this->footerStartRow + 6;
    }

    public function title(): string
    {
        return 'Formulir';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5.89,
            'B' => 23.22,
            'C' => 19.55,
            'D' => 14.22,
            'E' => 11.55,
            'F' => 17.33,
            'G' => 35.44,
        ];
    }

    public function array(): array
    {
        /*
         * Membuat jumlah baris sampai footer terakhir.
         */
        $rows = array_fill(
            0,
            $this->officerRow,
            array_fill(0, 7, '')
        );

        /*
         * Helper untuk mengisi berdasarkan nomor baris
         * dan nomor kolom Excel.
         */
        $put = static function (
            array &$target,
            int $row,
            int $column,
            mixed $value
        ): void {
            $target[$row - 1][$column - 1] = $value;
        };

        /*
         * =====================================================
         * HEADER DOKUMEN
         * =====================================================
         */

        $put(
            $rows,
            1,
            3,
            "PT KERETA API INDONESIA (PERSERO)\n"
            . 'SISTEM INFORMASI'
        );

        $put(
            $rows,
            1,
            6,
            'No. Dokumen'
        );

        $put(
            $rows,
            1,
            7,
            ': ' . (
                $this->template?->no_dokumen
                ?: 'FR.SM/TI/015.016/07-2026'
            )
        );

        $put(
            $rows,
            2,
            6,
            'Tanggal'
        );

        $put(
            $rows,
            2,
            7,
            ': ' . (
                $this->template?->tanggal_dokumen
                ?: '11 Juli 2026'
            )
        );

        $put(
            $rows,
            3,
            3,
            'FORMULIR AVAILABILITY SYSTEM TICKETING'
        );

        $put(
            $rows,
            3,
            6,
            'Versi'
        );

        $put(
            $rows,
            3,
            7,
            ': ' . (
                $this->template?->versi_dokumen
                ?: '001-2026'
            )
        );

        $put(
            $rows,
            4,
            6,
            'Halaman'
        );

        $put(
            $rows,
            4,
            7,
            ': 1 dari 1'
        );

        /*
         * =====================================================
         * INFORMASI REFERENSI
         * =====================================================
         */

        $put(
            $rows,
            7,
            1,
            'No Ref'
        );

        $put(
            $rows,
            7,
            3,
            ': ' . (
                $this->form->no_ref ?: '-'
            )
        );

        $put(
            $rows,
            8,
            1,
            'Tanggal'
        );

        $put(
            $rows,
            8,
            3,
            ': ' . $this->formatShortDate(
                $this->form->tanggal
            )
        );

        $put(
            $rows,
            9,
            1,
            'Business Area'
        );

        $put(
            $rows,
            9,
            3,
            ': ' . (
                $this->form->business_area ?: '-'
            )
        );

        /*
         * =====================================================
         * JUDUL LAPORAN
         * =====================================================
         */

        $put(
            $rows,
            12,
            1,
            'LAPORAN AVAILABILITY SYSTEM TICKETING'
        );

        /*
         * =====================================================
         * RINGKASAN LAPORAN
         * =====================================================
         */

        $put(
            $rows,
            13,
            1,
            'TANGGAL'
        );

        $put(
            $rows,
            13,
            3,
            ': ' . $this->formatLongDate(
                $this->form->tanggal
            )
        );

        $put(
            $rows,
            14,
            1,
            'DAOP/DIVRE'
        );

        $put(
            $rows,
            14,
            3,
            ': ' . strtoupper(
                $this->form->daop_divre ?: '-'
            )
        );

        $put(
            $rows,
            15,
            1,
            'JUMLAH TOTAL STASIUN DI DAERAH'
        );

        $put(
            $rows,
            15,
            3,
            ': ' . (int) (
                $this->form->jumlah_total_station ?? 0
            )
        );

        $put(
            $rows,
            16,
            1,
            'JUMLAH TOTAL PERANGKAT TICKETING DI DAERAH'
        );

        $put(
            $rows,
            16,
            3,
            ': ' . (int) (
                $this->form
                    ->jumlah_perangkat_ticketing
                ?? 0
            )
        );

        /*
         * =====================================================
         * HEADER TABEL
         * =====================================================
         */

        $put(
            $rows,
            17,
            1,
            'NO'
        );

        $put(
            $rows,
            17,
            2,
            'STASIUN'
        );

        $put(
            $rows,
            17,
            3,
            'RTS/RTS NG'
        );

        $put(
            $rows,
            17,
            4,
            'JUMLAH PERANGKAT TICKETING'
        );

        $put(
            $rows,
            17,
            5,
            'GANGGUAN'
        );

        $put(
            $rows,
            17,
            7,
            'KETERANGAN'
        );

        $put(
            $rows,
            18,
            5,
            'JUMLAH'
        );

        $put(
            $rows,
            18,
            6,
            'LAMA GANGGUAN (MENIT)'
        );

        /*
         * =====================================================
         * DATA TABEL DARI INPUT WEB
         * =====================================================
         */

        if ($this->form->items->isEmpty()) {
            $put(
                $rows,
                self::DETAIL_START_ROW,
                2,
                'Tidak ada data.'
            );
        } else {
            foreach (
                $this->form->items->values()
                as $index => $item
            ) {
                $row =
                    self::DETAIL_START_ROW
                    + $index;

                $put(
                    $rows,
                    $row,
                    1,
                    $index + 1
                );

                $put(
                    $rows,
                    $row,
                    2,
                    $item->station ?: '-'
                );

                $put(
                    $rows,
                    $row,
                    3,
                    $item->rts_pts_ng ?: '-'
                );

                $put(
                    $rows,
                    $row,
                    4,
                    (int) (
                        $item
                            ->jumlah_perangkat_ticketing
                        ?? 0
                    )
                );

                $put(
                    $rows,
                    $row,
                    5,
                    ($item->jumlah_gangguan ?? 0) > 0
                        ? (int) $item->jumlah_gangguan
                        : '-'
                );

                $put(
                    $rows,
                    $row,
                    6,
                    ($item->lama_gangguan ?? 0) > 0
                        ? (int) $item->lama_gangguan
                        : '-'
                );

                $put(
                    $rows,
                    $row,
                    7,
                    $item->keterangan ?: 'Nihil'
                );
            }
        }

        /*
         * =====================================================
         * KETERANGAN
         * =====================================================
         */

        $put(
            $rows,
            $this->noteTitleRow,
            1,
            'KETERANGAN:'
        );

        $put(
            $rows,
            $this->noteValueRow,
            1,
            $this->form->catatan ?: '-'
        );

        /*
         * =====================================================
         * FOOTER KIRI
         * =====================================================
         */

        $instructions = [
            'LAPORAN DIKIRIM SETIAP HARI JAM 10.00',

            'YANG DILAPORKAN KEJADIAN MULAI '
            . 'JAM 00.00 S/D 23.59',

            'KIRIM VIA EMAIL KE HELP DESK '
            . '(it.helpdesk@kai.id)',

            'PERANGKAT TICKETING MENCAKUP '
            . 'PC, SCANNER, PRINTER, DLL',

            'TERMASUK PADA LOKET, CIC, '
            . 'BOARDING, OA, CS, OPERATOR',
        ];

        foreach (
            $instructions as $index => $instruction
        ) {
            $put(
                $rows,
                $this->footerStartRow + $index,
                1,
                $instruction
            );
        }

        /*
         * =====================================================
         * FOOTER KANAN
         * =====================================================
         */

        $put(
            $rows,
            $this->footerStartRow,
            5,
            strtoupper(
                $this->form->daop_divre
                    ?: '................'
            )
            . ', '
            . $this->formatLongDate(
                $this->form->tanggal
            )
        );

        $put(
            $rows,
            $this->signatureTitleRow,
            5,
            "MENGETAHUI\n"
            . strtoupper(
                $this->form
                    ->mengetahui?->jabatan
                ?: 'SENIOR MANAGER/MANAGER/JM/ASMEN'
            )
        );

        $put(
            $rows,
            $this->signatureNameRow,
            5,
            strtoupper(
                $this->form
                    ->mengetahui?->nama
                ?: '-'
            )
        );

        $put(
            $rows,
            $this->signatureNippRow,
            5,
            'NIPP. '
            . (
                $this->form
                    ->mengetahui?->nipp
                ?: '-'
            )
        );

        /*
         * =====================================================
         * PETUGAS
         * =====================================================
         */

        $officer =
            'Petugas: '
            . (
                $this->form->petugas_name ?: '-'
            );

        if ($this->form->petugas_nipp) {
            $officer .=
                ' - NIPP '
                . $this->form->petugas_nipp;
        }

        $put(
            $rows,
            $this->officerRow,
            1,
            $officer
        );

        return $rows;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (
                AfterSheet $event
            ): void {
                $sheet =
                    $event->sheet->getDelegate();

                $this->mergeCells($sheet);

                $this->drawLogoAndCategory(
                    $sheet
                );

                $this->applyStyles($sheet);

                $this->setRowHeights($sheet);

                $this->configurePage($sheet);

                /*
                 * No Ref dipaksa menjadi teks.
                 */
                $sheet->setCellValueExplicit(
                    'C7',
                    ': ' . (
                        $this->form->no_ref ?: '-'
                    ),
                    DataType::TYPE_STRING
                );
            },
        ];
    }

    private function mergeCells(
        Worksheet $sheet
    ): void {
        $ranges = [
            /*
             * Header.
             */
            'A1:B2',
            'C1:E2',
            'A3:B4',
            'C3:E4',

            /*
             * Referensi.
             */
            'A7:B7',
            'C7:D7',

            'A8:B8',
            'C8:D8',

            'A9:B9',
            'C9:D9',

            /*
             * Judul.
             */
            'A12:G12',

            /*
             * Ringkasan.
             */
            'A13:B13',
            'C13:D13',

            'A14:B14',
            'C14:D14',

            'A15:B15',
            'C15:D15',

            'A16:B16',
            'C16:D16',

            /*
             * Header tabel.
             */
            'A17:A18',
            'B17:B18',
            'C17:C18',
            'D17:D18',
            'E17:F17',
            'G17:G18',

            /*
             * Keterangan.
             */
            "A{$this->noteTitleRow}:"
            . "G{$this->noteTitleRow}",

            "A{$this->noteValueRow}:"
            . "G{$this->noteValueRow}",

            /*
             * Petugas.
             */
            "A{$this->officerRow}:"
            . "G{$this->officerRow}",
        ];

        foreach ($ranges as $range) {
            $sheet->mergeCells($range);
        }

        /*
         * Footer sebelah kiri A:D.
         * Footer sebelah kanan E:G.
         */
        for (
            $row = $this->footerStartRow;
            $row <= $this->signatureNippRow;
            $row++
        ) {
            $sheet->mergeCells(
                "A{$row}:D{$row}"
            );

            $sheet->mergeCells(
                "E{$row}:G{$row}"
            );
        }
    }

    private function drawLogoAndCategory(
        Worksheet $sheet
    ): void {
        $logoPath = public_path(
            'images/logo-kai.png'
        );

        if (is_file($logoPath)) {
            $drawing = new Drawing();

            $drawing->setName(
                'Logo KAI'
            );

            $drawing->setDescription(
                'Logo PT Kereta Api Indonesia'
            );

            $drawing->setPath(
                $logoPath
            );

            $drawing->setHeight(42);

            $drawing->setCoordinates(
                'A1'
            );

            $drawing->setOffsetX(8);

            $drawing->setOffsetY(5);

            $drawing->setWorksheet(
                $sheet
            );
        } else {
            $sheet->setCellValue(
                'A1',
                'KAI'
            );

            $sheet->getStyle('A1:B2')
                ->getFont()
                ->setBold(true)
                ->setSize(20);

            $sheet->getStyle('A1:B2')
                ->getAlignment()
                ->setHorizontal(
                    Alignment::HORIZONTAL_CENTER
                )
                ->setVertical(
                    Alignment::VERTICAL_CENTER
                );
        }

        /*
         * Kotak kategori UMUM.
         */
        $sheet->setCellValue(
            'A3',
            'UMUM'
        );

        $sheet->getStyle('A3:B4')
            ->getFont()
            ->setBold(true)
            ->setSize(10)
            ->getColor()
            ->setARGB('FF00B050');

        $sheet->getStyle('A3:B4')
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        $sheet->getStyle('A3:B4')
            ->getBorders()
            ->getOutline()
            ->setBorderStyle(
                Border::BORDER_MEDIUM
            )
            ->getColor()
            ->setARGB('FF00B050');
    }

    private function applyStyles(
        Worksheet $sheet
    ): void {
        /*
         * Font default.
         */
        $sheet->getParent()
            ->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(9);

        /*
         * Header dokumen.
         */
        $sheet->getStyle('A1:G4')
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $sheet->getStyle('A1:G4')
            ->getAlignment()
            ->setVertical(
                Alignment::VERTICAL_CENTER
            )
            ->setWrapText(true);

        $sheet->getStyle('C1:E4')
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            )
            ->setWrapText(true);

        $sheet->getStyle('C1:E4')
            ->getFont()
            ->setBold(true);

        $sheet->getStyle('F1:G4')
            ->getFont()
            ->setSize(8);

        /*
         * Informasi referensi.
         */
        $sheet->getStyle('A7:A9')
            ->getFont()
            ->setBold(true);

        $sheet->getStyle('A7:D9')
            ->getAlignment()
            ->setVertical(
                Alignment::VERTICAL_CENTER
            )
            ->setWrapText(true);

        /*
         * Judul laporan.
         */
        $sheet->getStyle('A12:G12')
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        $sheet->getStyle('A12')
            ->getFont()
            ->setBold(true)
            ->setSize(11);

        /*
         * Ringkasan.
         */
        $sheet->getStyle('A13:A16')
            ->getFont()
            ->setBold(true);

        $sheet->getStyle('A13:D16')
            ->getAlignment()
            ->setVertical(
                Alignment::VERTICAL_CENTER
            )
            ->setWrapText(true);

        /*
         * Header tabel.
         */
        $sheet->getStyle('A17:G18')
            ->getFont()
            ->setBold(true);

        $sheet->getStyle('A17:G18')
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            )
            ->setWrapText(true);

        /*
         * Border tabel hanya sampai data terakhir.
         */
        $sheet->getStyle(
            'A17:G' . $this->detailEndRow
        )
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        /*
         * Kolom A sampai F rata tengah.
         */
        $sheet->getStyle(
            'A'
            . self::DETAIL_START_ROW
            . ':F'
            . $this->detailEndRow
        )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            )
            ->setWrapText(true);

        /*
         * Kolom keterangan rata kiri.
         */
        $sheet->getStyle(
            'G'
            . self::DETAIL_START_ROW
            . ':G'
            . $this->detailEndRow
        )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_LEFT
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            )
            ->setWrapText(true);

        /*
         * Judul keterangan.
         */
        $sheet->getStyle(
            "A{$this->noteTitleRow}:"
            . "G{$this->noteTitleRow}"
        )
            ->getFont()
            ->setBold(true);

        /*
         * Isi keterangan.
         */
        $sheet->getStyle(
            "A{$this->noteValueRow}:"
            . "G{$this->noteValueRow}"
        )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_LEFT
            )
            ->setVertical(
                Alignment::VERTICAL_TOP
            )
            ->setWrapText(true);

        /*
         * Footer kiri.
         */
        $instructionEndRow =
            $this->footerStartRow + 4;

        $sheet->getStyle(
            "A{$this->footerStartRow}:"
            . "D{$instructionEndRow}"
        )
            ->getFont()
            ->setBold(true)
            ->setSize(8);

        $sheet->getStyle(
            "A{$this->footerStartRow}:"
            . "D{$instructionEndRow}"
        )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_LEFT
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            )
            ->setWrapText(true);

        /*
         * Footer kanan.
         */
        $sheet->getStyle(
            "E{$this->footerStartRow}:"
            . "G{$this->signatureNippRow}"
        )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            )
            ->setVertical(
                Alignment::VERTICAL_CENTER
            )
            ->setWrapText(true);

        /*
         * Tempat dan tanggal rata kanan.
         */
        $sheet->getStyle(
            "E{$this->footerStartRow}:"
            . "G{$this->footerStartRow}"
        )
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_RIGHT
            );

        /*
         * Mengetahui dan jabatan.
         */
        $sheet->getStyle(
            "E{$this->signatureTitleRow}"
        )
            ->getFont()
            ->setBold(true)
            ->setSize(9);

        /*
         * Nama pejabat.
         */
        $sheet->getStyle(
            "E{$this->signatureNameRow}"
        )
            ->getFont()
            ->setBold(true);

        /*
         * Garis bawah nama pejabat.
         */
        $sheet->getStyle(
            "E{$this->signatureNameRow}:"
            . "G{$this->signatureNameRow}"
        )
            ->getBorders()
            ->getBottom()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        /*
         * Garis pemisah petugas.
         */
        $sheet->getStyle(
            "A{$this->officerRow}:"
            . "G{$this->officerRow}"
        )
            ->getBorders()
            ->getTop()
            ->setBorderStyle(
                Border::BORDER_THIN
            );

        $sheet->getStyle(
            "A{$this->officerRow}:"
            . "G{$this->officerRow}"
        )
            ->getAlignment()
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );
    }

    private function setRowHeights(
        Worksheet $sheet
    ): void {
        /*
         * Header.
         */
        foreach ([1, 2, 3, 4] as $row) {
            $sheet->getRowDimension($row)
                ->setRowHeight(24);
        }

        $sheet->getRowDimension(12)
            ->setRowHeight(22);

        $sheet->getRowDimension(15)
            ->setRowHeight(28);

        $sheet->getRowDimension(16)
            ->setRowHeight(28);

        $sheet->getRowDimension(17)
            ->setRowHeight(24);

        $sheet->getRowDimension(18)
            ->setRowHeight(34);

        /*
         * Tinggi baris data menyesuaikan isi keterangan.
         */
        $items =
            $this->form->items->values();

        for (
            $row = self::DETAIL_START_ROW;
            $row <= $this->detailEndRow;
            $row++
        ) {
            $itemIndex =
                $row - self::DETAIL_START_ROW;

            $description = (string) (
                $items
                    ->get($itemIndex)
                    ?->keterangan
                ?? ''
            );

            $lineCount = max(
                substr_count(
                    $description,
                    "\n"
                ) + 1,

                (int) ceil(
                    max(
                        1,
                        strlen($description)
                    ) / 48
                )
            );

            $height =
                $description === ''
                    ? 20
                    : min(
                        90,
                        max(
                            24,
                            $lineCount * 15
                        )
                    );

            $sheet->getRowDimension($row)
                ->setRowHeight($height);
        }

        /*
         * Keterangan.
         */
        $sheet->getRowDimension(
            $this->noteTitleRow
        )->setRowHeight(20);

        $sheet->getRowDimension(
            $this->noteValueRow
        )->setRowHeight(
            $this->calculateTextHeight(
                (string) (
                    $this->form->catatan ?: '-'
                ),
                75,
                30,
                75
            )
        );

        /*
         * Lima baris instruksi.
         */
        for (
            $row = $this->footerStartRow;
            $row <= $this->footerStartRow + 4;
            $row++
        ) {
            $sheet->getRowDimension($row)
                ->setRowHeight(19);
        }

        /*
         * Mengetahui dan jabatan.
         */
        $sheet->getRowDimension(
            $this->signatureTitleRow
        )->setRowHeight(32);

        /*
         * Ruang tanda tangan.
         */
        $sheet->getRowDimension(
            $this->signatureTitleRow + 1
        )->setRowHeight(24);

        $sheet->getRowDimension(
            $this->signatureTitleRow + 2
        )->setRowHeight(24);

        /*
         * Nama dan NIPP.
         */
        $sheet->getRowDimension(
            $this->signatureNameRow
        )->setRowHeight(22);

        $sheet->getRowDimension(
            $this->signatureNippRow
        )->setRowHeight(20);

        /*
         * Petugas.
         */
        $sheet->getRowDimension(
            $this->officerRow
        )->setRowHeight(22);
    }

    private function configurePage(
        Worksheet $sheet
    ): void {
        $sheet->getPageSetup()
            ->setOrientation(
                PageSetup::ORIENTATION_PORTRAIT
            )
            ->setPaperSize(
                PageSetup::PAPERSIZE_A4
            )
            ->setFitToPage(true)
            ->setFitToWidth(1)
            ->setFitToHeight(0)
            ->setPrintArea(
                "A1:G{$this->officerRow}"
            );

        $sheet->getPageMargins()
            ->setLeft(0.3)
            ->setRight(0.3)
            ->setTop(0.3)
            ->setBottom(0.3)
            ->setHeader(0)
            ->setFooter(0);

        $sheet->setShowGridlines(true);
    }

    private function formatShortDate(
        mixed $date
    ): string {
        return $this->parseDate($date)
            ?->format('d/m/Y')
            ?: '-';
    }

    private function formatLongDate(
        mixed $date
    ): string {
        $parsedDate =
            $this->parseDate($date);

        if (!$parsedDate) {
            return '-';
        }

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $parsedDate->format('d')
            . ' '
            . $months[
                (int) $parsedDate->format('n')
            ]
            . ' '
            . $parsedDate->format('Y');
    }

    private function parseDate(
        mixed $date
    ): ?Carbon {
        if (!$date) {
            return null;
        }

        try {
            if ($date instanceof Carbon) {
                return $date;
            }

            if (
                $date instanceof DateTimeInterface
            ) {
                return Carbon::instance($date);
            }

            return Carbon::parse($date);
        } catch (Throwable) {
            return null;
        }
    }

    private function calculateTextHeight(
        string $text,
        int $charactersPerLine,
        int $minimum,
        int $maximum
    ): int {
        $lineCount = max(
            substr_count($text, "\n") + 1,

            (int) ceil(
                max(
                    1,
                    strlen($text)
                ) / $charactersPerLine
            )
        );

        return min(
            $maximum,
            max(
                $minimum,
                $lineCount * 15
            )
        );
    }
}
