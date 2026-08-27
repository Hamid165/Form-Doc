<style>
    /* Custom Datepicker Styles (Isolated from Tailwind to prevent compilation issues) */
    #custom-datepicker-modal * {
        box-sizing: border-box;
        font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
    }

    #datepicker-overlay {
        position: fixed;
        inset: 0;
        background-color: rgba(107, 114, 128, 0.75);
        z-index: 40;
    }

    .dp-modal-container {
        position: absolute;
        z-index: 50;
        display: block;
    }

    .dp-card {
        background-color: #ffffff;
        width: 100%;
        max-width: 340px;
        border-radius: 16px;
        padding: 15px 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        position: relative;
    }

    .dp-header {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 12px;
    }

    .dp-select-wrapper {
        position: relative;
        flex: 1;
    }

    .dp-select-wrapper select {
        width: 100%;
        appearance: none;
        background-color: #f6f8fa;
        border: 1px solid #e1e4e8;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #1a1a1a;
        cursor: pointer;
        outline: none;
        transition: all 0.2s;
    }

    .dp-select-wrapper select:focus {
        border-color: #00a4e4;
    }

    .dp-select-wrapper::after {
        content: "";
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        width: 0;
        height: 0;
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
        border-top: 5px solid #666;
        pointer-events: none;
    }

    .dp-weekdays {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        text-align: center;
        font-size: 11px;
        font-weight: 700;
        color: #6b7280;
        margin-bottom: 6px;
    }

    .dp-days-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        row-gap: 2px;
        text-align: center;
    }

    .dp-day {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 28px;
        width: 32px;
        margin: 0 auto;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        color: #1a1a1a;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .dp-day:hover:not(.dp-empty, .dp-selected, .dp-prev-month, .dp-disabled) {
        background-color: #f0f0f0;
    }

    .dp-day.dp-prev-month {
        color: #c4c4c4;
        cursor: default;
    }

    .dp-day.dp-disabled {
        color: #d1d5db;
        cursor: not-allowed;
        background-color: #f9fafb;
    }

    .dp-day.dp-selected {
        background-color: #00a4e4;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(0, 164, 228, 0.4);
        font-weight: 600;
    }

    .dp-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 12px;
    }

    .dp-btn {
        background: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        padding: 6px 16px;
        border-radius: 6px;
        transition: all 0.25s ease;
        outline: none;
    }

    .dp-btn-cancel {
        border: 2px solid #dcdcdc;
        color: #888888;
        background-color: transparent;
    }

    .dp-btn-cancel:hover {
        border-color: #e53935;
        background-color: #e53935;
        color: #ffffff;
    }

    .dp-btn-confirm {
        border: 2px solid #00a4e4;
        color: #00a4e4;
        background-color: transparent;
    }

    .dp-btn-confirm:hover {
        background-color: #00a4e4;
        color: #ffffff;
    }
    
    .dp-hidden {
        display: none !important;
    }
</style>

<div id="custom-datepicker-modal" class="dp-hidden">
    <div id="datepicker-overlay"></div>
    <div class="dp-modal-container">
        <div class="dp-card">
            
            <div class="dp-header">
                <div class="dp-select-wrapper">
                    <select id="dp-month-select"></select>
                </div>
                <div class="dp-select-wrapper">
                    <select id="dp-year-select"></select>
                </div>
            </div>

            <div class="dp-weekdays">
                <div>SUN</div>
                <div>MON</div>
                <div>TUE</div>
                <div>WED</div>
                <div>THU</div>
                <div>FRI</div>
                <div>SAT</div>
            </div>

            <div class="dp-days-grid" id="dp-days-grid">
                <!-- Days will be generated here by JS -->
            </div>

            <div class="dp-footer">
                <button type="button" id="dp-btn-cancel" class="dp-btn dp-btn-cancel">Batal</button>
                <button type="button" id="dp-btn-confirm" class="dp-btn dp-btn-confirm">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('custom-datepicker-modal');
        const overlay = document.getElementById('datepicker-overlay');
        const monthSelect = document.getElementById('dp-month-select');
        const yearSelect = document.getElementById('dp-year-select');
        const daysGrid = document.getElementById('dp-days-grid');
        const btnCancel = document.getElementById('dp-btn-cancel');
        const btnConfirm = document.getElementById('dp-btn-confirm');
        
        let currentTargetInput = null;
        let currentDate = new Date(); 
        let selectedDate = new Date();
        let currentMinDate = new Date();
        let currentDisabledDates = [];

        function parseDateString(str, format) {
            if (!str) return null;
            if (format === 'id' || format === 'id-dash') {
                if (format === 'id-dash') str = str.replace(/\s*-\s*/g, ' ');
                const parts = str.split(' ');
                if (parts.length === 3) {
                    const day = parseInt(parts[0], 10);
                    const monthNamesId = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                    const month = monthNamesId.indexOf(parts[1]);
                    const year = parseInt(parts[2], 10);
                    if (month !== -1) return new Date(year, month, day);
                }
            } else {
                const parts = str.split('-');
                if (parts.length === 3) {
                    return new Date(parts[2], parseInt(parts[1], 10) - 1, parts[0]);
                }
            }
            let d = new Date(str);
            return isNaN(d) ? null : d;
        }

        const months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        function initDropdowns() {
            monthSelect.innerHTML = '';
            yearSelect.innerHTML = '';

            months.forEach((month, index) => {
                let option = document.createElement('option');
                option.value = index;
                option.textContent = month;
                monthSelect.appendChild(option);
            });

            const currentYear = new Date().getFullYear();
            for (let i = currentYear - 5; i <= currentYear + 5; i++) {
                let option = document.createElement('option');
                option.value = i;
                option.textContent = i;
                yearSelect.appendChild(option);
            }

            monthSelect.addEventListener('change', () => {
                currentDate.setMonth(parseInt(monthSelect.value));
                renderCalendar();
            });

            yearSelect.addEventListener('change', () => {
                currentDate.setFullYear(parseInt(yearSelect.value));
                renderCalendar();
            });
        }

        function renderCalendar() {
            daysGrid.innerHTML = '';
            
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            
            monthSelect.value = month;
            yearSelect.value = year;

            const firstDayOfMonth = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const daysInPrevMonth = new Date(year, month, 0).getDate();

            // Previous month days
            for (let i = firstDayOfMonth; i > 0; i--) {
                const dayEl = document.createElement('div');
                dayEl.className = 'dp-day dp-prev-month';
                dayEl.textContent = daysInPrevMonth - i + 1;
                daysGrid.appendChild(dayEl);
            }

            // Current month days
            for (let i = 1; i <= daysInMonth; i++) {
                const dayEl = document.createElement('div');
                const cellDate = new Date(year, month, i);
                
                let isSelected = i === selectedDate.getDate() && month === selectedDate.getMonth() && year === selectedDate.getFullYear();
                let cellTime = cellDate.getTime();
                let isDisabled = cellDate < currentMinDate || currentDisabledDates.includes(cellTime);
                
                if (isDisabled) {
                    dayEl.className = 'dp-day dp-disabled';
                } else {
                    dayEl.className = isSelected ? 'dp-day dp-selected' : 'dp-day';

                    dayEl.addEventListener('click', () => {
                        selectedDate = new Date(year, month, i);
                        currentDate = new Date(year, month, i);
                        renderCalendar();
                    });
                    
                    dayEl.addEventListener('dblclick', () => {
                        selectedDate = new Date(year, month, i);
                        currentDate = new Date(year, month, i);
                        confirmSelection();
                    });
                }

                dayEl.textContent = i < 10 ? `0${i}` : i;
                daysGrid.appendChild(dayEl);
            }
        }

        function openModal(input) {
            currentTargetInput = input;
            
            const container = document.querySelector('.dp-modal-container');
            const rect = input.getBoundingClientRect();
            
            // Prevent going out of bottom bound (open above the input instead)
            const datepickerHeight = 310; // exact height of dp-card is around 300px
            let topPos = rect.bottom + window.scrollY + 5;
            if (rect.bottom + datepickerHeight > window.innerHeight) {
                topPos = rect.top + window.scrollY - datepickerHeight - 5;
            }
            container.style.top = topPos + 'px';
            
            // Prevent going out of right bound
            let leftPos = rect.left + window.scrollX;
            if (leftPos + 380 > window.innerWidth) {
                leftPos = window.innerWidth - 400; // rough width of datepicker
            }
            container.style.left = leftPos + 'px';
            
            // Determine minimum date
            currentMinDate = new Date();
            currentMinDate.setHours(0, 0, 0, 0);

            // If it's a table row, check previous rows for a minimum date
            if (input.name && input.name.match(/items\[(\d+)\]\[tanggal\]/)) {
                let match = input.name.match(/items\[(\d+)\]\[tanggal\]/);
                let rowNo = parseInt(match[1]);
                
                for (let r = rowNo - 1; r >= 1; r--) {
                    let prevInput = document.querySelector(`input[name="items[${r}][tanggal]"]`);
                    if (prevInput && prevInput.value) {
                        let parsedPrevDate = parseDateString(prevInput.value, prevInput.getAttribute('data-format'));
                        if (parsedPrevDate) {
                            parsedPrevDate.setHours(0, 0, 0, 0);
                            if (parsedPrevDate > currentMinDate) {
                                currentMinDate = parsedPrevDate;
                            }
                        }
                        break;
                    }
                }
            }

            // Gather all currently selected dates in the CCTV form table to disable them
            currentDisabledDates = [];
            if (input.name && input.name.match(/items\[(\d+)\]\[tanggal\]/)) {
                let allInputs = document.querySelectorAll('input[name*="[tanggal]"]');
                allInputs.forEach(inp => {
                    if (inp !== input && inp.value) {
                        let parsedD = parseDateString(inp.value, inp.getAttribute('data-format'));
                        if (parsedD) {
                            parsedD.setHours(0, 0, 0, 0);
                            currentDisabledDates.push(parsedD.getTime());
                        }
                    }
                });
            }

            // Parse existing date if available
            if (input.value) {
                let parsed = parseDateString(input.value, input.getAttribute('data-format'));
                if (parsed) {
                    selectedDate = parsed;
                    currentDate = new Date(parsed);
                }
            } else {
                selectedDate = new Date();
                currentDate = new Date();
            }
            
            initDropdowns();
            renderCalendar();
            modal.classList.remove('dp-hidden');
        }

        function closeModal() {
            modal.classList.add('dp-hidden');
            currentTargetInput = null;
        }

        function confirmSelection() {
            if (currentTargetInput) {
                const year = selectedDate.getFullYear();
                const month = String(selectedDate.getMonth() + 1).padStart(2, '0');
                const day = String(selectedDate.getDate()).padStart(2, '0');
                
                if (currentTargetInput.getAttribute('data-format') === 'id' || currentTargetInput.getAttribute('data-format') === 'id-dash') {
                    const monthNamesId = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                    if (currentTargetInput.getAttribute('data-format') === 'id-dash') {
                        currentTargetInput.value = `${day} - ${monthNamesId[selectedDate.getMonth()]} - ${year}`;
                    } else {
                        currentTargetInput.value = `${day} ${monthNamesId[selectedDate.getMonth()]} ${year}`;
                    }
                } else {
                    currentTargetInput.value = `${day}-${month}-${year}`;
                }
                
                // Trigger events to clear HTML5 validation custom validity
                currentTargetInput.dispatchEvent(new Event('input', { bubbles: true }));
                currentTargetInput.dispatchEvent(new Event('change', { bubbles: true }));
            }
            closeModal();
        }

        btnCancel.addEventListener('click', closeModal);
        overlay.addEventListener('click', closeModal);
        btnConfirm.addEventListener('click', confirmSelection);

        // Bind all inputs with class 'custom-date-picker' using event delegation
        document.body.addEventListener('click', function(e) {
            if (e.target && e.target.classList && e.target.classList.contains('custom-date-picker')) {
                e.preventDefault();
                openModal(e.target);
            }
        });
        document.body.addEventListener('keydown', function(e) {
            if (e.target && e.target.classList && e.target.classList.contains('custom-date-picker')) {
                e.preventDefault();
            }
        });
    });
</script>
