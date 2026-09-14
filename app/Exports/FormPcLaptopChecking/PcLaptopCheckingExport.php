<?php

namespace App\Exports\FormPcLaptopChecking;

use App\Models\FormPcLaptopChecking\FormPcLaptopChecking;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PcLaptopCheckingExport implements WithEvents
{
    protected $form;
    protected $formTemplate;

    public function __construct(FormPcLaptopChecking $form, $formTemplate = null)
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
                $sheet->getColumnDimension('A')->setWidth(5); // NO
                $sheet->getColumnDimension('B')->setWidth(25); // NAMA PENGGUNA
                $sheet->getColumnDimension('C')->setWidth(15); // UNIT
                $sheet->getColumnDimension('D')->setWidth(15); // NDA
                $sheet->getColumnDimension('E')->setWidth(15); // Login Strong
                $sheet->getColumnDimension('F')->setWidth(15); // Screensaver
                $sheet->getColumnDimension('G')->setWidth(15); // Hak Akses
                $sheet->getColumnDimension('H')->setWidth(15); // Cleardesk
                $sheet->getColumnDimension('I')->setWidth(15); // mp3 video
                $sheet->getColumnDimension('J')->setWidth(12); // Status Install
                $sheet->getColumnDimension('K')->setWidth(12); // Status Update
                $sheet->getColumnDimension('L')->setWidth(18); // Full Scan
                $sheet->getColumnDimension('M')->setWidth(12); // O/S
                $sheet->getColumnDimension('N')->setWidth(15); // Sinkronisasi NTP
                $sheet->getColumnDimension('O')->setWidth(12); // Label PC
                $sheet->getColumnDimension('P')->setWidth(15); // Pemeriksa
                $sheet->getColumnDimension('Q')->setWidth(15); // Pegawai Ybs

                $noDokumen = $tpl->no_dokumen ?? 'FR.SM/TI/017.002/10-2020';
                $tglTerbit = $tpl->tanggal_dokumen ?? '12 Oktober 2020';
                $versi = $tpl->versi_dokumen ?? '002-2020';

                $tanggal = $form->tanggal;
                if ($tanggal && preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
                    $tanggal = \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('d - m - Y');
                }
                
                $tanggalPem = $form->tanggal_pemeriksaan;
                if ($tanggalPem && preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggalPem)) {
                    $tanggalPem = \Carbon\Carbon::parse($tanggalPem)->locale('id')->translatedFormat('d - m - Y');
                }

                $thinBorder = [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ];
                $allBorders = ['borders' => ['allBorders' => $thinBorder]];

                // ========== KOP SURAT ==========
                $sheet->mergeCells('A1:C2');
                $sheet->setCellValue('A1', 'KAI');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'italic' => true, 'size' => 18, 'color' => ['rgb' => '1F3B7C']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);

                $sheet->mergeCells('D1:M2');
                $sheet->setCellValue('D1', "PT. KERETA API INDONESIA (PERSERO)\nSistem Informasi");
                $sheet->getStyle('D1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                ]);

                $sheet->setCellValue('N1', 'Nomor');
                $sheet->mergeCells('O1:Q1');
                $sheet->setCellValue('O1', ': ' . $noDokumen);

                $sheet->setCellValue('N2', 'Tanggal Terbit');
                $sheet->mergeCells('O2:Q2');
                $sheet->setCellValue('O2', ': ' . $tglTerbit);

                $sheet->mergeCells('A3:C4');
                $sheet->setCellValue('A3', 'TERBATAS');
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 10, 'color' => ['rgb' => 'D97706']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getStyle('A3:C4')->applyFromArray([
                    'borders' => ['outline' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => 'D97706']]]
                ]);

                $sheet->mergeCells('D3:M4');
                $sheet->setCellValue('D3', 'FORMULIR PC/LAPTOP CHECKING');
                $sheet->getStyle('D3')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);

                $sheet->setCellValue('N3', 'Status Revisi');
                $sheet->mergeCells('O3:Q3');
                $sheet->setCellValue('O3', ': ' . $versi);

                $sheet->setCellValue('N4', 'Halaman');
                $sheet->mergeCells('O4:Q4');
                $sheet->setCellValue('O4', ': 1 dari 1'); // Assuming 1 page for now

                $sheet->getStyle('A1:Q4')->applyFromArray($allBorders);

                $sheet->getRowDimension(1)->setRowHeight(22);
                $sheet->getRowDimension(2)->setRowHeight(22);
                $sheet->getRowDimension(3)->setRowHeight(22);
                $sheet->getRowDimension(4)->setRowHeight(22);

                $sheet->getRowDimension(5)->setRowHeight(6);

                // ========== REFERENSI ==========
                $sheet->mergeCells('A6:C6');
                $sheet->setCellValue('A6', 'No. Ref');
                $sheet->mergeCells('D6:G6');
                $sheet->setCellValue('D6', ': ' . ($form->no_ref ?: '__/__/____'));

                $sheet->mergeCells('A7:C7');
                $sheet->setCellValue('A7', 'Tanggal');
                $sheet->mergeCells('D7:G7');
                $sheet->setCellValue('D7', ': ' . ($tanggal ?: '__-__-____'));

                $sheet->mergeCells('A8:C8');
                $sheet->setCellValue('A8', 'Business Area');
                $sheet->mergeCells('D8:G8');
                $sheet->setCellValue('D8', ': ' . ($form->business_area ?: '____'));

                $sheet->getStyle('A6:G8')->applyFromArray($allBorders);
                $sheet->getStyle('A6:C8')->applyFromArray(['font' => ['bold' => true, 'size' => 10]]);
                $sheet->getStyle('A6:G8')->applyFromArray(['font' => ['size' => 10]]);

                $sheet->getRowDimension(9)->setRowHeight(6);

                // ========== PERIODE & TANGGAL ==========
                $sheet->mergeCells('A10:C10');
                $sheet->setCellValue('A10', 'Periode Pemeriksaan');
                $sheet->setCellValue('D10', ': ' . ($form->periode_pemeriksaan ?: '......................................................'));
                
                $sheet->mergeCells('A11:C11');
                $sheet->setCellValue('A11', 'Tanggal Pemeriksaan');
                $sheet->setCellValue('D11', ': ' . ($tanggalPem ?: '......................................................'));
                
                $sheet->getStyle('A10:A11')->applyFromArray(['font' => ['bold' => true, 'size' => 10]]);

                // ========== TABLE HEADER ==========
                $headerStart = 12;
                
                // Row 12
                $sheet->mergeCells("A{$headerStart}:A".($headerStart+2));
                $sheet->setCellValue("A{$headerStart}", 'NO');
                $sheet->mergeCells("B{$headerStart}:B".($headerStart+2));
                $sheet->setCellValue("B{$headerStart}", 'NAMA PENGGUNA');
                $sheet->mergeCells("C{$headerStart}:C".($headerStart+2));
                $sheet->setCellValue("C{$headerStart}", 'UNIT');
                $sheet->mergeCells("D{$headerStart}:O{$headerStart}");
                $sheet->setCellValue("D{$headerStart}", 'CHECKLIST');
                $sheet->mergeCells("P{$headerStart}:Q{$headerStart}");
                $sheet->setCellValue("P{$headerStart}", 'Verifikasi / Paraf');
                
                // Row 13
                $sheet->mergeCells("D".($headerStart+1).":D".($headerStart+2));
                $sheet->setCellValue("D".($headerStart+1), "NDA\n(Sudah/Belum)");
                $sheet->mergeCells("E".($headerStart+1).":E".($headerStart+2));
                $sheet->setCellValue("E".($headerStart+1), "Login Strong\nPassword\n(Sudah/Belum)");
                $sheet->mergeCells("F".($headerStart+1).":F".($headerStart+2));
                $sheet->setCellValue("F".($headerStart+1), "Screensaver\nLock (maks\n5 menit)\n(Sudah/Belum)");
                $sheet->mergeCells("G".($headerStart+1).":G".($headerStart+2));
                $sheet->setCellValue("G".($headerStart+1), "* Hak Akses\nKhusus\n(Admin /\nUser)");
                $sheet->mergeCells("H".($headerStart+1).":H".($headerStart+2));
                $sheet->setCellValue("H".($headerStart+1), "Cleardesk\n(Sudah/\nBelum)");
                $sheet->mergeCells("I".($headerStart+1).":I".($headerStart+2));
                $sheet->setCellValue("I".($headerStart+1), ".mp3, video,\netc\n(Ada/Tidak)");
                
                // Antivirus
                $sheet->mergeCells("J".($headerStart+1).":L".($headerStart+1));
                $sheet->setCellValue("J".($headerStart+1), "Antivirus");
                
                $sheet->mergeCells("M".($headerStart+1).":M".($headerStart+2));
                $sheet->setCellValue("M".($headerStart+1), "O/S\n(License /\nTidak)");
                $sheet->mergeCells("N".($headerStart+1).":N".($headerStart+2));
                $sheet->setCellValue("N".($headerStart+1), "Sinkronisasi\nNTP Server\n(Ya/Tidak)");
                $sheet->mergeCells("O".($headerStart+1).":O".($headerStart+2));
                $sheet->setCellValue("O".($headerStart+1), "Label PC\n(Ada/Tidak)");
                
                // Verifikasi
                $sheet->mergeCells("P".($headerStart+1).":P".($headerStart+2));
                $sheet->setCellValue("P".($headerStart+1), "Pemeriksa");
                $sheet->mergeCells("Q".($headerStart+1).":Q".($headerStart+2));
                $sheet->setCellValue("Q".($headerStart+1), "Pegawai\nYbs");
                
                // Row 14
                $sheet->setCellValue("J".($headerStart+2), "Status\nInstall\n(Sudah/\nBelum)");
                $sheet->setCellValue("K".($headerStart+2), "Status\nUpdate\n(Sudah /\nBelum)");
                $sheet->setCellValue("L".($headerStart+2), "Full Scan Auto\nSchedule\n(Sudah/Belum)");

                $sheet->getStyle("A{$headerStart}:Q".($headerStart+2))->applyFromArray([
                    'font' => ['bold' => true, 'size' => 9],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D4D4D4']],
                    'borders' => ['allBorders' => $thinBorder],
                ]);

                // ========== DATA ROWS ==========
                $items = $form->items->sortBy('no')->values();
                $dataRowCount = max(1, $items->count());
                $startDataRow = $headerStart + 3;

                for ($i = 0; $i < $dataRowCount; $i++) {
                    $row = $startDataRow + $i;
                    $item = $items[$i] ?? null;

                    $sheet->setCellValue("A{$row}", $i + 1);
                    $sheet->setCellValue("B{$row}", $item->nama_pengguna ?? '');
                    $sheet->setCellValue("C{$row}", $item->unit ?? '');
                    $sheet->setCellValue("D{$row}", $item->nda ?? '');
                    $sheet->setCellValue("E{$row}", $item->login_strong_password ?? '');
                    $sheet->setCellValue("F{$row}", $item->screensaver_lock ?? '');
                    $sheet->setCellValue("G{$row}", $item->hak_akses_khusus ?? '');
                    $sheet->setCellValue("H{$row}", $item->cleardesk ?? '');
                    $sheet->setCellValue("I{$row}", ($item->mp3_video_etc ?? '') === 'Tidak' ? 'Tidak Ada' : ($item->mp3_video_etc ?? ''));
                    $sheet->setCellValue("J{$row}", $item->antivirus_install ?? '');
                    $sheet->setCellValue("K{$row}", $item->antivirus_update ?? '');
                    $sheet->setCellValue("L{$row}", $item->full_scan_auto_schedule ?? '');
                    $sheet->setCellValue("M{$row}", ($item->os_license ?? '') === 'Tidak' ? 'Non License' : ($item->os_license ?? ''));
                    $sheet->setCellValue("N{$row}", $item->sinkronisasi_ntp ?? '');
                    $sheet->setCellValue("O{$row}", $item->label_pc ?? '');
                    $sheet->setCellValue("P{$row}", $item->pemeriksa ?? '');
                    $sheet->setCellValue("Q{$row}", $item->pegawai_ybs ?? '');

                    $sheet->getStyle("A{$row}:Q{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getRowDimension($row)->setRowHeight(20);
                }
                
                $lastDataRow = $startDataRow + $dataRowCount - 1;

                $sheet->getStyle("A{$startDataRow}:Q{$lastDataRow}")->applyFromArray([
                    'font' => ['size' => 9],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                    'borders' => ['allBorders' => $thinBorder],
                ]);

                // End of File
                $eofRow = $lastDataRow + 1;
                $sheet->mergeCells("B{$eofRow}:Q{$eofRow}");
                $sheet->setCellValue("B{$eofRow}", '--- End of File ---');
                $sheet->getStyle("B{$eofRow}")->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
                    'font' => ['italic' => true, 'color' => ['rgb' => '808080']],
                ]);
                $sheet->getRowDimension($eofRow)->setRowHeight(30);

                // ========== CATATAN & MENGETAHUI ==========
                $catatanStart = $eofRow + 1;
                $catatanEnd = $catatanStart + 5;

                // Catatan section
                $sheet->mergeCells("A{$catatanStart}:N{$catatanEnd}");
                $sheet->setCellValue("A{$catatanStart}", "Catatan :\n" . ($form->catatan ?: ''));
                $sheet->getStyle("A{$catatanStart}:N{$catatanEnd}")->applyFromArray([
                    'font' => ['bold' => false, 'size' => 10],
                    'alignment' => ['vertical' => Alignment::VERTICAL_TOP, 'wrapText' => true],
                    'borders' => ['outline' => $thinBorder],
                ]);

                // Mengetahui section
                $baLocationMap = ['B060' => 'Yogyakarta', 'B010' => 'Jakarta', 'B020' => 'Bandung', 'B030' => 'Cirebon', 'B040' => 'Semarang', 'B050' => 'Surabaya', 'B070' => 'Madiun', 'B080' => 'Purwokerto'];
                $lokasi = $baLocationMap[$form->business_area] ?? '.......................';
                $tglMengetahui = $form->tanggal;
                if ($tglMengetahui && preg_match('/^\d{4}-\d{2}-\d{2}$/', $tglMengetahui)) {
                    $tglMengetahui = \Carbon\Carbon::parse($tglMengetahui)->locale('id')->translatedFormat('d F Y');
                } else {
                    $tglMengetahui = '..................................';
                }

                $sheet->mergeCells("O{$catatanStart}:Q{$catatanStart}");
                $sheet->setCellValue("O{$catatanStart}", $lokasi . ', ' . $tglMengetahui);
                $sheet->getStyle("O{$catatanStart}")->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                
                $sheet->mergeCells("O".($catatanStart+1).":Q".($catatanStart+1));
                $sheet->setCellValue("O".($catatanStart+1), 'Mengetahui,');
                $sheet->getStyle("O".($catatanStart+1))->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $sheet->mergeCells("O".($catatanStart+2).":Q".($catatanStart+2));
                $sheet->setCellValue("O".($catatanStart+2), ($form->mengetahui_jabatan ?: '.......................................'));
                $sheet->getStyle("O".($catatanStart+2))->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Empty space for signature
                $sheet->mergeCells("O".($catatanStart+3).":Q".($catatanStart+3));

                // Name with dotted line
                $sigNameRow = $catatanStart + 4;
                $sheet->mergeCells("O{$sigNameRow}:Q{$sigNameRow}");
                $sheet->setCellValue("O{$sigNameRow}", ($form->mengetahui_nama ?: '....................................................................'));
                $sheet->getStyle("O{$sigNameRow}")->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'font' => ['underline' => true, 'bold' => true],
                ]);

                // NIPP
                $nippRow = $catatanEnd;
                $sheet->mergeCells("O{$nippRow}:Q{$nippRow}");
                $sheet->setCellValue("O{$nippRow}", 'NIPP. ' . ($form->mengetahui_nipp ?: '......................'));
                $sheet->getStyle("O{$nippRow}")->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Set row heights for catatan area
                for ($r = $catatanStart; $r <= $catatanEnd; $r++) {
                    $sheet->getRowDimension($r)->setRowHeight(20);
                }

                // ========== GLOBAL STYLES ==========
                $sheet->getStyle('A1:Q' . $catatanEnd)->applyFromArray([
                    'font' => ['name' => 'Arial'],
                ]);
            },
        ];
    }
}
