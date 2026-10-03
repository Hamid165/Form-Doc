{{-- MODAL KONFIRMASI KAI --}}
<div
    id="availabilityConfirmModal"
    class="availability-confirm-modal"
    aria-hidden="true"
>
    {{-- BACKDROP --}}
    <div
        class="availability-confirm-backdrop"
        data-availability-confirm-close
    ></div>

    {{-- DIALOG --}}
    <div
        class="availability-confirm-dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="availabilityConfirmTitle"
        aria-describedby="availabilityConfirmMessage"
    >

        {{-- ILUSTRASI KERETA --}}
        <div
            id="availabilityConfirmFigure"
            class="availability-confirm-figure"
        >
            <svg
                class="availability-confirm-illustration"
                viewBox="0 0 320 220"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
            >
                {{-- LATAR --}}
                <path
                    class="availability-confirm-bg"
                    d="M63 170C40 151 33 119 47 93C61 68 91 60 114 70C132 39 177 28 208 50C229 65 240 91 235 116C258 122 273 143 267 164C261 184 239 195 217 195H95C82 195 71 183 63 170Z"
                />

                {{-- PAPAN INFORMASI --}}
                <rect
                    class="availability-confirm-document"
                    x="206"
                    y="28"
                    width="78"
                    height="65"
                    rx="10"
                />

                <path
                    class="availability-confirm-blue-line"
                    d="M224 48H265"
                    stroke-linecap="round"
                />

                <path
                    class="availability-confirm-gray-line"
                    d="M224 62H257"
                    stroke-width="4"
                    stroke-linecap="round"
                />

                <path
                    class="availability-confirm-orange-line"
                    d="M224 77H246"
                    stroke-width="4"
                    stroke-linecap="round"
                />

                {{-- LINGKARAN AKSI --}}
                <circle
                    class="availability-confirm-plus-circle"
                    cx="67"
                    cy="61"
                    r="23"
                />

                <path
                    class="availability-confirm-plus-line"
                    d="M67 50V72"
                />

                <path
                    class="availability-confirm-plus-line"
                    d="M56 61H78"
                />

                {{-- BADAN KERETA --}}
                <rect
                    class="availability-confirm-train"
                    x="83"
                    y="85"
                    width="152"
                    height="87"
                    rx="23"
                />

                {{-- KACA --}}
                <path
                    class="availability-confirm-window"
                    d="M104 103C104 96.3726 109.373 91 116 91H201C207.627 91 213 96.3726 213 103V124H104V103Z"
                />

                <path
                    class="availability-confirm-dark-line"
                    d="M158 92V123"
                />

                {{-- GARIS KAI --}}
                <path
                    class="availability-confirm-blue-line"
                    d="M85 133H233"
                />

                <path
                    class="availability-confirm-orange-line"
                    d="M85 144H233"
                />

                {{-- LAMPU --}}
                <circle
                    class="availability-confirm-train"
                    cx="111"
                    cy="158"
                    r="8"
                />

                <circle
                    class="availability-confirm-train"
                    cx="207"
                    cy="158"
                    r="8"
                />

                {{-- REL --}}
                <path
                    class="availability-confirm-orange-line"
                    d="M63 173H257"
                    stroke-linecap="round"
                />

                <path
                    class="availability-confirm-gray-line"
                    d="M80 190H241"
                    stroke-linecap="round"
                />

                <path
                    class="availability-confirm-gray-line"
                    d="M100 180L91 200"
                    stroke-linecap="round"
                />

                <path
                    class="availability-confirm-gray-line"
                    d="M139 180L130 200"
                    stroke-linecap="round"
                />

                <path
                    class="availability-confirm-gray-line"
                    d="M178 180L169 200"
                    stroke-linecap="round"
                />

                <path
                    class="availability-confirm-gray-line"
                    d="M217 180L208 200"
                    stroke-linecap="round"
                />
            </svg>
        </div>


        {{-- TEKS --}}
        <div class="availability-confirm-content">

            <h3
                id="availabilityConfirmTitle"
                class="availability-confirm-title"
            >
                Konfirmasi Aksi
            </h3>

            <p
                id="availabilityConfirmMessage"
                class="availability-confirm-message"
            >
                Apakah Anda yakin ingin melanjutkan?
            </p>

        </div>


        {{-- TOMBOL --}}
        <div class="availability-confirm-actions">

            <button
                type="button"
                data-availability-confirm-close
                class="availability-confirm-cancel"
            >
                Batal
            </button>

            <button
                type="button"
                id="availabilityConfirmSubmit"
                class="availability-confirm-submit"
            >
                Lanjutkan
            </button>

        </div>

    </div>
</div>
