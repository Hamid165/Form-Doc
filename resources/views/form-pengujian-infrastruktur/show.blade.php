@extends('layouts.app')

@section('title', 'Detail Formulir Pengujian Infrastruktur')

@section('content')

<!-- Reuse form.blade.php in readonly mode -->
@include('form-pengujian-infrastruktur.form', [
    'action'        => '#',
    'method'        => 'GET',
    'form'          => $form,
    'items'         => $form->items,
    'formTemplate'  => $formTemplate,
    'masterSigners' => $masterSigners,
])

<style>
    /* Prevent interaction and hide submit/edit controls for show view */
    .a4-container input,
    .a4-container textarea,
    .a4-container select {
        pointer-events: none;
        background-color: transparent !important;
        border-color: transparent !important;
        -webkit-appearance: none;
        appearance: none;
    }
    .btn-submit,
    .btn-add-row,
    .btn-delete-row,
    #signer_select,
    #pelaksana_select {
        display: none !important;
    }
    .btn-kembali {
        background-color: #3b82f6;
    }
    .btn-kembali:hover {
        background-color: #2563eb;
    }
    /* Sembunyikan kolom action sepenuhnya di screen view juga */
    .items-table .action-col {
        display: none !important;
    }
    /* Hide the dropdown arrow on select in show mode */
    .hasil-checkbox {
        pointer-events: none !important;
    }

    /* Print Styles */
    @media print {
        @page {
            size: A4 portrait;
            margin: 0; /* Menghilangkan default margin browser */
        }
        
        /* Reset background browser */
        body, html {
            background-color: white !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Sembunyikan semua elemen default, lalu munculkan hanya form */
        body * {
            visibility: hidden;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .a4-container, .a4-container * {
            visibility: visible;
        }
        /* Reset wrapper screen zoom untuk print */
        .zoom-container {
            zoom: 1 !important;
            transform: none !important;
            width: 100% !important;
            display: block !important;
            justify-content: unset !important;
        }
        .a4-wrapper {
            padding: 0 !important;
            display: block !important;
        }
        .a4-container {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            margin: 0 !important;
            padding: 12mm 15mm !important;
            width: 210mm !important;
            max-width: none !important;
            min-height: auto !important;
            max-height: none !important;
            box-sizing: border-box !important;
            box-shadow: none !important;
            border: none !important;
            background-color: white !important;
            zoom: 1 !important;
            overflow: visible !important;
        }

        /* Sembunyikan tombol aksi */
        .top-nav-container, .btn-kembali, .btn-submit, .no-print,
        .action-col, #signer_select, #pelaksana_select,
        .btn-add-row, .btn-delete-row {
            display: none !important;
        }

        /* Sembunyikan kolom action (hapus) di tabel agar kolom Keterangan melebar penuh */
        .items-table .action-col {
            display: none !important;
        }
        
        /* Pastikan input terlihat seperti teks biasa */
        input, textarea, select {
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
            color: black !important;
            -webkit-appearance: none !important;
            appearance: none !important;
        }

        /* Izinkan resize handle (//) tetap terlihat di textarea saat print */
        textarea {
            resize: vertical;
            overflow: visible;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto print if ?print=1
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('print') === '1') {
            setTimeout(function() { window.print(); }, 500);
        }
    });
</script>

@endsection
