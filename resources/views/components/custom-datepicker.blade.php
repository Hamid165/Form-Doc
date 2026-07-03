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

    .dp-day:hover:not(.dp-empty, .dp-selected, .dp-prev-month) {
        background-color: #f0f0f0;
    }

    .dp-day.dp-prev-month {
        color: #c4c4c4;
        cursor: default;
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
                
                let isSelected = i === selectedDate.getDate() && month === selectedDate.getMonth() && year === selectedDate.getFullYear();
                
                dayEl.className = isSelected ? 'dp-day dp-selected' : 'dp-day';
                dayEl.textContent = i < 10 ? `0${i}` : i;

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
            
            // Parse existing date if available
            if (input.value) {
                let parsed = new Date(input.value);
                if (!isNaN(parsed)) {
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
                
                if (currentTargetInput.getAttribute('data-format') === 'id') {
                    const monthNamesId = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                    currentTargetInput.value = `${selectedDate.getDate()} ${monthNamesId[selectedDate.getMonth()]} ${year}`;
                } else {
                    currentTargetInput.value = `${year}-${month}-${day}`;
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
