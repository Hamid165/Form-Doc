<?php

namespace App\Exports\FormMonitoringGrounding;

use App\Models\FormMonitoringGrounding\FormMonitoringGrounding;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class MonitoringGroundingExport implements WithEvents
{
    protected $form;
    protected $formTemplate;

    public function __construct(FormMonitoringGrounding $form, $formTemplate = null)
    {
        $this->form = $form->load('items');
        $this->formTemplate = $formTemplate;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $form = $this->form;
                $tpl = $this->formTemplate;

                // ========== PAGE SETUP ==========
                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setFitToWidth(1);
                $sheet->getPageSetup()->setFitToHeight(0);
                $sheet->getPageMargins()->setTop(0.4);
                $sheet->getPageMargins()->setBottom(0.4);
                $sheet->getPageMargins()->setLeft(0.5);
                $sheet->getPageMargins()->setRight(0.5);

                // ========== COLUMN WIDTHS ==========
                // A=No(4), B=Lokasi(25), C=Nilai standard(20), D=Hasil(18), E=Kondisi bak(25), F=Tindak lanjut(25), G=extra(14), H=extra(20)
                $sheet->getColumnDimension('A')->setWidth(4);
                $sheet->getColumnDimension('B')->setWidth(25);
                $sheet->getColumnDimension('C')->setWidth(20);
                $sheet->getColumnDimension('D')->setWidth(18);
                $sheet->getColumnDimension('E')->setWidth(25);
                $sheet->getColumnDimension('F')->setWidth(25);
                $sheet->getColumnDimension('G')->setWidth(14);
                $sheet->getColumnDimension('H')->setWidth(20);

                $noDokumen = $tpl->no_dokumen ?? 'FR.SM/TI/015.018/10-2020';
                $tglTerbit = $tpl->tanggal_dokumen ?? '12 Oktober 2020';
                $versi = $tpl->versi_dokumen ?? '002-2020';

                $tanggal = $form->tanggal;
                if ($tanggal && preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
                    $tanggal = \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('d - m - Y');
                }

                $thinBorder = [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ];
                $allBorders = ['borders' => ['allBorders' => $thinBorder]];
                $outlineBorders = ['borders' => ['outline' => $thinBorder]];

                // ========== ROW 1-2: KOP SURAT (Baris Atas) ==========
                $sheet->mergeCells('A1:A2');
                $sheet->setCellValue('A1', 'KAI');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'italic' => true, 'size' => 18, 'color' => ['rgb' => '1F3B7C']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);

                $sheet->mergeCells('B1:E2');
                $sheet->setCellValue('B1', "PT KERETA API INDONESIA (PERSERO)\nSISTEM INFORMASI");
                $sheet->getStyle('B1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                ]);

                $sheet->setCellValue('F1', 'Nomor');
                $sheet->mergeCells('G1:H1');
                $sheet->setCellValue('G1', ': ' . $noDokumen);

                $sheet->setCellValue('F2', 'Tanggal Terbit');
                $sheet->mergeCells('G2:H2');
                $sheet->setCellValue('G2', ': ' . $tglTerbit);

                // ========== ROW 3-4: KOP SURAT (Baris Bawah) ==========
                $sheet->mergeCells('A3:A4');
                $sheet->setCellValue('A3', 'TERBATAS');
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 10, 'color' => ['rgb' => 'D97706']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders' => ['outline' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => 'D97706']]],
                ]);

                $sheet->mergeCells('B3:E4');
                $sheet->setCellValue('B3', 'FORMULIR MONITORING GROUNDING');
                $sheet->getStyle('B3')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);

                $sheet->setCellValue('F3', 'Versi');
                $sheet->mergeCells('G3:H3');
                $sheet->setCellValue('G3', ': ' . $versi);

                $sheet->setCellValue('F4', 'Halaman');
                $sheet->mergeCells('G4:H4');
                $sheet->setCellValue('G4', ': 1 dari 1');

                // Apply borders to KOP rows 1-4
                $sheet->getStyle('A1:H4')->applyFromArray($allBorders);
                $sheet->getRowDimension(1)->setRowHeight(22);
                $sheet->getRowDimension(2)->setRowHeight(22);
                $sheet->getRowDimension(3)->setRowHeight(22);
                $sheet->getRowDimension(4)->setRowHeight(22);

                // ========== ROW 5: Empty spacer ==========
                $sheet->getRowDimension(5)->setRowHeight(6);

                // ========== ROW 6-8: REFERENSI ==========
                $sheet->mergeCells('A6:B6');
                $sheet->setCellValue('A6', 'No. Ref');
                $sheet->mergeCells('C6:D6');
                $sheet->setCellValue('C6', ': ' . ($form->no_ref ?: '__/__/____'));

                $sheet->mergeCells('A7:B7');
                $sheet->setCellValue('A7', 'Tanggal');
                $sheet->mergeCells('C7:D7');
                $sheet->setCellValue('C7', ': ' . ($tanggal ?: '__ - __ - ____'));

                $sheet->mergeCells('A8:B8');
                $sheet->setCellValue('A8', 'Business Area');
                $sheet->mergeCells('C8:D8');
                $sheet->setCellValue('C8', ': ' . ($form->business_area ?: '____'));

                $sheet->getStyle('A6:D8')->applyFromArray($allBorders);
                $sheet->getStyle('A6:B8')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 10],
                ]);

                // ========== ROW 9: Empty spacer ==========
                $sheet->getRowDimension(9)->setRowHeight(6);

                // ========== ROW 10: BULAN ==========
                $sheet->mergeCells('A10:H10');
                $sheet->setCellValue('A10', 'Bulan          : ' . ($form->bulan ?: '......................................................'));
                $sheet->getStyle('A10')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 10],
                ]);

                // ========== ROW 11: Empty spacer ==========
                $sheet->getRowDimension(11)->setRowHeight(6);

                // ========== ROW 12: TABLE HEADER ==========
                $headerRow = 12;
                $sheet->setCellValue("A{$headerRow}", 'No.');
                $sheet->setCellValue("B{$headerRow}", 'Lokasi grounding');
                $sheet->setCellValue("C{$headerRow}", "Nilai grounding standard\n(OHM)");
                $sheet->setCellValue("D{$headerRow}", "Hasil pengukuran     (OHM)");
                $sheet->setCellValue("E{$headerRow}", 'Kondisi bak grounding');
                $sheet->mergeCells("F{$headerRow}:H{$headerRow}");
                $sheet->setCellValue("F{$headerRow}", 'Tindak lanjut');

                $sheet->getStyle("A{$headerRow}:H{$headerRow}")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 10],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D4D4D4']],
                    'borders' => ['allBorders' => $thinBorder],
                ]);
                $sheet->getRowDimension($headerRow)->setRowHeight(30);

                // ========== DATA ROWS ==========
                $items = $form->items->sortBy('no')->values();
                $minRows = 4;
                $dataRowCount = max($minRows, $items->count());
                $startDataRow = $headerRow + 1;

                for ($i = 0; $i < $dataRowCount; $i++) {
                    $row = $startDataRow + $i;
                    $item = $items[$i] ?? null;

                    $sheet->setCellValue("A{$row}", $i + 1);
                    $sheet->setCellValue("B{$row}", $item->lokasi_grounding ?? '');
                    $sheet->setCellValue("C{$row}", $item->nilai_grounding_standard ?? '≤ 1  OHM');
                    $sheet->setCellValue("D{$row}", $item->hasil_pengukuran ?? '');
                    $sheet->setCellValue("E{$row}", $item->kondisi_bak_grounding ?? '');
                    $sheet->mergeCells("F{$row}:H{$row}");
                    $sheet->setCellValue("F{$row}", $item->tindak_lanjut ?? '');

                    $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("C{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getRowDimension($row)->setRowHeight(25);
                }

                $lastDataRow = $startDataRow + $dataRowCount - 1;
                $sheet->getStyle("A{$startDataRow}:H{$lastDataRow}")->applyFromArray([
                    'font' => ['size' => 10],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                    'borders' => ['allBorders' => $thinBorder],
                ]);

                // ========== END OF FILE ==========
                $eofRow = $lastDataRow + 1;
                $sheet->mergeCells("A{$eofRow}:H{$eofRow}");
                $sheet->setCellValue("A{$eofRow}", '--- End of File ---');
                $sheet->getStyle("A{$eofRow}")->applyFromArray([
                    'font' => ['italic' => true, 'color' => ['rgb' => '666666']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // ========== FOOTER: TGL PELAKSANAAN, NAMA PETUGAS, PARAF ==========
                $footerStart = $eofRow + 1;

                $sheet->mergeCells("A{$footerStart}:B{$footerStart}");
                $sheet->setCellValue("A{$footerStart}", 'Tgl pelaksanaan');
                $sheet->getStyle("A{$footerStart}")->getFont()->setBold(true);
                $sheet->mergeCells("C{$footerStart}:D{$footerStart}");
                $sheet->setCellValue("C{$footerStart}", ': ' . ($form->tgl_pelaksanaan ?: ''));

                $row2 = $footerStart + 1;
                $sheet->mergeCells("A{$row2}:B{$row2}");
                $sheet->setCellValue("A{$row2}", 'Nama Petugas');
                $sheet->getStyle("A{$row2}")->getFont()->setBold(true);
                $sheet->mergeCells("C{$row2}:D{$row2}");
                $sheet->setCellValue("C{$row2}", ': ' . ($form->nama_petugas ?: ''));

                $row3 = $footerStart + 2;
                $sheet->mergeCells("A{$row3}:B{$row3}");
                $sheet->setCellValue("A{$row3}", 'Paraf Petugas');
                $sheet->getStyle("A{$row3}")->getFont()->setBold(true);
                $sheet->mergeCells("C{$row3}:D{$row3}");
                $sheet->setCellValue("C{$row3}", ': ' . ($form->paraf_petugas ?: ''));

                $sheet->getStyle("A{$footerStart}:D{$row3}")->applyFromArray($allBorders);

                // ========== SPACER ==========
                $spacerRow = $row3 + 1;
                $sheet->getRowDimension($spacerRow)->setRowHeight(6);

                // ========== CATATAN & MENGETAHUI ==========
                $catatanStart = $spacerRow + 1;
                $catatanEnd = $catatanStart + 5;

                // Catatan section (left side: A-E) - with border
                $sheet->mergeCells("A{$catatanStart}:E{$catatanEnd}");
                $sheet->setCellValue("A{$catatanStart}", "Catatan :\n" . ($form->catatan ?: ''));
                $sheet->getStyle("A{$catatanStart}")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 10],
                    'alignment' => ['vertical' => Alignment::VERTICAL_TOP, 'wrapText' => true],
                ]);
                $sheet->getStyle("A{$catatanStart}:E{$catatanEnd}")->applyFromArray($allBorders);

                // Mengetahui section (right side: F-H) - tanpa border luar
                $sheet->mergeCells("F{$catatanStart}:H{$catatanStart}");
                $sheet->setCellValue("F{$catatanStart}", 'Mengetahui,');
                $sheet->getStyle("F{$catatanStart}")->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Location + date (auto from business area + tanggal)
                $baLocationMap = ['B060' => 'Yogyakarta', 'B010' => 'Jakarta', 'B020' => 'Bandung', 'B030' => 'Cirebon', 'B040' => 'Semarang', 'B050' => 'Surabaya', 'B070' => 'Madiun', 'B080' => 'Purwokerto'];
                $lokasi = $baLocationMap[$form->business_area] ?? ($form->business_area ?? '');
                $tglFormatted = '';
                if ($tanggal) {
                    $tglFormatted = $tanggal;
                }
                $lokasiTanggal = $lokasi . ($tglFormatted ? ', ' . $tglFormatted : '');

                $lokasiRow = $catatanStart + 1;
                $sheet->mergeCells("F{$lokasiRow}:H{$lokasiRow}");
                $sheet->setCellValue("F{$lokasiRow}", $lokasiTanggal);
                $sheet->getStyle("F{$lokasiRow}")->applyFromArray([
                    'font' => ['size' => 9],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Empty space for signature
                $sheet->mergeCells("F" . ($catatanStart + 2) . ":H" . ($catatanStart + 2));

                // Name with dotted line
                $sigNameRow = $catatanStart + 3;
                $sheet->mergeCells("F{$sigNameRow}:H{$sigNameRow}");
                $sheet->setCellValue("F{$sigNameRow}", ($form->mengetahui_nama ?: '...................................'));
                $sheet->getStyle("F{$sigNameRow}")->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'borders' => ['bottom' => ['borderStyle' => Border::BORDER_DOTTED]],
                ]);

                // Jabatan
                $jabatanRow = $catatanStart + 4;
                $sheet->mergeCells("F{$jabatanRow}:H{$jabatanRow}");
                $sheet->setCellValue("F{$jabatanRow}", $form->mengetahui_jabatan ?: '');
                $sheet->getStyle("F{$jabatanRow}")->applyFromArray([
                    'font' => ['size' => 9],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // NIPP
                $nippRow = $catatanEnd;
                $sheet->mergeCells("F{$nippRow}:H{$nippRow}");
                $sheet->setCellValue("F{$nippRow}", 'NIPP: ' . ($form->mengetahui_nipp ?: '..................'));
                $sheet->getStyle("F{$nippRow}")->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Set row heights for catatan area
                for ($r = $catatanStart; $r <= $catatanEnd; $r++) {
                    $sheet->getRowDimension($r)->setRowHeight(18);
                }
            };
