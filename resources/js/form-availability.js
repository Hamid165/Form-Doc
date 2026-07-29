/*
 * =========================================================
 * CETAK LAPORAN AVAILABILITY
 * Digunakan pada halaman show.blade.php
 * =========================================================
 */

window.printAvailabilityReport = function () {
    const report = document.querySelector(
        '.availability-report'
    );

    if (!report) {
        alert('Dokumen laporan tidak ditemukan.');
        return;
    }

    const printWindow = window.open(
        '',
        '_blank',
        'width=1100,height=850'
    );

    if (!printWindow) {
        alert(
            'Popup diblokir browser. '
            + 'Izinkan popup untuk mencetak PDF.'
        );

        return;
    }

    const stylesheetLinks = Array.from(
        document.querySelectorAll(
            'link[rel="stylesheet"]'
        )
    )
        .map((link) => {
            return `
                <link
                    rel="stylesheet"
                    href="${link.href}"
                >
            `;
        })
        .join('');

    const inlineStyles = Array.from(
        document.querySelectorAll('style')
    )
        .map((style) => style.outerHTML)
        .join('');

    const documentTitle =
        document.title
        || 'Availability System Ticketing';

    printWindow.document.open();

    printWindow.document.write(`
        <!DOCTYPE html>

        <html lang="id">

        <head>
            <meta charset="UTF-8">

            <meta
                name="viewport"
                content="width=device-width, initial-scale=1.0"
            >

            <base href="${document.baseURI}">

            <title>${documentTitle}</title>

            ${stylesheetLinks}
            ${inlineStyles}

            <style>
                @page {
                    size: A4 portrait;
                    margin: 6mm;
                }

                html,
                body {
                    display: block !important;
                    width: 100% !important;
                    height: auto !important;
                    margin: 0 !important;
                    padding: 0 !important;
                    overflow: visible !important;
                    background: #ffffff !important;
                }

                body {
                    font-family: Arial, Helvetica, sans-serif;
                }

                .availability-report {
                    display: block !important;
                    width: 198mm !important;
                    max-width: 198mm !important;
                    min-height: auto !important;
                    margin: 0 auto !important;
                    padding: 4mm !important;
                    box-sizing: border-box !important;
                    background: #ffffff !important;
                    box-shadow: none !important;
                }

                .document-header-table,
                .availability-document-table,
                .reference-table,
                .summary-table {
                    width: 100% !important;
                    min-width: 0 !important;
                }

                .document-header-table,
                .availability-document-table {
                    border-collapse: collapse !important;
                }

                .availability-document-table tr,
                .document-footer,
                .document-signature,
                .signature-identity {
                    break-inside: avoid !important;
                    page-break-inside: avoid !important;
                }

                .no-print {
                    display: none !important;
                }

                * {
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }
            </style>
        </head>

        <body>

            ${report.outerHTML}

            <script>
                function waitForImages() {
                    const images = Array.from(
                        document.images
                    );

                    return Promise.all(
                        images.map(function (image) {
                            if (image.complete) {
                                return Promise.resolve();
                            }

                            return new Promise(function (
                                resolve
                            ) {
                                image.addEventListener(
                                    'load',
                                    resolve,
                                    {
                                        once: true
                                    }
                                );

                                image.addEventListener(
                                    'error',
                                    resolve,
                                    {
                                        once: true
                                    }
                                );
                            });
                        })
                    );
                }

                window.addEventListener(
                    'load',
                    function () {
                        waitForImages().then(function () {
                            setTimeout(function () {
                                window.print();
                            }, 300);
                        });
                    }
                );

                window.addEventListener(
                    'afterprint',
                    function () {
                        window.close();
                    }
                );
            <\/script>

        </body>

        </html>
    `);

    printWindow.document.close();
};

/*
 * =========================================================
 * CETAK PDF DARI HALAMAN INDEX
 * Mengambil dokumen dari halaman detail yang sudah ada
 * =========================================================
 */

window.printAvailabilityReportFromUrl = async function (
    url
) {
    /*
     * Popup dibuka langsung ketika tombol diklik,
     * supaya tidak diblokir browser.
     */
    const printWindow = window.open(
        '',
        '_blank',
        'width=1100,height=850'
    );

    if (!printWindow) {
        alert(
            'Popup diblokir browser. '
            + 'Izinkan popup untuk mencetak PDF.'
        );

        return;
    }

    printWindow.document.open();

    printWindow.document.write(`
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>Menyiapkan dokumen...</title>

            <style>
                body {
                    margin: 0;
                    padding: 40px;
                    color: #4b5563;
                    font-family: Arial, Helvetica, sans-serif;
                    font-size: 14px;
                    text-align: center;
                }
            </style>
        </head>

        <body>
            Menyiapkan dokumen PDF...
        </body>
        </html>
    `);

    printWindow.document.close();

    try {
        const response = await fetch(url, {
            method: 'GET',

            headers: {
                Accept: 'text/html',

                'X-Requested-With':
                    'XMLHttpRequest',
            },
        });

        if (!response.ok) {
            throw new Error(
                `Dokumen gagal dimuat (${response.status}).`
            );
        }

        const html =
            await response.text();

        const parser =
            new DOMParser();

        const detailDocument =
            parser.parseFromString(
                html,
                'text/html'
            );

        const report =
            detailDocument.querySelector(
                '.availability-report'
            );

        if (!report) {
            throw new Error(
                'Dokumen laporan tidak ditemukan.'
            );
        }

        /*
         * Ambil seluruh stylesheet dari halaman detail.
         */
        const stylesheetLinks = Array.from(
            detailDocument.querySelectorAll(
                'link[rel="stylesheet"]'
            )
        )
            .map((link) => {
                const originalHref =
                    link.getAttribute('href');

                if (!originalHref) {
                    return '';
                }

                const resolvedHref =
                    new URL(
                        originalHref,
                        url
                    ).href;

                return `
                    <link
                        rel="stylesheet"
                        href="${resolvedHref}"
                    >
                `;
            })
            .join('');

        /*
         * Ambil style inline dari halaman detail.
         */
        const inlineStyles = Array.from(
            detailDocument.querySelectorAll(
                'style'
            )
        )
            .map((style) => style.outerHTML)
            .join('');

        const documentTitle =
            detailDocument.title
            || 'Availability System Ticketing';

        printWindow.document.open();

        printWindow.document.write(`
            <!DOCTYPE html>

            <html lang="id">

            <head>
                <meta charset="UTF-8">

                <meta
                    name="viewport"
                    content="width=device-width, initial-scale=1.0"
                >

                <base href="${url}">

                <title>${documentTitle}</title>

                ${stylesheetLinks}
                ${inlineStyles}

                <style>
                    @page {
                        size: A4 portrait;
                        margin: 6mm;
                    }

                    html,
                    body {
                        display: block !important;
                        width: 100% !important;
                        height: auto !important;
                        margin: 0 !important;
                        padding: 0 !important;
                        overflow: visible !important;
                        background: #ffffff !important;
                    }

                    body {
                        font-family:
                            Arial,
                            Helvetica,
                            sans-serif;
                    }

                    .availability-report {
                        display: block !important;
                        width: 198mm !important;
                        max-width: 198mm !important;
                        min-height: auto !important;
                        margin: 0 auto !important;
                        padding: 4mm !important;
                        box-sizing: border-box !important;
                        background: #ffffff !important;
                        box-shadow: none !important;
                    }

                    .document-header-table,
                    .availability-document-table,
                    .reference-table,
                    .summary-table {
                        width: 100% !important;
                        min-width: 0 !important;
                    }

                    .document-header-table,
                    .availability-document-table {
                        border-collapse: collapse !important;
                    }

                    .availability-document-table tr,
                    .document-footer,
                    .document-signature,
                    .signature-identity {
                        break-inside: avoid !important;
                        page-break-inside: avoid !important;
                    }

                    .no-print {
                        display: none !important;
                    }

                    * {
                        -webkit-print-color-adjust:
                            exact !important;

                        print-color-adjust:
                            exact !important;
                    }
                </style>
            </head>

            <body>

                ${report.outerHTML}

                <script>
                    function waitForImages() {
                        const images = Array.from(
                            document.images
                        );

                        return Promise.all(
                            images.map(function (image) {
                                if (image.complete) {
                                    return Promise.resolve();
                                }

                                return new Promise(function (
                                    resolve
                                ) {
                                    image.addEventListener(
                                        'load',
                                        resolve,
                                        {
                                            once: true
                                        }
                                    );

                                    image.addEventListener(
                                        'error',
                                        resolve,
                                        {
                                            once: true
                                        }
                                    );
                                });
                            })
                        );
                    }

                    window.addEventListener(
                        'load',
                        function () {
                            waitForImages().then(function () {
                                setTimeout(function () {
                                    window.print();
                                }, 300);
                            });
                        }
                    );

                    window.addEventListener(
                        'afterprint',
                        function () {
                            window.close();
                        }
                    );
                <\/script>

            </body>

            </html>
        `);

        printWindow.document.close();
    } catch (error) {
        console.error(
            'Cetak PDF gagal:',
            error
        );

        printWindow.document.open();

        printWindow.document.write(`
            <!DOCTYPE html>
            <html lang="id">
            <head>
                <meta charset="UTF-8">
                <title>Gagal mencetak</title>

                <style>
                    body {
                        margin: 0;
                        padding: 40px;
                        color: #991b1b;
                        font-family:
                            Arial,
                            Helvetica,
                            sans-serif;
                        text-align: center;
                    }
                </style>
            </head>

            <body>
                Dokumen gagal disiapkan untuk dicetak.
            </body>
            </html>
        `);

        printWindow.document.close();
    }
};


/*
 * Event delegation agar tombol tetap berfungsi
 * setelah tabel berubah karena live search.
 */
document.addEventListener(
    'click',
    (event) => {
        const printButton =
            event.target.closest(
                '[data-availability-print-url]'
            );

        if (!printButton) {
            return;
        }

        event.preventDefault();

        const url =
            printButton.dataset
                .availabilityPrintUrl;

        if (!url) {
            alert(
                'Alamat dokumen tidak ditemukan.'
            );

            return;
        }

        window.printAvailabilityReportFromUrl(
            url
        );
    }
);
/*
 * =========================================================
 * FORM DETAIL AVAILABILITY
 * Digunakan pada halaman create dan edit
 * =========================================================
 */

document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById(
        'detailGangguan'
    );

    const addButton = document.getElementById(
        'btnTambahGangguan'
    );

    const template = document.getElementById(
        'detailGangguanTemplate'
    );

    /*
     * Tidak dijalankan pada halaman index dan show.
     */
    if (!container || !addButton || !template) {
        return;
    }

    const getCards = () => {
        return Array.from(
            container.querySelectorAll(
                '[data-detail-card]'
            )
        );
    };

    const closeAllExcept = (activeCard) => {
        getCards().forEach((card) => {
            if (card !== activeCard) {
                card.classList.remove('is-open');
            }
        });
    };

    const openCard = (card) => {
        if (!card) {
            return;
        }

        closeAllExcept(card);

        card.classList.add('is-open');
    };

    const updateSummary = (card) => {
        const stationInput = card.querySelector(
            '.js-station-input'
        );

        const rtsInput = card.querySelector(
            '.js-rts-input:checked'
        ) || card.querySelector(
            'select.js-rts-input'
        );

        const deviceInput = card.querySelector(
            '.js-device-input'
        );

        const disturbanceInput = card.querySelector(
            '.js-disturbance-input'
        );

        const stationSummary = card.querySelector(
            '[data-summary-station]'
        );

        const rtsSummary = card.querySelector(
            '[data-summary-rts]'
        );

        const deviceSummary = card.querySelector(
            '[data-summary-device]'
        );

        const disturbanceSummary = card.querySelector(
            '[data-summary-disturbance]'
        );

        if (stationSummary) {
            stationSummary.textContent =
                stationInput?.value.trim()
                || 'Stasiun belum diisi';
        }

        if (rtsSummary) {
            if (!rtsInput) {
                rtsSummary.textContent =
                    'RTS belum dipilih';
            } else if (rtsInput.tagName === 'SELECT') {
                const selectedOption =
                    rtsInput.options[
                        rtsInput.selectedIndex
                    ];

                rtsSummary.textContent =
                    selectedOption?.value
                        ? selectedOption.textContent.trim()
                        : 'RTS belum dipilih';
            } else {
                rtsSummary.textContent =
                    rtsInput.value
                    || 'RTS belum dipilih';
            }
        }

        if (deviceSummary) {
            deviceSummary.textContent =
                deviceInput?.value || '0';
        }

        if (disturbanceSummary) {
            disturbanceSummary.textContent =
                disturbanceInput?.value || '0';
        }
    };

    const updateDeleteButtons = () => {
        const cards = getCards();

        const disabled =
            cards.length <= 1;

        cards.forEach((card) => {
            const button = card.querySelector(
                '.js-delete-detail'
            );

            if (button) {
                button.disabled = disabled;
            }
        });
    };

    const reindexCards = () => {
        getCards().forEach((card, index) => {
            const number = index + 1;

            const numberLabel = card.querySelector(
                '[data-detail-number]'
            );

            const numberInput = card.querySelector(
                '.js-detail-number-input'
            );

            if (numberLabel) {
                numberLabel.textContent =
                    `Detail ${number}`;
            }

            if (numberInput) {
                numberInput.value =
                    String(number);
            }

            card.querySelectorAll(
                'input[name], select[name], textarea[name]'
            ).forEach((field) => {
                field.name = field.name.replace(
                    /items\[\d+\]/g,
                    `items[${index}]`
                );
            });

            updateSummary(card);
        });

        updateDeleteButtons();
    };

    addButton.addEventListener(
        'click',
        () => {
            const index =
                getCards().length;

            const number =
                index + 1;

            const html = template.innerHTML
                .replaceAll(
                    '__INDEX__',
                    String(index)
                )
                .replaceAll(
                    '__NUMBER__',
                    String(number)
                );

            const wrapper =
                document.createElement('div');

            wrapper.innerHTML =
                html.trim();

            const newCard =
                wrapper.firstElementChild;

            if (!newCard) {
                return;
            }

            getCards().forEach((card) => {
                card.classList.remove(
                    'is-open'
                );
            });

            container.appendChild(
                newCard
            );

            reindexCards();

            openCard(newCard);

            newCard
                .querySelector(
                    '.js-station-input'
                )
                ?.focus();

            newCard.scrollIntoView({
                behavior: 'smooth',
                block: 'center',
            });
        }
    );

    container.addEventListener(
        'click',
        (event) => {
            const toggleButton =
                event.target.closest(
                    '.js-toggle-detail'
                );

            if (toggleButton) {
                const card =
                    toggleButton.closest(
                        '[data-detail-card]'
                    );

                if (!card) {
                    return;
                }

                if (
                    card.classList.contains(
                        'is-open'
                    )
                ) {
                    card.classList.remove(
                        'is-open'
                    );
                } else {
                    openCard(card);
                }

                return;
            }

            const deleteButton =
                event.target.closest(
                    '.js-delete-detail'
                );

            if (!deleteButton) {
                return;
            }

            const cards = getCards();

            if (cards.length <= 1) {
                return;
            }

            const card =
                deleteButton.closest(
                    '[data-detail-card]'
                );

            if (!card) {
                return;
            }

            const cardIndex =
                cards.indexOf(card);

            card.remove();

            reindexCards();

            const remainingCards =
                getCards();

            const nextCard =
                remainingCards[cardIndex]
                || remainingCards[
                    cardIndex - 1
                ]
                || remainingCards[0];

            openCard(nextCard);
        }
    );

    container.addEventListener(
        'input',
        (event) => {
            const card =
                event.target.closest(
                    '[data-detail-card]'
                );

            if (card) {
                updateSummary(card);
            }
        }
    );

    container.addEventListener(
        'change',
        (event) => {
            const card =
                event.target.closest(
                    '[data-detail-card]'
                );

            if (card) {
                updateSummary(card);
            }
        }
    );

    document.addEventListener(
        'invalid',
        (event) => {
            const card =
                event.target.closest?.(
                    '[data-detail-card]'
                );

            if (card) {
                openCard(card);
            }
        },
        true
    );

    reindexCards();

    const cards = getCards();

    if (
        cards.length > 0
        && !cards.some((card) => {
            return card.classList.contains(
                'is-open'
            );
        })
    ) {
        cards[0].classList.add(
            'is-open'
        );
    }
});


/*
 * =========================================================
 * LIVE SEARCH AVAILABILITY
 * Digunakan pada halaman index.blade.php
 * =========================================================
 */

document.addEventListener('DOMContentLoaded', () => {
    const searchForm = document.getElementById(
        'availabilitySearchForm'
    );

    const searchInput = document.getElementById(
        'availabilitySearchInput'
    );

    const resetButton = document.getElementById(
        'availabilityResetSearch'
    );

    const loadingElement = document.getElementById(
        'availabilitySearchLoading'
    );

    /*
     * Tidak dijalankan pada halaman create,
     * edit, dan show.
     */
    if (!searchForm || !searchInput) {
        return;
    }

    let debounceTimer = null;

    let activeController = null;

    let requestSequence = 0;

    const setLoading = (isLoading) => {
        if (!loadingElement) {
            return;
        }

        loadingElement.classList.toggle(
            'hidden',
            !isLoading
        );

        loadingElement.classList.toggle(
            'flex',
            isLoading
        );
    };

    const updateResetButton = () => {
        if (!resetButton) {
            return;
        }

        const hasKeyword =
            searchInput.value.trim() !== '';

        resetButton.classList.toggle(
            'hidden',
            !hasKeyword
        );
    };

    const buildSearchUrl = () => {
        const url = new URL(
            searchForm.action,
            window.location.origin
        );

        const keyword =
            searchInput.value.trim();

        if (keyword !== '') {
            url.searchParams.set(
                'search',
                keyword
            );
        } else {
            url.searchParams.delete(
                'search'
            );
        }

        /*
         * Setiap pencarian baru dimulai
         * dari halaman pertama.
         */
        url.searchParams.delete('page');

        return url;
    };

    const replaceSearchResult = (
        html
    ) => {
        const parser =
            new DOMParser();

        const responseDocument =
            parser.parseFromString(
                html,
                'text/html'
            );

        const newResult =
            responseDocument.getElementById(
                'availabilityTableResult'
            );

        const currentResult =
            document.getElementById(
                'availabilityTableResult'
            );

        const newTotal =
            responseDocument.getElementById(
                'availabilityTotalData'
            );

        const currentTotal =
            document.getElementById(
                'availabilityTotalData'
            );

        if (!newResult || !currentResult) {
            throw new Error(
                'Bagian tabel tidak ditemukan.'
            );
        }

        currentResult.innerHTML =
            newResult.innerHTML;

        if (newTotal && currentTotal) {
            currentTotal.textContent =
                newTotal.textContent.trim();
        }
    };

    const loadSearchResult = async (
        url,
        updateBrowserUrl = true
    ) => {
        /*
         * Membatalkan request sebelumnya saat
         * pengguna masih mengetik.
         */
        if (activeController) {
            activeController.abort();
        }

        const controller =
            new AbortController();

        activeController =
            controller;

        const currentSequence =
            ++requestSequence;

        setLoading(true);

        try {
            const response = await fetch(
                url.toString(),
                {
                    method: 'GET',

                    headers: {
                        Accept: 'text/html',

                        'X-Requested-With':
                            'XMLHttpRequest',
                    },

                    signal:
                        controller.signal,
                }
            );

            if (!response.ok) {
                throw new Error(
                    `Pencarian gagal (${response.status}).`
                );
            }

            const html =
                await response.text();

            /*
             * Cegah response lama menimpa
             * hasil request terbaru.
             */
            if (
                currentSequence
                !== requestSequence
            ) {
                return;
            }

            replaceSearchResult(html);

            if (updateBrowserUrl) {
                window.history.replaceState(
                    {
                        availabilitySearch: true,
                    },
                    '',
                    url.toString()
                );
            }

            updateResetButton();
        } catch (error) {
            if (
                error.name !== 'AbortError'
            ) {
                console.error(
                    'Availability search error:',
                    error
                );
            }
        } finally {
            if (
                currentSequence
                === requestSequence
            ) {
                setLoading(false);

                activeController = null;
            }
        }
    };

    const executeSearch = () => {
        const url =
            buildSearchUrl();

        loadSearchResult(
            url,
            true
        );
    };

    /*
     * Search otomatis setelah pengguna
     * berhenti mengetik selama 400 ms.
     */
    searchInput.addEventListener(
        'input',
        () => {
            updateResetButton();

            window.clearTimeout(
                debounceTimer
            );

            debounceTimer =
                window.setTimeout(
                    executeSearch,
                    400
                );
        }
    );

    /*
     * Enter tetap melakukan pencarian,
     * tetapi tanpa reload halaman penuh.
     */
    searchForm.addEventListener(
        'submit',
        (event) => {
            event.preventDefault();

            window.clearTimeout(
                debounceTimer
            );

            executeSearch();
        }
    );

    /*
     * Reset pencarian.
     */
    if (resetButton) {
        resetButton.addEventListener(
            'click',
            () => {
                searchInput.value = '';

                updateResetButton();

                window.clearTimeout(
                    debounceTimer
                );

                executeSearch();

                searchInput.focus();
            }
        );
    }

    /*
     * Pagination diproses dengan AJAX.
     */
    document.addEventListener(
        'click',
        (event) => {
            const paginationLink =
                event.target.closest(
                    '#availabilityTableResult nav a'
                );

            if (!paginationLink) {
                return;
            }

            event.preventDefault();

            const url = new URL(
                paginationLink.href,
                window.location.origin
            );

            loadSearchResult(
                url,
                true
            );
        }
    );

    /*
     * Menangani tombol Back dan Forward browser.
     */
    window.addEventListener(
        'popstate',
        () => {
            const currentUrl =
                new URL(
                    window.location.href
                );

            const keyword =
                currentUrl.searchParams.get(
                    'search'
                ) || '';

            searchInput.value =
                keyword;

            updateResetButton();

            loadSearchResult(
                currentUrl,
                false
            );
        }
    );

    updateResetButton();
});


/*
 * =========================================================
 * LIVE SEARCH MASTER SIGNER
 * Mengubah hanya tabel signer tanpa reload halaman.
 * =========================================================
 */

document.addEventListener('DOMContentLoaded', () => {
    const searchForm = document.getElementById(
        'masterSignerSearchForm'
    );

    const searchInput = document.getElementById(
        'masterSignerSearchInput'
    );

    const resetButton = document.getElementById(
        'masterSignerResetSearch'
    );

    const loadingElement = document.getElementById(
        'masterSignerSearchLoading'
    );

    if (!searchForm || !searchInput) {
        return;
    }

    let debounceTimer = null;
    let activeController = null;
    let requestSequence = 0;

    const setLoading = (isLoading) => {
        if (!loadingElement) {
            return;
        }

        loadingElement.classList.toggle(
            'hidden',
            !isLoading
        );

        loadingElement.classList.toggle(
            'flex',
            isLoading
        );
    };

    const updateResetButton = () => {
        if (!resetButton) {
            return;
        }

        const hasKeyword =
            searchInput.value.trim() !== '';

        resetButton.classList.toggle(
            'hidden',
            !hasKeyword
        );
    };

    const buildSearchUrl = () => {
        const url = new URL(
            searchForm.action,
            window.location.origin
        );

        const keyword =
            searchInput.value.trim();

        if (keyword !== '') {
            url.searchParams.set(
                'signer_search',
                keyword
            );
        } else {
            url.searchParams.delete(
                'signer_search'
            );
        }

        /*
         * Menjaga tab Master Signer tetap aktif,
         * termasuk setelah halaman direfresh.
         */
        url.searchParams.set(
            'signer_page',
            '1'
        );

        return url;
    };

    const replaceSearchResult = (html) => {
        const parser =
            new DOMParser();

        const responseDocument =
            parser.parseFromString(
                html,
                'text/html'
            );

        const newResult =
            responseDocument.getElementById(
                'masterSignerTableResult'
            );

        const currentResult =
            document.getElementById(
                'masterSignerTableResult'
            );

        const newTotal =
            responseDocument.getElementById(
                'masterSignerTotalData'
            );

        const currentTotal =
            document.getElementById(
                'masterSignerTotalData'
            );

        if (!newResult || !currentResult) {
            throw new Error(
                'Bagian tabel Master Signer tidak ditemukan.'
            );
        }

        /*
         * Bersihkan directive Alpine lama sebelum
         * isi tabel diganti, jika Alpine tersedia.
         */
        if (
            window.Alpine
            && typeof window.Alpine.destroyTree
                === 'function'
        ) {
            window.Alpine.destroyTree(
                currentResult
            );
        }

        currentResult.innerHTML =
            newResult.innerHTML;

        if (newTotal && currentTotal) {
            currentTotal.textContent =
                newTotal.textContent.trim();
        }

        /*
         * Aktifkan kembali @click tombol Edit dan
         * tombol Tambah Signer pada empty state.
         */
        if (
            window.Alpine
            && typeof window.Alpine.initTree
                === 'function'
        ) {
            window.Alpine.initTree(
                currentResult
            );
        }
    };

    const loadSearchResult = async (
        url,
        updateBrowserUrl = true
    ) => {
        if (activeController) {
            activeController.abort();
        }

        const controller =
            new AbortController();

        activeController = controller;

        const currentSequence =
            ++requestSequence;

        setLoading(true);

        try {
            const response = await fetch(
                url.toString(),
                {
                    method: 'GET',

                    headers: {
                        Accept: 'text/html',

                        'X-Requested-With':
                            'XMLHttpRequest',
                    },

                    signal:
                        controller.signal,
                }
            );

            if (!response.ok) {
                throw new Error(
                    `Pencarian signer gagal (${response.status}).`
                );
            }

            const html =
                await response.text();

            if (
                currentSequence
                !== requestSequence
            ) {
                return;
            }

            replaceSearchResult(html);

            if (updateBrowserUrl) {
                window.history.replaceState(
                    {
                        masterSignerSearch: true,
                    },
                    '',
                    url.toString()
                );
            }

            updateResetButton();
        } catch (error) {
            if (error.name !== 'AbortError') {
                console.error(
                    'Master Signer search error:',
                    error
                );
            }
        } finally {
            if (
                currentSequence
                === requestSequence
            ) {
                setLoading(false);
                activeController = null;
            }
        }
    };

    const executeSearch = () => {
        loadSearchResult(
            buildSearchUrl(),
            true
        );
    };

    searchInput.addEventListener(
        'input',
        () => {
            updateResetButton();

            window.clearTimeout(
                debounceTimer
            );

            debounceTimer =
                window.setTimeout(
                    executeSearch,
                    400
                );
        }
    );

    searchForm.addEventListener(
        'submit',
        (event) => {
            event.preventDefault();

            window.clearTimeout(
                debounceTimer
            );

            executeSearch();
        }
    );

    resetButton?.addEventListener(
        'click',
        () => {
            searchInput.value = '';

            updateResetButton();

            window.clearTimeout(
                debounceTimer
            );

            executeSearch();
            searchInput.focus();
        }
    );

    document.addEventListener(
        'click',
        (event) => {
            const paginationLink =
                event.target.closest(
                    '#masterSignerTableResult nav a'
                );

            if (!paginationLink) {
                return;
            }

            event.preventDefault();

            const url = new URL(
                paginationLink.href,
                window.location.origin
            );

            loadSearchResult(
                url,
                true
            );
        }
    );

    document.addEventListener(
        'click',
        (event) => {
            const emptyResetButton =
                event.target.closest(
                    '[data-master-signer-empty-reset]'
                );

            if (!emptyResetButton) {
                return;
            }

            event.preventDefault();

            searchInput.value = '';
            updateResetButton();
            executeSearch();
            searchInput.focus();
        }
    );

    updateResetButton();
});


/*
 * =========================================================
 * DROPDOWN AKSI AVAILABILITY
 * Digunakan pada halaman index.blade.php
 * =========================================================
 */

document.addEventListener('DOMContentLoaded', () => {
    let activeMenu = null;
    let activeButton = null;

    const closeActionMenu = () => {
        if (activeMenu) {
            activeMenu.remove();
            activeMenu = null;
        }

        if (activeButton) {
            activeButton.setAttribute(
                'aria-expanded',
                'false'
            );

            const chevron =
                activeButton.querySelector(
                    '[data-availability-action-chevron]'
                );

            chevron?.classList.remove(
                'rotate-180'
            );

            activeButton = null;
        }
    };

    const positionActionMenu = (
        menu,
        button
    ) => {
        const buttonRect =
            button.getBoundingClientRect();

        const viewportPadding = 8;

        const gap = 6;

        /*
         * Lebar sesuai class w-48.
         */
        const menuWidth = 192;

        let left =
            buttonRect.right - menuWidth;

        left = Math.max(
            viewportPadding,
            Math.min(
                left,
                window.innerWidth
                    - menuWidth
                    - viewportPadding
            )
        );

        let top =
            buttonRect.bottom + gap;

        menu.style.left =
            `${left}px`;

        menu.style.top =
            `${top}px`;

        /*
         * Setelah menu tampil, periksa apakah
         * ruang di bawah tombol cukup.
         */
        window.requestAnimationFrame(() => {
            const menuRect =
                menu.getBoundingClientRect();

            if (
                menuRect.bottom
                > window.innerHeight
                    - viewportPadding
            ) {
                top =
                    buttonRect.top
                    - menuRect.height
                    - gap;

                top = Math.max(
                    viewportPadding,
                    top
                );

                menu.style.top =
                    `${top}px`;
            }
        });
    };

    document.addEventListener(
        'click',
        (event) => {
            const toggleButton =
                event.target.closest(
                    '[data-availability-action-toggle]'
                );

            /*
             * Membuka atau menutup dropdown.
             */
            if (toggleButton) {
                event.preventDefault();
                event.stopPropagation();

                const isCurrentButton =
                    activeButton === toggleButton;

                closeActionMenu();

                if (isCurrentButton) {
                    return;
                }

                const template =
                    toggleButton.parentElement
                        ?.querySelector(
                            '[data-availability-action-template]'
                        );

                const templateMenu =
                    template?.content
                        ?.querySelector(
                            '[data-availability-action-menu]'
                        );

                if (!templateMenu) {
                    return;
                }

                const menu =
                    templateMenu.cloneNode(true);

                menu.classList.remove(
                    'hidden'
                );

                document.body.appendChild(
                    menu
                );

                activeMenu = menu;

                activeButton =
                    toggleButton;

                activeButton.setAttribute(
                    'aria-expanded',
                    'true'
                );

                const chevron =
                    activeButton.querySelector(
                        '[data-availability-action-chevron]'
                    );

                chevron?.classList.add(
                    'rotate-180'
                );

                positionActionMenu(
                    menu,
                    activeButton
                );

                return;
            }

            /*
             * Klik di dalam menu tidak langsung
             * menutup menu sebelum link/form bekerja.
             */
            if (
                event.target.closest(
                    '[data-availability-action-menu]'
                )
            ) {
                return;
            }

            closeActionMenu();
        }
    );

    /*
     * Tutup dengan tombol Escape.
     */
    document.addEventListener(
        'keydown',
        (event) => {
            if (event.key === 'Escape') {
                closeActionMenu();
            }
        }
    );

    /*
     * Menu ditutup saat halaman digeser
     * atau ukuran jendela berubah.
     */
    window.addEventListener(
        'resize',
        closeActionMenu
    );

    window.addEventListener(
        'scroll',
        closeActionMenu,
        true
    );
});


/*
 * =========================================================
 * KLIK BARIS MENUJU DETAIL
 * Tetap berfungsi setelah live search
 * =========================================================
 */

document.addEventListener('click', (event) => {
    const row = event.target.closest(
        '[data-availability-row-url]'
    );

    if (!row) {
        return;
    }

    /*
     * Jangan membuka detail apabila pengguna
     * menekan tombol, link, atau form aksi.
     */
    const interactiveElement =
        event.target.closest(
            [
                'a',
                'button',
                'input',
                'select',
                'textarea',
                'form',
                'summary',
                '[role="button"]',
            ].join(',')
        );

    if (interactiveElement) {
        return;
    }

    const url =
        row.dataset.availabilityRowUrl;

    if (!url) {
        return;
    }

    window.location.href = url;
});


/*
 * Dukungan keyboard:
 * Enter atau Space membuka detail.
 */
document.addEventListener('keydown', (event) => {
    const row = event.target.closest(
        '[data-availability-row-url]'
    );

    if (!row || event.target !== row) {
        return;
    }

    if (
        event.key !== 'Enter'
        && event.key !== ' '
    ) {
        return;
    }

    event.preventDefault();

    const url =
        row.dataset.availabilityRowUrl;

    if (!url) {
        return;
    }

    window.location.href = url;
});


/*
 * =========================================================
 * RESET PENCARIAN DARI EMPTY STATE
 * Tetap berfungsi setelah hasil live search diganti
 * =========================================================
 */

document.addEventListener('click', (event) => {
    const emptyResetButton =
        event.target.closest(
            '[data-availability-empty-reset]'
        );

    if (!emptyResetButton) {
        return;
    }

    event.preventDefault();

    const resetButton =
        document.getElementById(
            'availabilityResetSearch'
        );

    const searchInput =
        document.getElementById(
            'availabilitySearchInput'
        );

    /*
     * Gunakan tombol reset utama karena tombol tersebut
     * sudah terhubung dengan fungsi live search.
     */
    if (resetButton) {
        resetButton.click();
        return;
    }

    /*
     * Fallback apabila tombol reset utama
     * tidak ditemukan.
     */
    if (searchInput) {
        searchInput.value = '';

        searchInput.dispatchEvent(
            new Event(
                'input',
                {
                    bubbles: true,
                }
            )
        );

        searchInput.focus();
    }
});





/*
 * =========================================================
 * MODAL KONFIRMASI KAI
 * Untuk Hapus Form & Konfirmasi Selesai
 * =========================================================
 */

document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById(
        'availabilityConfirmModal'
    );

    const titleElement = document.getElementById(
        'availabilityConfirmTitle'
    );

    const messageElement = document.getElementById(
        'availabilityConfirmMessage'
    );

    const figureElement = document.getElementById(
        'availabilityConfirmFigure'
    );


    const confirmButton = document.getElementById(
        'availabilityConfirmSubmit'
    );

    if (
        !modal
        || !titleElement
        || !messageElement
        || !figureElement
        || !confirmButton
    ) {
        return;
    }

    let pendingForm = null;
    let lastFocusedElement = null;

    const closeModal = () => {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('availability-modal-open');

        pendingForm = null;

        if (lastFocusedElement) {
            lastFocusedElement.focus();
            lastFocusedElement = null;
        }
    };

    const openModal = (form, submitter) => {
        pendingForm = form;
        lastFocusedElement = submitter || document.activeElement;

        const type =
            form.dataset.confirmType || 'default';

        const title =
            form.dataset.confirmTitle || 'Konfirmasi Aksi';

        const message =
            form.dataset.confirmMessage
            || 'Apakah Anda yakin ingin melanjutkan?';

        titleElement.textContent = title;
        messageElement.textContent = message;

        figureElement.classList.remove(
            'is-delete',
            'is-complete'
        );

        confirmButton.classList.remove(
            'is-delete',
            'is-complete'
        );

        if (type === 'delete') {
            figureElement.classList.add('is-delete');
            confirmButton.classList.add('is-delete');
            confirmButton.textContent = 'Ya, Hapus';
        } else if (type === 'complete') {
            figureElement.classList.add('is-complete');
            confirmButton.classList.add('is-complete');
            confirmButton.textContent = 'Ya, Selesaikan';
        } else {
            confirmButton.textContent = 'Lanjutkan';
        }

        confirmButton.disabled = false;

        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('availability-modal-open');

        window.setTimeout(() => {
            confirmButton.focus();
        }, 50);
    };

    document.addEventListener('submit', (event) => {
        const form = event.target.closest(
            '[data-availability-confirm]'
        );

        if (!form) {
            return;
        }

        event.preventDefault();
        openModal(form, event.submitter);
    });

    confirmButton.addEventListener('click', () => {
        if (!pendingForm) {
            closeModal();
            return;
        }

        const formToSubmit = pendingForm;

        confirmButton.disabled = true;
        confirmButton.textContent = 'Memproses...';

        formToSubmit.submit();
    });

    document.addEventListener('click', (event) => {
        const closeButton = event.target.closest(
            '[data-availability-confirm-close]'
        );

        if (!closeButton) {
            return;
        }

        closeModal();
    });

    document.addEventListener('keydown', (event) => {
        if (
            event.key === 'Escape'
            && modal.classList.contains('is-open')
        ) {
            closeModal();
        }
    });
});


/*
 * =========================================================
 * DATE PICKER
 * Membuka kalender saat kolom atau ikon diklik
 * =========================================================
 */

document.addEventListener('click', (event) => {
    const trigger = event.target.closest(
        '[data-availability-date-trigger]'
    );

    const clickedInput = event.target.closest(
        '[data-availability-date-input]'
    );

    let dateInput = null;

    if (trigger) {
        event.preventDefault();

        const wrapper = trigger.closest(
            '[data-availability-date-picker]'
        );

        dateInput = wrapper?.querySelector(
            '[data-availability-date-input]'
        );
    } else if (clickedInput) {
        dateInput = clickedInput;
    }

    if (
        !dateInput
        || dateInput.disabled
        || dateInput.readOnly
    ) {
        return;
    }

    dateInput.focus({
        preventScroll: true,
    });

    /*
     * Browser modern seperti Chrome dan Edge
     * dapat membuka kalender lewat showPicker().
     */
    if (typeof dateInput.showPicker === 'function') {
        try {
            dateInput.showPicker();
        } catch (error) {
            /*
             * Browser tertentu tetap akan membuka
             * kalender melalui klik normal input.
             */
        }

        return;
    }

    /*
     * Fallback untuk browser yang belum
     * mendukung showPicker().
     */
    if (trigger) {
        dateInput.click();
    }
});

/*
 * =========================================================
 * AUTO FILL BUSINESS AREA & DAOP/DIVRE
 * =========================================================
 */

document.addEventListener('DOMContentLoaded', () => {
    const baSelect = document.getElementById('business_area');
    const daopInput = document.getElementById('daop_divre');

    if (!baSelect || !daopInput) {
        return;
    }

    const updateDaopField = () => {
        const selectedOption = baSelect.options[baSelect.selectedIndex];
        if (selectedOption && selectedOption.dataset.daop) {
            daopInput.value = selectedOption.dataset.daop;
        }
    };

    baSelect.addEventListener('change', updateDaopField);

    /*
     * Jalankan saat awal dimuat (misal pada halaman edit atau setelah validation error)
     */
    if (baSelect.value) {
        updateDaopField();
    }
});

/*
 * =========================================================
 * PREVIEW PEJABAT DAN IDENTITAS TANDA TANGAN
 * =========================================================
 */

document.addEventListener('DOMContentLoaded', () => {
    const signerSelect = document.querySelector(
        '[data-signer-select]'
    );

    const signerPreview = document.querySelector(
        '[data-signer-preview]'
    );

    /*
     * Jangan lanjut kalau komponen form tanda tangan
     * tidak ditemukan pada halaman ini.
     */
    if (!signerSelect || !signerPreview) {
        return;
    }

    const nameElement = signerPreview.querySelector(
        '[data-signer-name]'
    );

    const positionElement = signerPreview.querySelector(
        '[data-signer-position]'
    );

    const nippElement = signerPreview.querySelector(
        '[data-signer-nipp]'
    );

    const getSelectedOption = () => {
        return signerSelect.options[
            signerSelect.selectedIndex
        ];
    };

    const updateSignerPreview = () => {
        const selectedOption = getSelectedOption();

        const hasSelection = Boolean(selectedOption && selectedOption.value);

        signerPreview.hidden = !hasSelection;

        if (!hasSelection) {
            return;
        }

        const masterName =
            selectedOption.dataset.name
            || selectedOption.textContent.trim();

        const masterPosition =
            selectedOption.dataset.position
            || 'Jabatan belum tersedia';

        const masterNipp =
            selectedOption.dataset.nipp?.trim()
            || '';

        if (nameElement) {
            nameElement.style.whiteSpace = '';
            nameElement.textContent = masterName;
        }

        if (positionElement) {
            positionElement.hidden = false;
            positionElement.textContent = masterPosition;
        }

        if (nippElement) {
            nippElement.hidden = masterNipp === '';
            nippElement.textContent = masterNipp
                ? `NIPP ${masterNipp}`
                : '';
        }
    };

    signerSelect.addEventListener(
        'change',
        updateSignerPreview
    );

    /*
     * Jalankan ketika halaman pertama dibuka
     */
    updateSignerPreview();
});

