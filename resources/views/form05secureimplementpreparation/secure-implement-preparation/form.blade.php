@php
    $isEdit = isset($form);

    $tanggal = old(
        'tanggal',
        $isEdit && $form->tanggal
            ? $form->tanggal->format('Y-m-d')
            : ''
    );

    $tanggalChecklist = old(
        'tanggal_checklist',
        $isEdit && $form->tanggal_checklist
            ? $form->tanggal_checklist->format('Y-m-d')
            : ''
    );

    $tanggalTtd = old(
        'tanggal_ttd',
        $isEdit && $form->tanggal_ttd
            ? $form->tanggal_ttd->format('Y-m-d')
            : ''
    );
@endphp


<style>
    * {
        box-sizing: border-box;
    }

    .secure-form-page {
        max-width: 1100px;

        margin: 25px auto;
        padding: 40px;

        background: #fff;

        border-radius: 4px;

        box-shadow: 0 2px 12px rgba(0,0,0,.10);

        font-family: Arial, Helvetica, sans-serif;
        color: #000;
    }

    .secure-document {
        width: 100%;
        max-width: 940px;

        margin: auto;

        font-size: 14px;
    }

    .secure-document table {
        border-collapse: collapse;
    }

    /* =====================================================
       HEADER
    ===================================================== */

    .secure-header {
        width: 100%;
        height: 190px;

        table-layout: fixed;
    }

    .secure-header > tbody > tr > td {
        padding: 0;

        border: 1px solid #222;

        vertical-align: middle;
    }

    /* LOGO */

    .secure-logo-column {
        width: 21%;
    }

    .secure-logo-box {
        height: 133px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding: 14px;
    }

    .secure-logo {
        width: 140px;
        max-width: 94%;
        height: auto;
    }

    /* TERBATAS */

    .secure-restricted-box {
        height: 57px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding: 8px;
    }

    .secure-restricted {
        width: 100%;

        padding: 9px;

        border: 2px solid #f1d800;

        color: #d4bd00;

        text-align: center;

        font-size: 14px;
        font-weight: bold;
    }

    /* TENGAH */

    .secure-middle-column {
        width: 47%;
    }

    .secure-company {
        height: 95px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding: 10px;

        text-align: center;

        font-size: 15px;
        font-weight: bold;
        line-height: 1.35;
    }

    .secure-title {
        height: 95px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding: 10px;

        border-top: 1px solid #222;

        text-align: center;

        font-size: 15px;
        font-weight: bold;
        line-height: 1.35;
    }

    /* INFO */

    .secure-info-cell {
        width: 32%;
    }

    .secure-info {
        width: 100%;
        height: 190px;

        table-layout: fixed;
    }

    .secure-info td {
        height: 47.5px;

        padding: 7px;

        border: 0 !important;
        border-bottom: 1px solid #222 !important;

        vertical-align: middle;

        font-size: 13px;
    }

    .secure-info tr:last-child td {
        border-bottom: 0 !important;
    }

    .secure-info-label {
        width: 31%;

        border-right: 1px solid #222 !important;

        font-weight: bold;
    }

    .secure-info-value {
        width: 69%;
    }

    /* =====================================================
       INPUT
    ===================================================== */

    .secure-input {
        width: 100%;

        padding: 7px 8px;

        border: none;
        border-bottom: 1px solid #777;

        outline: none;

        background: transparent;

        font-family: Arial, Helvetica, sans-serif;
        font-size: 14px;
    }

    .secure-input:focus {
        border-bottom: 2px solid #2563eb;

        background: #eff6ff;
    }

    textarea.secure-input {
        min-height: 70px;

        border: 1px solid #aaa;

        resize: vertical;
    }

    /* =====================================================
       REFERENCE
    ===================================================== */

    .secure-reference {
        width: 46%;

        margin-top: 20px;
        margin-bottom: 35px;

        table-layout: fixed;
    }

    .secure-reference td {
        padding: 4px 6px;

        border: 1px solid #222;

        font-size: 14px;
    }

    .secure-reference-label {
        width: 41%;
    }

    .secure-reference-colon {
        width: 8%;

        text-align: center;
    }

    .secure-reference-value {
        width: 51%;

        padding: 0 5px !important;
    }

    .secure-reference-value input {
        width: 100%;

        padding: 7px 2px;

        border: 0;
        outline: 0;

        background: transparent;

        font-family: Arial, Helvetica, sans-serif;
        font-size: 14px;
    }

    .secure-reference-value input:focus {
        background: #eff6ff;
    }

    /* =====================================================
       DESKRIPSI
    ===================================================== */

    .secure-description {
        width: 92%;

        margin-left: 4%;
        margin-bottom: 24px;

        table-layout: fixed;
    }

    .secure-description td {
        border: 1px solid #222;
    }

    .secure-description-title {
        padding: 9px;

        text-align: center;

        font-size: 14px;
        font-weight: bold;
    }

    .secure-app-wrap {
        width: 82%;

        margin: 6px auto 0;

        display: flex;
        justify-content: center;
        align-items: center;

        font-style: italic;
    }

    .secure-app-input {
        width: 82%;

        margin: 0 5px;
        padding: 5px;

        border: 0;
        border-bottom: 1px solid #777;

        outline: 0;

        background: transparent;

        text-align: center;

        font-size: 14px;
        font-weight: bold;
        font-style: italic;
    }

    .secure-app-input:focus {
        background: #eff6ff;

        border-bottom-color: #2563eb;
    }

    .secure-description-content {
        min-height: 320px;

        padding: 16px !important;

        vertical-align: top;
    }

    .secure-description-row {
        display: grid;

        grid-template-columns:
            170px
            22px
            1fr;

        align-items: start;

        margin-bottom: 10px;

        font-size: 14px;
        line-height: 1.35;
    }

    .secure-colon {
        text-align: center;
    }

    .secure-description-space {
        height: 18px;
    }

    .secure-function-guide {
        margin-top: 10px;

        font-size: 13px;
        font-style: italic;
        line-height: 1.8;
    }

    /* =====================================================
       CHECKLIST
    ===================================================== */

    .secure-checklist {
        width: 92%;

        margin-left: 4%;
        margin-bottom: 22px;

        table-layout: fixed;
    }

    .secure-checklist th,
    .secure-checklist td {
        padding: 9px;

        border: 1px solid #222;

        vertical-align: middle;

        font-size: 14px;
        line-height: 1.35;
    }

    .secure-checklist th {
        background: #dce9f8;
    }

    .secure-checklist-title {
        text-align: center;

        font-weight: bold;
    }

    .secure-number {
        width: 7%;

        text-align: center;
    }

    .secure-activity {
        width: 70%;
    }

    .secure-check {
        width: 23%;
    }

    .secure-options {
        display: flex;
        align-items: center;

        gap: 16px;

        white-space: nowrap;
    }

    .secure-options label {
        display: inline-flex;
        align-items: center;

        gap: 5px;

        cursor: pointer;
    }

    .secure-options input {
        width: 17px;
        height: 17px;
    }

    /* =====================================================
       TEMPAT/TANGGAL
    ===================================================== */

    .secure-place-date {
        width: 92%;

        margin-left: 4%;
        margin-top: 22px;
        margin-bottom: 15px;

        display: flex;
        justify-content: flex-end;
        align-items: center;

        gap: 6px;

        font-size: 14px;
    }

    .secure-place {
        width: 180px;
    }

    .secure-date {
        width: 160px;
    }

    /* =====================================================
       SIGNATURE
    ===================================================== */

    .secure-signature {
        width: 66%;

        margin-left: 30%;

        table-layout: fixed;
    }

    .secure-signature td {
        width: 50%;

        border: 1px solid #222;

        text-align: center;

        font-size: 14px;
    }

    .secure-signature-heading {
        height: 42px;

        padding: 6px;
    }

    .secure-signature-content {
        height: 155px;

        padding: 15px !important;

        vertical-align: bottom;
    }

    .secure-signature-input {
        width: 90%;

        margin-bottom: 8px;
        padding: 5px;

        border: 0;
        border-bottom: 1px dotted #333;

        outline: 0;

        background: transparent;

        text-align: center;

        font-size: 14px;
    }

    .secure-signature-input:focus {
        background: #eff6ff;

        border-bottom-color: #2563eb;
    }

    .secure-nipp {
        display: flex;
        align-items: center;
        justify-content: center;

        gap: 4px;
    }

    .secure-nipp input {
        width: 125px;
    }

    /* =====================================================
       ERROR
    ===================================================== */

    .secure-error {
        max-width: 1100px;

        margin: 20px auto;

        padding: 15px 20px;

        border: 1px solid #fecaca;
        border-radius: 6px;

        background: #fee2e2;

        color: #991b1b;
    }

    .secure-error ul {
        margin-bottom: 0;
    }

    /* =====================================================
       ACTIONS
    ===================================================== */

    .secure-actions {
        max-width: 1100px;

        margin: 20px auto 40px;

        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .secure-button {
        padding: 12px 22px;

        border: 0;
        border-radius: 6px;

        font-size: 14px;

        cursor: pointer;

        text-decoration: none;
    }

    .secure-back {
        background: #6b7280;
        color: white;
    }

    .secure-save {
        background: #2563eb;
        color: white;
    }

    @media (max-width: 900px) {

        .secure-form-page {
            padding: 20px;

            overflow-x: auto;
        }

        .secure-document {
            min-width: 820px;
        }
    }
</style>


@if($errors->any())

    <div class="secure-error">

        <strong>
            Data belum lengkap:
        </strong>

        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

    </div>

@endif


<div class="secure-form-page">

<div class="secure-document">


    {{-- HEADER --}}

    <table class="secure-header">

        <tr>

            <td class="secure-logo-column">

                <div class="secure-logo-box">

                    <img
                        src="{{ asset('images/logo-kai.png') }}"
                        alt="Logo KAI"
                        class="secure-logo"
                    >

                </div>

                <div class="secure-restricted-box">

                    <div class="secure-restricted">
                        TERBATAS
                    </div>

                </div>

            </td>


            <td class="secure-middle-column">

                <div class="secure-company">
                    PT KERETA API INDONESIA (PERSERO)
                    <br>
                    SISTEM INFORMASI
                </div>

                <div class="secure-title">
                    FORMULIR CHECKLIST 05
                    <br>
                    SECURE IMPLEMENT PREPARATION
                </div>

            </td>


            <td class="secure-info-cell">

                <table class="secure-info">

                    <tr>
                        <td class="secure-info-label">Nomor</td>
                        <td class="secure-info-value">
                            FR.IK/TI/005.01/10-2020
                        </td>
                    </tr>

                    <tr>
                        <td class="secure-info-label">Tanggal</td>
                        <td class="secure-info-value">
                            12 Oktober 2020
                        </td>
                    </tr>

                    <tr>
                        <td class="secure-info-label">Versi</td>
                        <td class="secure-info-value">
                            002-2020
                        </td>
                    </tr>

                    <tr>
                        <td class="secure-info-label">Halaman</td>
                        <td class="secure-info-value">
                            1 dari 1
                        </td>
                    </tr>

                </table>

            </td>

        </tr>

    </table>


    {{-- REFERENCE --}}

    <table class="secure-reference">

        <tr>

            <td class="secure-reference-label">
                No. Ref
            </td>

            <td class="secure-reference-colon">
                :
            </td>

            <td class="secure-reference-value">

                <input
                    type="text"
                    name="no_ref"
                    value="{{ old('no_ref', $form->no_ref ?? '') }}"
                    required
                >

            </td>

        </tr>


        <tr>

            <td class="secure-reference-label">
                Tanggal
            </td>

            <td class="secure-reference-colon">
                :
            </td>

            <td class="secure-reference-value">

                <input
                    type="date"
                    name="tanggal"
                    value="{{ $tanggal }}"
                    required
                >

            </td>

        </tr>


        <tr>

            <td class="secure-reference-label">
                Business Area
            </td>

            <td class="secure-reference-colon">
                :
            </td>

            <td class="secure-reference-value">

                <input
                    type="text"
                    name="business_area"
                    value="{{ old(
                        'business_area',
                        $form->business_area ?? ''
                    ) }}"
                    required
                >

            </td>

        </tr>

    </table>


    {{-- DESKRIPSI --}}

    <table class="secure-description">

        <tr>

            <td class="secure-description-title">

                DESKRIPSI

                <div class="secure-app-wrap">

                    <span>&lt;</span>

                    <input
                        type="text"
                        name="nama_aplikasi"
                        class="secure-app-input"
                        placeholder="NAMA APLIKASI"
                        value="{{ old(
                            'nama_aplikasi',
                            $form->nama_aplikasi ?? ''
                        ) }}"
                        required
                    >

                    <span>&gt;</span>

                </div>

            </td>

        </tr>


        <tr>

            <td class="secure-description-content">


                <div class="secure-description-row">

                    <div>Tanggal Checklist</div>

                    <div class="secure-colon">:</div>

                    <div>

                        <input
                            type="date"
                            name="tanggal_checklist"
                            class="secure-input"
                            value="{{ $tanggalChecklist }}"
                            required
                        >

                    </div>

                </div>


                <div class="secure-description-row">

                    <div>Deskripsi</div>

                    <div class="secure-colon">:</div>

                    <div>

                        <textarea
                            name="deskripsi"
                            class="secure-input"
                            required
                        >{{ old(
                            'deskripsi',
                            $form->deskripsi ?? ''
                        ) }}</textarea>

                    </div>

                </div>


                <div class="secure-description-space"></div>


                <div class="secure-description-row">

                    <div>Versi Aplikasi</div>

                    <div class="secure-colon">:</div>

                    <div>

                        <input
                            type="text"
                            name="versi_aplikasi"
                            class="secure-input"
                            value="{{ old(
                                'versi_aplikasi',
                                $form->versi_aplikasi ?? ''
                            ) }}"
                            required
                        >

                    </div>

                </div>


                <div class="secure-description-row">

                    <div>Modul</div>

                    <div class="secure-colon">:</div>

                    <div>

                        <input
                            type="text"
                            name="modul"
                            class="secure-input"
                            value="{{ old(
                                'modul',
                                $form->modul ?? ''
                            ) }}"
                            required
                        >

                    </div>

                </div>


                <div class="secure-description-row">

                    <div>Fungsi</div>

                    <div class="secure-colon">:</div>

                    <div>

                        <textarea
                            name="fungsi"
                            class="secure-input"
                            required
                        >{{ old(
                            'fungsi',
                            $form->fungsi ?? ''
                        ) }}</textarea>

                    </div>

                </div>

            </td>

        </tr>

    </table>


    {{-- CHECKLIST --}}

    <table class="secure-checklist">

        <thead>

            <tr>

                <th
                    colspan="3"
                    class="secure-checklist-title"
                >
                    CHECKLIST 05 SECURE IMPLEMENT PREPARATION
                </th>

            </tr>

            <tr>
                <th class="secure-number">No</th>
                <th class="secure-activity">Activity</th>
                <th class="secure-check">Check</th>
            </tr>

        </thead>


        <tbody>

            <tr>

                <td class="secure-number">
                    1
                </td>

                <td class="secure-activity">
                    Membuat dokumen TSD
                    (<i>Technical Specification Document</i>)
                    oleh <i>Business Analyst</i> (BA)
                </td>

                <td class="secure-check">

                    <div class="secure-options">

                        <label>

                            <input
                                type="radio"
                                name="check_tsd"
                                value="YA"
                                {{ old(
                                    'check_tsd',
                                    $form->check_tsd ?? ''
                                ) === 'YA' ? 'checked' : '' }}
                                required
                            >

                            Ya

                        </label>


                        <label>

                            <input
                                type="radio"
                                name="check_tsd"
                                value="TIDAK"
                                {{ old(
                                    'check_tsd',
                                    $form->check_tsd ?? ''
                                ) === 'TIDAK' ? 'checked' : '' }}
                            >

                            Tidak

                        </label>

                    </div>

                </td>

            </tr>


            <tr>

                <td class="secure-number">
                    2
                </td>

                <td class="secure-activity">
                    Membuat dokumen
                    <i>User Manual</i>
                    oleh <i>Business Analyst</i> (BA)
                </td>

                <td class="secure-check">

                    <div class="secure-options">

                        <label>

                            <input
                                type="radio"
                                name="check_user_manual"
                                value="YA"
                                {{ old(
                                    'check_user_manual',
                                    $form->check_user_manual ?? ''
                                ) === 'YA' ? 'checked' : '' }}
                                required
                            >

                            Ya

                        </label>


                        <label>

                            <input
                                type="radio"
                                name="check_user_manual"
                                value="TIDAK"
                                {{ old(
                                    'check_user_manual',
                                    $form->check_user_manual ?? ''
                                ) === 'TIDAK' ? 'checked' : '' }}
                            >

                            Tidak

                        </label>

                    </div>

                </td>

            </tr>

        </tbody>

    </table>


    {{-- TEMPAT / TANGGAL --}}

    <div class="secure-place-date">

        <input
            type="text"
            name="tempat"
            class="secure-input secure-place"
            placeholder="Tempat"
            value="{{ old(
                'tempat',
                $form->tempat ?? ''
            ) }}"
            required
        >

        <span>,</span>

        <input
            type="date"
            name="tanggal_ttd"
            class="secure-input secure-date"
            value="{{ $tanggalTtd }}"
            required
        >

    </div>


    {{-- TANDA TANGAN --}}

    <table class="secure-signature">

        <tr>

            <td class="secure-signature-heading">
                Mengetahui,
            </td>

            <td class="secure-signature-heading">
                Pelaksana Checklist,
            </td>

        </tr>


        <tr>

            <td class="secure-signature-content">

                <input
                    type="text"
                    name="mengetahui_nama"
                    class="secure-signature-input"
                    placeholder="Nama"
                    value="{{ old(
                        'mengetahui_nama',
                        $form->mengetahui_nama ?? ''
                    ) }}"
                    required
                >

                <div class="secure-nipp">

                    <span>NIPP.</span>

                    <input
                        type="text"
                        name="mengetahui_nipp"
                        class="secure-signature-input"
                        value="{{ old(
                            'mengetahui_nipp',
                            $form->mengetahui_nipp ?? ''
                        ) }}"
                        required
                    >

                </div>

            </td>


            <td class="secure-signature-content">

                <input
                    type="text"
                    name="pelaksana_nama"
                    class="secure-signature-input"
                    placeholder="Nama"
                    value="{{ old(
                        'pelaksana_nama',
                        $form->pelaksana_nama ?? ''
                    ) }}"
                    required
                >

                <div class="secure-nipp">

                    <span>NIPP.</span>

                    <input
                        type="text"
                        name="pelaksana_nipp"
                        class="secure-signature-input"
                        value="{{ old(
                            'pelaksana_nipp',
                            $form->pelaksana_nipp ?? ''
                        ) }}"
                        required
                    >

                </div>

            </td>

        </tr>

    </table>

</div>
</div>