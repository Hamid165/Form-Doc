@extends('layouts.app')

@section('title', 'Secure Implement Preparation')

@push('styles')
<style>
    /* =========================================================
       PAGE / FEATURE HEADER
    ========================================================= */

    .feature-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 24px;
    }

    .feature-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }

    .feature-icon {
        width: 52px;
        height: 52px;
        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border: 1px solid #dbeafe;
        border-radius: 10px;

        background: #eff6ff;
        color: #2563eb;
    }

    .feature-icon svg {
        width: 27px;
        height: 27px;
        stroke: currentColor;
    }

    .feature-title {
        margin: 0;
        color: #1f2937;
        font-size: 20px;
        font-weight: 700;
        line-height: 1.3;
    }

    .feature-description {
        margin: 4px 0 0;
        color: #9ca3af;
        font-size: 12px;
        line-height: 1.5;
    }


    /* =========================================================
       RIGHT HEADER ACTIONS
    ========================================================= */

    .feature-header-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        margin-left: auto;
    }


    /* =========================================================
       SEARCH
    ========================================================= */

    .search-form {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }

    .search-input-wrapper {
        position: relative;
        width: 280px;
    }

    .search-icon {
        position: absolute;
        left: 13px;
        top: 50%;

        display: flex;
        align-items: center;

        color: #9ca3af;

        transform: translateY(-50%);
        pointer-events: none;
    }

    .search-icon svg {
        width: 17px;
        height: 17px;
        stroke: currentColor;
    }

    .search-input {
        width: 100%;
        height: 42px;
        box-sizing: border-box;

        padding: 0 14px 0 40px;

        border: 1px solid #d1d5db;
        border-radius: 6px;

        outline: none;

        background: #ffffff;
        color: #374151;

        font-family: inherit;
        font-size: 13px;

        transition: .2s;
    }

    .search-input::placeholder {
        color: #9ca3af;
    }

    .search-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
    }

    .search-button {
        height: 42px;
        padding: 0 17px;

        border: 1px solid #d1d5db;
        border-radius: 6px;

        background: #ffffff;
        color: #374151;

        font-family: inherit;
        font-size: 13px;
        font-weight: 600;

        cursor: pointer;
        transition: .2s;
    }

    .search-button:hover {
        background: #f3f4f6;
    }

    .search-reset {
        height: 42px;
        padding: 0 14px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        box-sizing: border-box;

        border: 1px solid #d1d5db;
        border-radius: 6px;

        background: #ffffff;
        color: #4b5563;

        text-decoration: none;
        font-size: 13px;
        font-weight: 600;

        transition: .2s;
    }

    .search-reset:hover {
        background: #f3f4f6;
    }
    /* =========================================================
   IMPORT / TEMPLATE BUTTON
========================================================= */

.import-button,
.template-button {
    height: 42px;
    padding: 0 15px;

    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;

    box-sizing: border-box;

    border-radius: 6px;

    font-family: inherit;
    font-size: 13px;
    font-weight: 600;

    white-space: nowrap;
    cursor: pointer;
    text-decoration: none;

    transition: .2s;
}

.template-button {
    border: 1px solid #d1d5db;
    background: #ffffff;
    color: #374151;
}

.template-button:hover {
    background: #f3f4f6;
    border-color: #9ca3af;
}

.import-button {
    border: 1px solid #16a34a;
    background: #ffffff;
    color: #15803d;
}

.import-button:hover {
    background: #f0fdf4;
}

.import-button svg,
.template-button svg {
    width: 17px;
    height: 17px;
    stroke: currentColor;
}


/* =========================================================
   IMPORT MODAL
========================================================= */

.import-modal {
    display: none;

    position: fixed;
    inset: 0;
    z-index: 10000;

    align-items: center;
    justify-content: center;

    padding: 20px;

    background: rgba(17, 24, 39, .55);
}

.import-modal.show {
    display: flex;
}

.import-modal-box {
    width: 100%;
    max-width: 480px;

    padding: 28px;

    border-radius: 14px;

    background: #ffffff;

    box-shadow: 0 20px 50px rgba(0, 0, 0, .20);

    animation: modalAppear .18s ease-out;
}

.import-modal-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;

    margin-bottom: 22px;
}

.import-modal-title {
    margin: 0;

    color: #111827;

    font-size: 20px;
    font-weight: 700;
}

.import-modal-description {
    margin: 5px 0 0;

    color: #6b7280;

    font-size: 13px;
    line-height: 1.5;
}

.import-close {
    width: 34px;
    height: 34px;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 0;

    border: none;
    border-radius: 6px;

    background: #f3f4f6;
    color: #4b5563;

    font-size: 21px;

    cursor: pointer;
}

.import-close:hover {
    background: #e5e7eb;
}

.import-upload-area {
    padding: 28px 20px;

    border: 2px dashed #d1d5db;
    border-radius: 10px;

    background: #f9fafb;

    text-align: center;
}

.import-upload-icon {
    margin-bottom: 10px;

    font-size: 35px;
}

.import-file-input {
    width: 100%;
    margin-top: 14px;
}

.import-help {
    margin: 10px 0 0;

    color: #9ca3af;

    font-size: 11px;
}

.import-modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;

    margin-top: 22px;
}

.import-cancel,
.import-submit {
    height: 40px;
    padding: 0 17px;

    border: none;
    border-radius: 6px;

    font-family: inherit;
    font-size: 13px;
    font-weight: 600;

    cursor: pointer;
}

.import-cancel {
    background: #f3f4f6;
    color: #374151;
}

.import-cancel:hover {
    background: #e5e7eb;
}

.import-submit {
    background: #16a34a;
    color: #ffffff;
}

.import-submit:hover {
    background: #15803d;
}


/* =========================================================
   IMPORT ERROR MESSAGE
========================================================= */

.alert-error {
    margin-bottom: 18px;
    padding: 13px 16px;

    border: 1px solid #fecaca;
    border-radius: 7px;

    background: #fef2f2;
    color: #991b1b;

    font-size: 13px;
}

.alert-error ul {
    margin: 7px 0 0;
    padding-left: 20px;
}

    /* =========================================================
       CREATE BUTTON
    ========================================================= */

    .create-button {
        height: 42px;
        padding: 0 18px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;

        box-sizing: border-box;

        border: none;
        border-radius: 6px;

        background: #2563eb;
        color: #ffffff;

        text-decoration: none;
        font-size: 13px;
        font-weight: 600;

        white-space: nowrap;

        transition: .2s;
    }

    .create-button:hover {
        background: #1d4ed8;
    }


    /* =========================================================
       TABLE
    ========================================================= */

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .form-table {
        width: 100%;
        border-collapse: collapse;
    }

    .form-table thead th {
        padding: 13px 12px;

        border-top: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;

        background: #f8fafc;
        color: #4b5563;

        text-align: left;

        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .03em;

        white-space: nowrap;
    }

    .form-table tbody td {
        padding: 14px 12px;

        border-bottom: 1px solid #e5e7eb;

        color: #374151;

        font-size: 14px;
        vertical-align: middle;
    }

    .form-table tbody tr {
        transition: .15s;
    }

    .form-table tbody tr:hover {
        background: #f9fafb;
    }

    .number-column {
        width: 60px;
        text-align: center !important;
    }

    .reference-number {
        color: #1f2937;
        font-weight: 600;
    }

    .application-name {
        color: #111827;
        font-weight: 600;
    }


    /* =========================================================
       STATUS CHECKLIST
    ========================================================= */

    .status-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .status-badge {
        display: inline-block;

        padding: 4px 8px;

        border-radius: 999px;

        font-size: 11px;
        font-weight: 600;

        white-space: nowrap;
    }

    .status-success {
        background: #dcfce7;
        color: #166534;
    }

    .status-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-neutral {
        background: #f3f4f6;
        color: #6b7280;
    }


    /* =========================================================
       ACTION
    ========================================================= */

    .action-column {
        min-width: 205px;
        text-align: center !important;
        white-space: nowrap;
    }

    .action-group {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .action-icon {
        width: 38px;
        height: 38px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 0;

        border: none;
        border-radius: 8px;

        text-decoration: none;
        cursor: pointer;

        transition: all .2s ease;
    }

    .action-icon svg {
        width: 18px;
        height: 18px;
        stroke: currentColor;
    }

    /* Lihat */

    .action-view {
        background: #e0f2fe;
        color: #0369a1;
    }

    .action-view:hover {
        background: #bae6fd;
        transform: translateY(-2px);
    }

    /* Edit */

    .action-edit {
        background: #fef3c7;
        color: #92400e;
    }

    .action-edit:hover {
        background: #fde68a;
        transform: translateY(-2px);
    }

    /* Print */

    .action-print {
        background: #e0e7ff;
        color: #4338ca;
    }

    .action-print:hover {
        background: #c7d2fe;
        transform: translateY(-2px);
    }

    /* Delete */

    .action-delete {
        background: #fee2e2;
        color: #b91c1c;
    }

    .action-delete:hover {
        background: #fecaca;
        transform: translateY(-2px);
    }

    .action-icon:active {
        transform: translateY(0);
    }


    /* =========================================================
       PAGINATION
    ========================================================= */

    .pagination-wrapper {
        margin-top: 22px;
    }


    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .empty-state {
        padding: 65px 20px;
        text-align: center;
    }

    .empty-icon {
        margin-bottom: 12px;
        font-size: 48px;
    }

    .empty-state h3 {
        margin: 0 0 8px;
        color: #374151;
    }

    .empty-state p {
        max-width: 500px;
        margin: 0 auto 22px;

        color: #6b7280;

        line-height: 1.6;
    }


    /* =========================================================
       DELETE MODAL
    ========================================================= */

    .delete-modal {
        display: none;

        position: fixed;
        inset: 0;
        z-index: 9999;

        align-items: center;
        justify-content: center;

        padding: 20px;

        background: rgba(17, 24, 39, .55);
    }

    .delete-modal.show {
        display: flex;
    }

    .delete-modal-box {
        width: 100%;
        max-width: 430px;

        padding: 30px;

        border-radius: 14px;

        background: #ffffff;

        text-align: center;

        box-shadow: 0 20px 50px rgba(0, 0, 0, .20);

        animation: modalAppear .18s ease-out;
    }

    @keyframes modalAppear {
        from {
            opacity: 0;
            transform: translateY(-8px) scale(.98);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }


    /* =========================================================
       DELETE ICON
    ========================================================= */

    .delete-icon {
        width: 58px;
        height: 58px;

        margin: 0 auto 18px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background: #fee2e2;
        color: #dc2626;

        font-size: 30px;
        font-weight: 700;
    }


    /* =========================================================
       DELETE TEXT
    ========================================================= */

    .delete-modal-box h3 {
        margin: 0 0 10px;

        color: #111827;

        font-size: 21px;
        font-weight: 700;
    }

    .delete-description {
        margin: 0;

        color: #6b7280;

        font-size: 14px;
        line-height: 1.6;
    }

    .delete-application {
        color: #111827;
        font-weight: 700;
    }

    .delete-detail {
        margin: 18px 0 12px;
        padding: 12px 14px;

        border: 1px solid #e5e7eb;
        border-radius: 7px;

        background: #f9fafb;
        color: #374151;

        font-size: 13px;
    }

    .delete-reference {
        color: #111827;
        font-weight: 700;
    }

    .delete-warning {
        margin: 0 !important;

        color: #b91c1c !important;

        font-size: 12px !important;
        line-height: 1.5;
    }


    /* =========================================================
       DELETE MODAL BUTTON
    ========================================================= */

    .delete-modal-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;

        margin-top: 25px;
    }

    .delete-modal-actions form {
        margin: 0;
    }

    .modal-cancel,
    .modal-delete {
        padding: 10px 18px;

        border: none;
        border-radius: 6px;

        font-family: inherit;
        font-size: 13px;
        font-weight: 600;

        cursor: pointer;

        transition: .2s;
    }

    .modal-cancel {
        background: #f3f4f6;
        color: #374151;
    }

    .modal-cancel:hover {
        background: #e5e7eb;
    }

    .modal-delete {
        background: #dc2626;
        color: #ffffff;
    }

    .modal-delete:hover {
        background: #b91c1c;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1000px) {

        .feature-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .feature-header-actions {
            width: 100%;
            margin-left: 0;
        }

        .search-form {
            flex: 1;
        }

        .search-input-wrapper {
            flex: 1;
            width: auto;
        }
    }


    @media (max-width: 768px) {

        .feature-header-actions {
            align-items: stretch;
            flex-direction: column;
        }

        .search-form {
            width: 100%;
            flex-wrap: wrap;
        }

        .search-input-wrapper {
            width: 100%;
            flex-basis: 100%;
        }

        .search-button,
        .search-reset {
            flex: 1;
        }

        .create-button {
            width: 100%;
        }

        .delete-modal-box {
            max-width: 100%;
            padding: 25px 20px;
        }

        .delete-modal-actions {
            flex-direction: column-reverse;
        }

        .modal-cancel,
        .modal-delete,
        .delete-modal-actions form {
            width: 100%;
        }
    }
</style>
@endpush


@section('content')

{{-- =========================================================
     SUCCESS MESSAGE
========================================================= --}}

@if(session('success'))

    <div class="alert-success">
        {{ session('success') }}
    </div>

@endif


{{-- =========================================================
     MAIN CARD
========================================================= --}}

<div class="card">

    {{-- =====================================================
         FEATURE HEADER
    ====================================================== --}}

    <div class="feature-header">

        {{-- LEFT SIDE --}}
        <div class="feature-header-left">

            {{-- ICON --}}
            <div class="feature-icon">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                    />
                </svg>

            </div>


            {{-- TITLE --}}
            <div>

                <h2 class="feature-title">
                    Secure Implement Preparation
                </h2>

                <p class="feature-description">
                    Daftar Formulir Checklist 05 Secure Implement Preparation
                </p>

            </div>

        </div>


        {{-- RIGHT SIDE --}}
        <div class="feature-header-actions">

            {{-- SEARCH --}}
            <form
                action="{{ route('secure-implement-preparation.index') }}"
                method="GET"
                class="search-form"
            >

                <div class="search-input-wrapper">

                    <span class="search-icon">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                        >
                            <circle
                                cx="11"
                                cy="11"
                                r="7"
                            />

                            <path
                                stroke-linecap="round"
                                d="m20 20-4-4"
                            />
                        </svg>

                    </span>


                    <input
                        type="text"
                        name="search"
                        class="search-input"
                        value="{{ request('search') }}"
                        placeholder="Cari data..."
                        autocomplete="off"
                    >

                </div>


                <button
                    type="submit"
                    class="search-button"
                >
                    Cari
                </button>


                @if(request('search'))

                    <a
                        href="{{ route('secure-implement-preparation.index') }}"
                        class="search-reset"
                    >
                        Reset
                    </a>

                @endif

            </form>

            {{-- DOWNLOAD TEMPLATE --}}
    <a
        href="{{ route('secure-implement-preparation.template') }}"
        class="template-button"
        title="Download Template Excel"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="2"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 3v12m0 0 4-4m-4 4-4-4M5 19h14"
            />
        </svg>

        Template
    </a>


    {{-- IMPORT DATA --}}
    <button
        type="button"
        class="import-button"
        onclick="openImportModal()"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="2"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 21V9m0 0-4 4m4-4 4 4M5 5h14"
            />
        </svg>

        Import Data
    </button>


                {{-- CREATE --}}
                <a
                    href="{{ route('secure-implement-preparation.create') }}"
                    class="create-button"
                >
                    + Buat Formulir
                </a>

            </div>

        </div>


    {{-- =====================================================
         DATA FOUND
    ====================================================== --}}

    @if($forms->count() > 0)

        <div class="table-responsive">

            <table class="form-table">

                <thead>

                    <tr>

                        <th class="number-column">
                            No.
                        </th>

                        <th>
                            No. Ref
                        </th>

                        <th>
                            Nama Aplikasi
                        </th>

                        <th>
                            Business Area
                        </th>

                        <th>
                            Tanggal Checklist
                        </th>

                        <th>
                            Status Checklist
                        </th>

                        <th class="action-column">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($forms as $form)

                        <tr>

                            {{-- NUMBER --}}
                            <td class="number-column">
                                {{ $forms->firstItem() + $loop->index }}
                            </td>


                            {{-- NO REF --}}
                            <td>

                                <span class="reference-number">
                                    {{ $form->no_ref }}
                                </span>

                            </td>


                            {{-- APPLICATION NAME --}}
                            <td>

                                <span class="application-name">
                                    {{ $form->nama_aplikasi }}
                                </span>

                            </td>


                            {{-- BUSINESS AREA --}}
                            <td>
                                {{ $form->business_area ?? '-' }}
                            </td>


                            {{-- CHECKLIST DATE --}}
                            <td>
                                {{
                                    $form->tanggal_checklist
                                        ?->format('d-m-Y')
                                    ?? '-'
                                }}
                            </td>


                            {{-- STATUS --}}
                            <td>

                                <div class="status-wrapper">

                                    {{-- TSD --}}
                                    @if($form->check_tsd === 'YA')

                                        <span class="status-badge status-success">
                                            TSD ✓
                                        </span>

                                    @elseif($form->check_tsd === 'TIDAK')

                                        <span class="status-badge status-danger">
                                            TSD ✕
                                        </span>

                                    @else

                                        <span class="status-badge status-neutral">
                                            TSD -
                                        </span>

                                    @endif


                                    {{-- USER MANUAL --}}
                                    @if($form->check_user_manual === 'YA')

                                        <span class="status-badge status-success">
                                            User Manual ✓
                                        </span>

                                    @elseif($form->check_user_manual === 'TIDAK')

                                        <span class="status-badge status-danger">
                                            User Manual ✕
                                        </span>

                                    @else

                                        <span class="status-badge status-neutral">
                                            User Manual -
                                        </span>

                                    @endif

                                </div>

                            </td>


                            {{-- =================================================
                                 ACTION
                            ================================================== --}}

                            <td class="action-column">

                                <div class="action-group">


                                    {{-- =========================
                                         LIHAT
                                    ========================== --}}

                                    <a
                                        href="{{ route(
                                            'secure-implement-preparation.show',
                                            $form->id
                                        ) }}"
                                        class="action-icon action-view"
                                        title="Lihat Formulir"
                                        aria-label="Lihat Formulir"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                            />
                                        </svg>

                                    </a>


                                    {{-- =========================
                                         EDIT
                                    ========================== --}}

                                    <a
                                        href="{{ route(
                                            'secure-implement-preparation.edit',
                                            $form->id
                                        ) }}"
                                        class="action-icon action-edit"
                                        title="Edit Formulir"
                                        aria-label="Edit Formulir"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M19.5 7.125 16.862 4.487"
                                            />
                                        </svg>

                                    </a>


                                    {{-- =========================
                                         PRINT
                                    ========================== --}}

                                    <a
                                        href="{{ route(
                                            'secure-implement-preparation.show',
                                            $form->id
                                        ) }}?print=1"
                                        class="action-icon action-print"
                                        title="Print Formulir"
                                        aria-label="Print Formulir"
                                        target="_blank"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M6.72 13.829h10.56M6.72 17.829h10.56M6.72 3.75h10.56v4.5H6.72v-4.5Z"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M6.75 18.75H4.875A1.875 1.875 0 0 1 3 16.875v-6.75A1.875 1.875 0 0 1 4.875 8.25h14.25A1.875 1.875 0 0 1 21 10.125v6.75a1.875 1.875 0 0 1-1.875 1.875H17.25"
                                            />
                                        </svg>

                                    </a>


                                    {{-- =========================
                                         DELETE
                                    ========================== --}}

                                    <button
                                        type="button"
                                        class="action-icon action-delete"
                                        title="Hapus Formulir"
                                        aria-label="Hapus Formulir"
                                        onclick="openDeleteModal(
                                            '{{ $form->id }}',
                                            @js($form->nama_aplikasi),
                                            @js($form->no_ref)
                                        )"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166M19.228 5.79 18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-2.327L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0V4.477c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                            />
                                        </svg>

                                    </button>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if($forms->hasPages())

            <div class="pagination-wrapper">
                {{ $forms->links() }}
            </div>

        @endif


    {{-- =====================================================
         SEARCH NOT FOUND
    ====================================================== --}}

    @elseif(request('search'))

        <div class="empty-state">

            <div class="empty-icon">
                🔍
            </div>

            <h3>
                Data Tidak Ditemukan
            </h3>

            <p>
                Tidak ada formulir yang sesuai dengan pencarian
                "<strong>{{ request('search') }}</strong>".
            </p>

            <a
                href="{{ route('secure-implement-preparation.index') }}"
                class="create-button"
            >
                Tampilkan Semua Data
            </a>

        </div>


    {{-- =====================================================
         DATABASE EMPTY
    ====================================================== --}}

    @else

        <div class="empty-state">

            <div class="empty-icon">
                📋
            </div>

            <h3>
                Belum Ada Formulir
            </h3>

            <p>
                Belum ada data Formulir Checklist 05
                Secure Implement Preparation yang tersimpan.
            </p>

            <a
                href="{{ route('secure-implement-preparation.create') }}"
                class="create-button"
            >
                + Buat Formulir Pertama
            </a>

        </div>

    @endif

</div>

{{-- =========================================================
     IMPORT DATA MODAL
========================================================= --}}

<div
    id="importModal"
    class="import-modal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="importModalTitle"
>

    <div class="import-modal-box">

        {{-- HEADER --}}
        <div class="import-modal-header">

            <div>
                <h3
                    id="importModalTitle"
                    class="import-modal-title"
                >
                    Import Data
                </h3>

                <p class="import-modal-description">
                    Pilih file Excel atau CSV sesuai template
                    Secure Implement Preparation.
                </p>
            </div>


            <button
                type="button"
                class="import-close"
                onclick="closeImportModal()"
                aria-label="Tutup"
            >
                ×
            </button>

        </div>


        {{-- FORM IMPORT --}}
        <form
            action="{{ route('secure-implement-preparation.import') }}"
            method="POST"
            enctype="multipart/form-data"
            id="importForm"
        >

            @csrf


            <div class="import-upload-area">

                <div class="import-upload-icon">
                    📄
                </div>


                <strong>
                    Pilih file data
                </strong>


                <p class="import-modal-description">
                    Gunakan file yang mengikuti format template.
                </p>


                <input
                    type="file"
                    name="import_file"
                    id="importFile"
                    class="import-file-input"
                    accept=".xlsx,.xls,.csv"
                    required
                >


                <p class="import-help">
                    Format yang didukung: XLSX, XLS, dan CSV.
                    Maksimal ukuran file 5 MB.
                </p>

            </div>


            <div class="import-modal-actions">

                <button
                    type="button"
                    class="import-cancel"
                    onclick="closeImportModal()"
                >
                    Batal
                </button>


                <button
                    type="submit"
                    class="import-submit"
                    id="importSubmitButton"
                >
                    Import Data
                </button>

            </div>

        </form>

    </div>

</div>


{{-- =========================================================
     DELETE CONFIRMATION MODAL
========================================================= --}}

<div
    id="deleteModal"
    class="delete-modal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="deleteModalTitle"
>

    <div class="delete-modal-box">

        {{-- ICON --}}
        <div class="delete-icon">
            !
        </div>


        {{-- TITLE --}}
        <h3 id="deleteModalTitle">
            Hapus Formulir?
        </h3>


        {{-- DESCRIPTION --}}
        <p class="delete-description">

            Apakah Anda yakin ingin menghapus

            <span
                id="deleteApplication"
                class="delete-application"
            ></span>?

        </p>


        {{-- REFERENCE --}}
        <div class="delete-detail">

            No. Ref:

            <span
                id="deleteReference"
                class="delete-reference"
            ></span>

        </div>


        {{-- WARNING --}}
        <p class="delete-warning">
            Data yang sudah dihapus tidak dapat dikembalikan.
        </p>


        {{-- ACTION --}}
        <div class="delete-modal-actions">

            <button
                type="button"
                class="modal-cancel"
                onclick="closeDeleteModal()"
            >
                Batal
            </button>


            <form
                id="deleteForm"
                method="POST"
            >

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="modal-delete"
                >
                    Hapus Formulir
                </button>

            </form>

        </div>

    </div>

</div>


{{-- =========================================================
     DELETE MODAL JAVASCRIPT
========================================================= --}}

<script>

    /*
    |--------------------------------------------------------------------------
    | OPEN DELETE MODAL
    |--------------------------------------------------------------------------
    */

    function openDeleteModal(id, application, reference) {

        const modal =
            document.getElementById('deleteModal');

        const deleteForm =
            document.getElementById('deleteForm');

        const deleteReference =
            document.getElementById('deleteReference');

        const deleteApplication =
            document.getElementById('deleteApplication');


        deleteReference.textContent =
            reference || '-';

        deleteApplication.textContent =
            application || '-';


        /*
         * DELETE endpoint:
         * /secure-implement-preparation/{id}
         */

        deleteForm.action =
            "{{ url('secure-implement-preparation') }}/" + id;


        modal.classList.add('show');

        document.body.style.overflow = 'hidden';
    }


    /*
    |--------------------------------------------------------------------------
    | CLOSE DELETE MODAL
    |--------------------------------------------------------------------------
    */

    function closeDeleteModal() {

        const modal =
            document.getElementById('deleteModal');

        modal.classList.remove('show');

        document.body.style.overflow = '';
    }


    /*
    |--------------------------------------------------------------------------
    | CLICK OUTSIDE MODAL
    |--------------------------------------------------------------------------
    */

    const deleteModal =
        document.getElementById('deleteModal');

    if (deleteModal) {

        deleteModal.addEventListener(
            'click',
            function(event) {

                if (event.target === this) {
                    closeDeleteModal();
                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | ESC KEY
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function(event) {

            if (
                event.key === 'Escape'
                &&
                document
                    .getElementById('deleteModal')
                    ?.classList
                    .contains('show')
            ) {

                closeDeleteModal();

            }

        }
    );

/*
|--------------------------------------------------------------------------
| IMPORT MODAL
|--------------------------------------------------------------------------
*/

function openImportModal()
{
    const modal = document.getElementById('importModal');

    if (!modal) {
        return;
    }

    modal.classList.add('show');

    document.body.style.overflow = 'hidden';
}


function closeImportModal()
{
    const modal = document.getElementById('importModal');

    if (!modal) {
        return;
    }

    modal.classList.remove('show');

    document.body.style.overflow = '';
}


/*
|--------------------------------------------------------------------------
| KLIK AREA LUAR MODAL IMPORT
|--------------------------------------------------------------------------
*/

const importModal = document.getElementById('importModal');

if (importModal) {

    importModal.addEventListener(
        'click',
        function(event)
        {
            if (event.target === this) {
                closeImportModal();
            }
        }
    );

}


/*
|--------------------------------------------------------------------------
| SAAT PROSES IMPORT
|--------------------------------------------------------------------------
*/

const importForm = document.getElementById('importForm');

if (importForm) {

    importForm.addEventListener(
        'submit',
        function()
        {
            const button =
                document.getElementById('importSubmitButton');

            if (button) {
                button.disabled = true;
                button.textContent = 'Mengimport...';
            }
        }
    );

}

</script>

@endsection