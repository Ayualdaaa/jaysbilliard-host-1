@extends('layouts.dashboard')

@section('title', "Pilih Meja — Jay's Billiard")

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/css_page/user_meja.css') }}">
@endpush

@section('content')
    <div class="meja-wrapper">
        {{-- LEFT: SELECTION AREA --}}
        <div class="meja-selection-area">

            {{-- Status Filter & Header --}}
            <div class="meja-header-flex">
                <h2 style="font-size: 1.5rem; font-weight: 800; color: #fff;">Meja Tersedia</h2>
                <div class="meja-legend">
                    <div class="legend-item"><span class="legend-dot dot-occupied"></span> Terisi</div>
                    <div class="legend-item"><span class="legend-dot dot-booked"></span> Dipesan</div>
                    <div class="legend-item"><span class="legend-dot dot-maintenance"></span> Maintenance</div>
                    <div class="legend-item"><span class="legend-dot dot-available"></span> Tersedia</div>
                </div>
            </div>

            {{-- Map Visualization --}}
            <div class="relative bg-gradient-to-br from-[rgba(20,20,30,0.4)] to-[rgba(0,0,0,0.6)] rounded-[32px] min-h-[420px] border border-white/[0.08] flex justify-center items-center overflow-hidden z-10 shadow-[inset_0_0_30px_rgba(0,0,0,0.5)] aspect-[2/1] md:min-h-[350px] sm:min-h-[280px] sm:rounded-[20px]">
                <div class="meja-grid w-[90%] h-[90%] relative md:w-[90%] md:h-[90%] sm:w-[85%] sm:h-[85%]">
                    @foreach($tables as $index => $table)
                        @php
                            $todayStr = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
                            $nowTime = \Carbon\Carbon::now('Asia/Jakarta');
                            $nowFloat = $nowTime->hour + ($nowTime->minute / 60);

                            $activeBooking = $table->bookings->filter(function($b) use ($todayStr, $nowFloat) {
                                if ($b->booking_date !== $todayStr) return false;
                                $startParts = explode(':', $b->start_time);
                                $startFloat = intval($startParts[0]) + (intval($startParts[1]) / 60);
                                $endParts = explode(':', $b->end_time);
                                $endFloat = intval($endParts[0]) + (intval($endParts[1]) / 60);
                                if ($endFloat <= $startFloat) { $endFloat += 24; }
                                return $nowFloat >= $startFloat && $nowFloat < $endFloat;
                            })->first();

                            $statusClass = 'available';
                            $statusText = 'TERSEDIA';

                            if ($table->status === 'maintenance') {
                                $statusClass = 'maintenance';
                                $statusText = 'MAINTENANCE';
                            } elseif ($activeBooking) {
                                $statusLower = strtolower($activeBooking->status);
                                if ($statusLower === 'confirmed') {
                                    $statusClass = 'occupied';
                                    $statusText = 'TERISI';
                                } elseif (in_array($statusLower, ['pending', 'booked', 'dipesan', 'paid', 'lunas'])) {
                                    $statusClass = 'booked';
                                    $statusText = 'DIPESAN';
                                }
                            }
                        @endphp
                        <div class="billiard-table status-{{ $statusClass }} {{ $index % 4 === 0 || $index % 4 === 3 ? 'vertical' : '' }}"
                            id="meja-{{ str_pad($table->id, 2, '0', STR_PAD_LEFT) }}" data-id="{{ $table->id }}"
                            data-name="{{ $table->name }}" data-type="{{ $table->type }}"
                            data-price="{{ $table->price_per_hour }}" data-capacity="{{ $table->capacity }}"
                            data-image="{{ $table->image }}" data-status="{{ $statusClass }}">
                            <div class="{{ $index % 4 === 0 || $index % 4 === 3 ? 'table-side-label' : 'table-number' }} color-{{ $statusClass }}"
                                @if($index % 4 === 3) style="left: auto; right: -25px;" @endif>
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            <div class="table-pockets">
                                <span class="p-tl"></span><span class="p-tr"></span>
                                <span class="p-bl"></span><span class="p-br"></span>
                                @if($index % 4 === 0 || $index % 4 === 3)
                                    <span class="p-ml"></span><span class="p-mr"></span>
                                @else
                                    <span class="p-tc"></span><span class="p-bc"></span>
                                @endif
                            </div>

                            {{-- PREMIUM HOVER CARD (Tooltip) --}}
                            <div class="table-tooltip premium-card">
                                <div class="tm-image-container">
                                    <img src="{{ $table->image ? asset('storage/' . $table->image) : asset('images/hero-bg.png') }}"
                                        alt="Table">
                                    <div class="tm-price-badge" style="display: none;">Rp {{ number_format($table->price_per_hour, 0, ',', '.') }} /
                                        JAM</div>
                                </div>
                                <div class="tm-body">
                                    <div class="tm-header">
                                        <h2 class="tm-name">{{ strtoupper($table->name) }}</h2>
                                        <div class="tm-status">
                                            <span class="tm-status-dot dot-{{ $statusClass }}"></span>
                                            <span class="tm-status-text text-{{ $statusClass }}">{{ $statusText }}</span>
                                        </div>
                                    </div>
                                    <div class="tm-meta">
                                        <span
                                            class="tm-type">{{ stripos($table->name, 'VIP') !== false ? 'VIP AREA' : 'STANDAR' }}</span>
                                        <span class="tm-capacity">{{ $table->capacity }} Orang</span>
                                    </div>
                                    <p class="tm-description">
                                        adalah meja billiard tipe
                                        {{ stripos($table->name, 'VIP') !== false ? 'VIP' : 'standar' }} untuk permainan
                                        {{ stripos($table->name, 'VIP') !== false ? 'eksklusif' : 'biasa' }}, dirancang untuk
                                        kenyamanan maksimal.
                                    </p>
                                    <div class="tm-footer">
                                        @if($statusClass === 'maintenance')
                                            <button class="tm-btn-add" disabled
                                                style="opacity: 0.5; cursor: not-allowed; background: #333;">MAINTENANCE</button>
                                        @else
                                            <button class="tm-btn-add">TAMBAH</button>
                                        @endif
                                        <button class="tm-btn-chat" style="position: relative;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path
                                                    d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-11.7 8.38 8.38 0 0 1 3.8.9L21 3z">
                                                </path>
                                            </svg>
                                            <span class="notif-badge"
                                                style="display: none; position: absolute; top: -5px; right: -5px; background: #ff3b3b; color: #fff; font-size: 0.6rem; font-weight: bold; width: 14px; height: 14px; border-radius: 50%; align-items: center; justify-content: center; pointer-events: none;">!</span>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Booking Controls Card --}}
            <div class="booking-section mt-6">
                {{-- Date Selector --}}
                <div class="section-header"
                    style="justify-content: space-between; align-items: center; display: flex; margin-bottom: 20px;">
                    <div class="section-title"
                        style="display: flex; align-items: center; gap: 10px; font-weight: 800; color: #fff; font-size: 1.1rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                            stroke="#00e5ff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        Select Date
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; position: relative;">
                        <button class="month-nav prev-month"
                            style="background:none;border:none;color:#fff;cursor:pointer;padding:0;display:flex;align-items:center;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                        </button>
                        <div id="current-month-year"
                            style="font-size: 0.95rem; font-weight: 800; color: #fff; min-width: 120px; text-align: center; cursor: pointer; padding: 6px 12px; border-radius: 8px; transition: background 0.2s;"
                            onmouseover="this.style.background='rgba(0, 229, 255, 0.1)'"
                            onmouseout="this.style.background='transparent'" title="Pilih Bulan">
                        </div>
                        <button class="month-nav next-month"
                            style="background:none;border:none;color:#fff;cursor:pointer;padding:0;display:flex;align-items:center;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>

                        {{-- Month Picker Popup --}}
                        <div id="month-picker-popup"
                            style="display: none; position: absolute; top: 120%; left: 50%; transform: translateX(-50%); background: #16191d; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 15px; z-index: 100; width: 260px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 10px;">
                                <button type="button" id="mp-prev-year"
                                    style="background: none; border: none; color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 6px; transition: background 0.2s;"
                                    onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                                    onmouseout="this.style.background='none'">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="15 18 9 12 15 6"></polyline>
                                    </svg>
                                </button>
                                <span id="mp-year-display"
                                    style="font-weight: 800; color: #00e5ff; font-size: 1.1rem;">2026</span>
                                <button type="button" id="mp-next-year"
                                    style="background: none; border: none; color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 6px; transition: background 0.2s;"
                                    onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                                    onmouseout="this.style.background='none'">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </button>
                            </div>
                            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;"
                                id="mp-months-grid">
                                {{-- JS will populate months --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="date-strip">
                    <div class="nav-arrow prev-date">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </div>
                    <div class="date-cards-container" id="date-cards-container">
                        {{-- Populated by JS --}}
                    </div>
                    <div class="nav-arrow next-date">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </div>

                {{-- Time Selector --}}
                <div class="section-header" style="margin-top: 30px;">
                    <div class="section-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        Start Time
                    </div>
                </div>

                <style>
                    .time-slot.disabled {
                        opacity: 0.3;
                        cursor: not-allowed;
                        background: #1a1a1e !important;
                        border-color: rgba(255,255,255,0.05) !important;
                        color: #666 !important;
                        pointer-events: none;
                    }
                </style>

                <div class="time-grid" id="time-grid">
                    <div class="time-slot" data-hour="14">14:00</div>
                    <div class="time-slot" data-hour="15">15:00</div>
                    <div class="time-slot" data-hour="16">16:00</div>
                    <div class="time-slot" data-hour="17">17:00</div>
                    <div class="time-slot" data-hour="18">18:00</div>
                    <div class="time-slot" data-hour="19">19:00</div>
                    <div class="time-slot" data-hour="20">20:00</div>
                    <div class="time-slot" data-hour="21">21:00</div>
                    <div class="time-slot" data-hour="22">22:00</div>
                    <div class="time-slot" data-hour="23">23:00</div>
                    <div class="time-slot" data-hour="24">00:00</div>
                    <div class="time-slot" data-hour="25">01:00</div>
                </div>

                {{-- Duration --}}
                <div class="duration-container">
                    <div class="duration-header">
                        <div class="section-title"
                            style="display: flex; align-items: center; gap: 8px; font-weight: 800; color: #fff; font-size: 1.1rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                                stroke="#00e5ff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="14" r="8"></circle>
                                <polyline points="12 10 12 14"></polyline>
                                <line x1="10" y1="2" x2="14" y2="2"></line>
                                <line x1="12" y1="2" x2="12" y2="6"></line>
                            </svg>
                            Duration
                        </div>
                        <div class="duration-value">-</div>
                    </div>
                    <input type="range" min="1" max="5" value="1" class="range-slider">
                    <div class="slider-labels">
                        <span>1 jam</span>
                        <span>2 jam</span>
                        <span>3 jam</span>
                        <span>4 jam</span>
                        <span>5 jam</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: ORDER SUMMARY --}}
        <div class="order-summary-area">
            <div class="summary-card">
                <h3 class="summary-title" style="display: flex; align-items: center; justify-content: space-between;">
                    Pesanan Saat Ini
                </h3>

                <div id="selected-tables-list"
                    style="margin-bottom: 25px; display: flex; flex-direction: column; gap: 12px;">
                    {{-- Populated by JS --}}
                    <div class="empty-state"
                        style="text-align: center; padding: 20px; color: #8a8a98; font-size: 0.9rem; border: 1px dashed rgba(255,255,255,0.1); border-radius: 12px;">
                        Belum ada meja dipilih
                    </div>
                </div>

                <div class="summary-details">
                    <div class="detail-row">
                        <span class="detail-label">Date</span>
                        <span class="detail-value" id="summary-date">April 5, 2026</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Time</span>
                        <span class="detail-value" id="summary-time">19:00 - 21:00</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Duration</span>
                        <span class="detail-value" id="summary-duration">2 Hours</span>
                    </div>
                </div>

                <div class="payment-breakdown"
                    style="border-top: 1px dashed rgba(255,255,255,0.1); padding-top: 30px; margin-top: auto;">
                    <div class="breakdown-row" style="margin-bottom: 15px;">
                        <span style="color: #8a8a98;">Subtotal</span>
                        <span id="summary-subtotal" style="color: #fff; font-weight: 700;">Rp200.000</span>
                    </div>
                    <div class="breakdown-row" style="margin-bottom: 25px;">
                        <span style="color: #8a8a98;">Pajak (10%)</span>
                        <span id="summary-tax" style="color: #fff; font-weight: 700;">Rp20.000</span>
                    </div>
                    <div class="breakdown-total"
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                        <span class="total-label" style="font-size: 1.2rem; font-weight: 800; color: #fff;">Total</span>
                        <span class="total-value" id="summary-total"
                            style="font-size: 1.6rem; font-weight: 900; color: var(--primary-cyan);">Rp220.000</span>
                    </div>
                </div>

                <a href="#" class="confirm-btn" id="confirm-booking-btn"
                    style="display: block; text-align: center; text-decoration: none;">Konfirmasi Pemesanan</a>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tables = document.querySelectorAll('.billiard-table');
            const dateCardsContainer = document.getElementById('date-cards-container');
            const timeSlots = document.querySelectorAll('.time-slot');
            const rangeSlider = document.querySelector('.range-slider');
            const durationValue = document.querySelector('.duration-value');


            // Date Selector elements
            const monthYearDisplay = document.getElementById('current-month-year');
            const prevDateBtn = document.querySelector('.prev-date');
            const nextDateBtn = document.querySelector('.next-date');
            const prevMonthBtn = document.querySelector('.prev-month');
            const nextMonthBtn = document.querySelector('.next-month');
            const summaryDate = document.getElementById('summary-date');

            // Month Picker Elements
            const monthPickerPopup = document.getElementById('month-picker-popup');
            const mpYearDisplay = document.getElementById('mp-year-display');
            const mpPrevYear = document.getElementById('mp-prev-year');
            const mpNextYear = document.getElementById('mp-next-year');
            const mpMonthsGrid = document.getElementById('mp-months-grid');

            let startDate = new Date(); // Start view from today
            startDate.setHours(0, 0, 0, 0); 
            let selectedDate = null; // No date selected by default
            let durationSelected = false; // Flag for duration selection
            let pickerYear = startDate.getFullYear();

            // Tables and Bookings data from PHP for dynamic map updates
            const allTables = @json($tables);

            function timeToFloat(timeStr) {
                if (!timeStr) return 0;
                const parts = timeStr.split(':');
                const hours = parseInt(parts[0]) || 0;
                const minutes = parseInt(parts[1]) || 0;
                return hours + (minutes / 60);
            }

            const monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];

            function renderMonthPicker() {
                mpYearDisplay.innerText = pickerYear;
                mpMonthsGrid.innerHTML = '';

                monthNames.forEach((month, index) => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    const isActive = (pickerYear === startDate.getFullYear() && index === startDate.getMonth());

                    btn.style.cssText = `background: ${isActive ? 'var(--primary-cyan)' : 'rgba(255,255,255,0.05)'}; color: ${isActive ? '#000' : '#fff'}; border: none; padding: 10px 5px; border-radius: 8px; font-weight: 700; cursor: pointer; transition: all 0.2s; font-size: 0.85rem;`;
                    btn.innerText = month;

                    btn.onmouseover = () => { if (!isActive) btn.style.background = 'rgba(255,255,255,0.1)' };
                    btn.onmouseout = () => { if (!isActive) btn.style.background = 'rgba(255,255,255,0.05)' };

                    btn.addEventListener('click', () => {
                        startDate.setFullYear(pickerYear);
                        startDate.setMonth(index);
                        renderDates();
                        monthPickerPopup.style.display = 'none';
                    });

                    mpMonthsGrid.appendChild(btn);
                });
            }

            monthYearDisplay.addEventListener('click', () => {
                pickerYear = startDate.getFullYear();
                renderMonthPicker();
                monthPickerPopup.style.display = monthPickerPopup.style.display === 'none' ? 'block' : 'none';
            });

            mpPrevYear.addEventListener('click', () => {
                pickerYear--;
                renderMonthPicker();
            });

            mpNextYear.addEventListener('click', () => {
                pickerYear++;
                renderMonthPicker();
            });

            document.addEventListener('click', (e) => {
                if (!monthYearDisplay.contains(e.target) && !monthPickerPopup.contains(e.target)) {
                    monthPickerPopup.style.display = 'none';
                }
            });

            function renderDates() {
                dateCardsContainer.innerHTML = '';

                // Update header
                const options = { month: 'long', year: 'numeric' };
                monthYearDisplay.innerText = startDate.toLocaleDateString('id-ID', options);

                for (let i = 0; i < 7; i++) {
                    const date = new Date(startDate);
                    date.setDate(startDate.getDate() + i);

                    const isSelected = selectedDate && date.toDateString() === selectedDate.toDateString();
                    const dayName = date.toLocaleDateString('id-ID', { weekday: 'short' }).toUpperCase();
                    const dayNum = date.getDate();
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    const fullDate = `${year}-${month}-${day}`;

                    const card = document.createElement('div');
                    card.className = `date-card ${isSelected ? 'active' : ''}`;
                    card.dataset.date = fullDate;
                    card.innerHTML = `
                                                                                                                    <span class="day-name">${dayName}</span>
                                                                                                                    <span class="day-num">${dayNum}</span>
                                                                                                                `;

                    card.addEventListener('click', () => {
                        selectedDate = new Date(date);
                        selectedDate.setHours(0, 0, 0, 0);
                        renderDates();
                        updateSummaryDate();
                        updateTimeSlots(); 
                        updateMapStatus(); // Refresh map colors for selected date
                    });

                    dateCardsContainer.appendChild(card);
                }
            }

            function updateTimeSlots() {
                const now = new Date();
                const checkDate = selectedDate ? new Date(selectedDate) : new Date();
                const year = checkDate.getFullYear();
                const month = String(checkDate.getMonth() + 1).padStart(2, '0');
                const day = String(checkDate.getDate()).padStart(2, '0');
                const selectedDateStr = `${year}-${month}-${day}`;
                
                timeSlots.forEach(slot => {
                    const dataHour = parseInt(slot.dataset.hour);
                    const slotDateTime = new Date(checkDate);
                    
                    if (dataHour >= 24) {
                        slotDateTime.setDate(slotDateTime.getDate() + 1);
                        slotDateTime.setHours(dataHour - 24, 0, 0, 0);
                    } else {
                        slotDateTime.setHours(dataHour, 0, 0, 0);
                    }

                    // Base disabling (past time)
                    let isDisabled = selectedDate ? (slotDateTime < now) : false;

                    // Additional disabling (already booked for any of the selected tables)
                    if (selectedDate && !isDisabled && selectedTables.length > 0) {
                        const slotStart = dataHour;
                        const slotEnd = dataHour + 1;
                        
                        const isBooked = selectedTables.some(selected => {
                            const tableData = allTables.find(t => t.id == selected.id);
                            if (!tableData || !tableData.bookings) return false;
                            
                            return tableData.bookings.some(b => {
                                if (b.booking_date !== selectedDateStr) return false;
                                
                                let bStart = timeToFloat(b.start_time);
                                let bEnd = timeToFloat(b.end_time);
                                if (bEnd <= bStart) bEnd += 24;
                                
                                return slotStart < bEnd && slotEnd > bStart;
                            });
                        });
                        
                        if (isBooked) isDisabled = true;
                    }

                    if (isDisabled) {
                        slot.classList.add('disabled');
                        slot.classList.remove('active');
                    } else {
                        slot.classList.remove('disabled');
                    }
                });
                updateTimeSummary();
                updateMapStatus(); // Automatically refresh map to match new slot states
            }

            function updateSummaryDate() {
                if (selectedTables.length === 0 || !selectedDate) {
                    summaryDate.innerText = '-';
                    return;
                }
                const options = { month: 'long', day: 'numeric', year: 'numeric' };
                summaryDate.innerText = selectedDate.toLocaleDateString('id-ID', options);
            }

            function updateMapStatus() {
                const checkDate = selectedDate ? new Date(selectedDate) : new Date();
                const year = checkDate.getFullYear();
                const month = String(checkDate.getMonth() + 1).padStart(2, '0');
                const day = String(checkDate.getDate()).padStart(2, '0');
                const selectedDateStr = `${year}-${month}-${day}`;

                // Get selected time slot and duration
                const activeTimeSlot = document.querySelector('.time-slot.active');
                let selectedStartHour = null;
                let selectedEndHour = null;
                if (activeTimeSlot) {
                    selectedStartHour = parseInt(activeTimeSlot.dataset.hour);
                    const duration = durationSelected ? parseInt(rangeSlider.value) : 1;
                    selectedEndHour = selectedStartHour + duration;
                }

                allTables.forEach(table => {
                    const tableIdStr = table.id.toString().padStart(2, '0');
                    const tableEl = document.getElementById(`meja-${tableIdStr}`);
                    if (!tableEl) return;

                    let statusClass = 'available';
                    let statusText = 'TERSEDIA';

                    if (table.status === 'maintenance') {
                        statusClass = 'maintenance';
                        statusText = 'MAINTENANCE';
                    } else {
                        // Find overlapping bookings for this table on selected date and selected timeslot
                        const overlappingBooking = table.bookings.find(b => {
                            if (b.booking_date !== selectedDateStr) return false;
                            
                            // If no timeslot is selected yet, we default to checking if currently occupied right now (if date is today)
                            if (selectedStartHour === null) {
                                const localDate = new Date();
                                const y = localDate.getFullYear();
                                const m = String(localDate.getMonth() + 1).padStart(2, '0');
                                const d = String(localDate.getDate()).padStart(2, '0');
                                const todayStr = `${y}-${m}-${d}`;
                                
                                if (selectedDateStr === todayStr) {
                                    const nowHour = localDate.getHours() + (localDate.getMinutes() / 60);
                                    const bStart = timeToFloat(b.start_time);
                                    const bEnd = timeToFloat(b.end_time);
                                    return nowHour >= bStart && nowHour < bEnd;
                                }
                                return false;
                            }

                            // If a slot is selected, check for interval overlap
                            let bStart = timeToFloat(b.start_time);
                            let bEnd = timeToFloat(b.end_time);
                            if (bEnd <= bStart) bEnd += 24;
                            return selectedStartHour < bEnd && selectedEndHour > bStart;
                        });

                        if (overlappingBooking) {
                            const statusLower = overlappingBooking.status.toLowerCase();
                            if (statusLower === 'confirmed') {
                                statusClass = 'occupied';
                                statusText = 'TERISI';
                            } else if (['pending', 'booked', 'dipesan', 'paid', 'lunas'].includes(statusLower)) {
                                statusClass = 'booked';
                                statusText = 'DIPESAN';
                            }
                        }
                    }

                    // Update visual classes on map
                    tableEl.className = tableEl.className.replace(/status-\w+/g, `status-${statusClass}`);
                    tableEl.dataset.status = statusClass;

                    // Update label color
                    const label = tableEl.querySelector('.table-side-label, .table-number');
                    if (label) {
                        label.className = label.className.replace(/color-\w+/g, `color-${statusClass}`);
                    }

                    // Update tooltip elements
                    const dot = tableEl.querySelector('.tm-status-dot');
                    const txt = tableEl.querySelector('.tm-status-text');
                    const btn = tableEl.querySelector('.tm-btn-add');

                    if (dot) dot.className = `tm-status-dot dot-${statusClass}`;
                    if (txt) {
                        txt.className = `tm-status-text text-${statusClass}`;
                        txt.innerText = statusText;
                    }
                    if (btn) {
                        if (statusClass === 'maintenance') {
                            btn.disabled = true;
                            btn.style.opacity = '0.5';
                            btn.style.cursor = 'not-allowed';
                            btn.style.background = '#333';
                            btn.innerText = 'MAINTENANCE';
                        } else {
                            btn.disabled = false;
                            btn.style.opacity = '1';
                            btn.style.cursor = 'pointer';
                            btn.style.background = 'linear-gradient(to right, var(--primary-cyan), #00c2ff)';
                            btn.innerText = 'TAMBAH';
                        }
                    }
                });
            }

            let selectedTables = []; // Array to store multiple selected table objects

            function updateSelectedTablesList() {
                // Update prices first based on current time
                updateCalculations();

                const listContainer = document.getElementById('selected-tables-list');
                const badge = document.getElementById('tables-count-badge');
                listContainer.innerHTML = '';
                if (badge) {
                    badge.innerText = selectedTables.length;
                }

                if (selectedTables.length === 0) {
                    listContainer.innerHTML = `
                                                    <div class="empty-state" style="text-align: center; padding: 20px; color: #8a8a98; font-size: 0.9rem; border: 1px dashed rgba(255,255,255,0.1); border-radius: 12px;">
                                                        Belum ada meja dipilih
                                                    </div>
                                                `;
                    updateCalculations();
                    updateSummaryDate();
                    updateTimeSummary();
                    return;
                }

                selectedTables.forEach(table => {
                    const priceFormatted = parseInt(table.price).toLocaleString('id-ID');
                    const itemHtml = `
                                                    <div class="summary-item-card update-flash" data-id="${table.id}" style="display: flex; justify-content: space-between; align-items: center; background: rgba(0, 242, 255, 0.05); padding: 12px; border-radius: 12px; border: 1px solid rgba(0, 242, 255, 0.1); animation: slideIn 0.3s ease-out;">
                                                        <div style="display: flex; gap: 12px; align-items: center;">
                                                            <img src="${table.image}" style="width: 45px; height: 45px; border-radius: 8px; object-fit: cover;">
                                                            <div class="item-info">
                                                                <div style="font-size: 0.9rem; font-weight: 800; color: #fff;">${table.name}</div>
                                                                <div style="font-size: 0.7rem; color: #8a8a98;">${table.type === 'vip' ? 'VIP' : 'Standar'} • ${table.capacity} Orang</div>
                                                            </div>
                                                        </div>
                                                        <div style="text-align: right;">
                                                            <div style="font-size: 0.9rem; font-weight: 800; color: #fff;">Rp ${priceFormatted}</div>
                                                            <button class="remove-table" style="background: none; border: none; color: #ff3b3b; font-size: 0.65rem; font-weight: 700; padding: 0; cursor: pointer;">Hapus</button>
                                                        </div>
                                                    </div>
                                                `;
                    listContainer.insertAdjacentHTML('beforeend', itemHtml);
                });

                // Pulse badge
                if (badge) {
                    badge.classList.remove('pulse-animation');
                    void badge.offsetWidth;
                    badge.classList.add('pulse-animation');
                }

                // Handle remove buttons
                document.querySelectorAll('.remove-table').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const card = btn.closest('.summary-item-card');
                        const id = card.dataset.id;
                        selectedTables = selectedTables.filter(t => t.id !== id);

                        // Update visual state on map
                        const mapTable = document.getElementById(`meja-${id.toString().padStart(2, '0')}`);
                        if (mapTable) mapTable.classList.remove('selected');

                        updateSelectedTablesList();
                        updateTimeSlots();
                        updateMapStatus();
                    });
                });

                updateSummaryDate();
                updateTimeSummary();
            }

            prevDateBtn.addEventListener('click', () => {
                startDate.setDate(startDate.getDate() - 7);
                renderDates();
            });

            nextDateBtn.addEventListener('click', () => {
                startDate.setDate(startDate.getDate() + 7);
                renderDates();
            });

            prevMonthBtn.addEventListener('click', () => {
                startDate.setMonth(startDate.getMonth() - 1);
                renderDates();
            });

            nextMonthBtn.addEventListener('click', () => {
                startDate.setMonth(startDate.getMonth() + 1);
                renderDates();
            });

            // Initial render
            renderDates();
            updateSummaryDate();
            updateTimeSlots();
            updateMapStatus();

            // Hover Tooltip Fallback JS
            tables.forEach(table => {
                const tooltip = table.querySelector('.table-tooltip');
                if (tooltip) {
                    table.addEventListener('mouseenter', () => {
                        tooltip.style.opacity = '1';
                        tooltip.style.visibility = 'visible';
                        tooltip.style.transform = 'translate(-50%, -50%) scale(1)';
                        tooltip.style.zIndex = '11000';
                    });
                    table.addEventListener('mouseleave', () => {
                        tooltip.style.opacity = '0';
                        tooltip.style.visibility = 'hidden';
                        tooltip.style.transform = 'translate(-50%, -50%) scale(0.95)';
                        tooltip.style.zIndex = '1000';
                    });
                }
            });

            // Table Selection
            tables.forEach(table => {
                table.addEventListener('click', () => {
                    const status = table.dataset.status;

                    // Validation for Real-time Status
                    if (status === 'maintenance') {
                        Swal.fire({
                            title: 'Meja Maintenance',
                            text: 'Gagal! Meja ini sedang dalam perbaikan.',
                            icon: 'error',
                            confirmButtonColor: '#ff3b3b',
                            background: '#0f1115',
                            color: '#fff'
                        });
                        return;
                    }

                    if (status === 'occupied' || status === 'booked') {
                        Swal.fire({
                            title: 'Meja Tidak Tersedia',
                            text: 'Gagal! Meja ini sudah dipesan/terisi pada waktu tersebut. Silakan pilih waktu atau meja lain.',
                            icon: 'error',
                            confirmButtonColor: '#ff3b3b',
                            background: '#0f1115',
                            color: '#fff'
                        });
                        return;
                    }



                    // Current behavior: Hover opens popup, click selection toggle
                    const id = table.dataset.id;
                    const isAlreadySelected = selectedTables.find(t => t.id === id);

                    if (isAlreadySelected) {
                        // Deselect if already in list
                        selectedTables = selectedTables.filter(t => t.id !== id);
                        table.classList.remove('selected');
                    } else {
                        // Add to selection
                        const name = table.dataset.name;
                        const price = table.dataset.price;
                        const capacity = table.dataset.capacity || '4';
                        const type = table.dataset.type;
                        const image = table.dataset.image && table.dataset.image.trim() !== '' ? '/storage/' + table.dataset.image : '/images/hero-bg.png';

                        selectedTables.push({ id, name, price, capacity, type, image });
                        table.classList.add('selected');

                        // Flash animation for summary list
                        const listContainer = document.getElementById('selected-tables-list');
                        listContainer.classList.remove('update-flash');
                        void listContainer.offsetWidth;
                        listContainer.classList.add('update-flash');
                    }

                    updateSelectedTablesList();
                    updateTimeSlots(); // Refresh time slots based on new selection
                });
            });

            // Handle TAMBAH button click inside tooltip
            const addButtons = document.querySelectorAll('.tm-btn-add');
            addButtons.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation(); // Avoid triggering parent click

                    const parentTable = btn.closest('.billiard-table');
                    if (parentTable) {
                        const id = parentTable.dataset.id;
                        const isAlreadySelected = selectedTables.find(t => t.id === id);

                        if (!isAlreadySelected) {
                            parentTable.click(); // Trigger the click logic above
                        }

                        // Feedback
                        Swal.fire({
                            title: 'Meja Ditambahkan!',
                            text: `${parentTable.dataset.name} ditambahkan ke pesanan.`,
                            icon: 'success',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            background: '#0f1115',
                            color: '#fff',
                            iconColor: '#00f2ff'
                        });
                    }

                    document.querySelector('.booking-section').scrollIntoView({ behavior: 'smooth' });
                });
            });

            // Handle CHAT button click inside tooltip
            const chatButtons = document.querySelectorAll('.tm-btn-chat');
            chatButtons.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation(); // Avoid triggering parent click (table selection)

                    const parentTable = btn.closest('.billiard-table');
                    if (parentTable) {
                        const id = parentTable.dataset.id;
                        if (typeof window.openChatWindow === 'function') {
                            window.openChatWindow(id);
                        }
                    }
                });
            });

            timeSlots.forEach(slot => {
                slot.addEventListener('click', () => {
                    if (slot.classList.contains('disabled')) return; // Prevent selection of past time
                    timeSlots.forEach(s => s.classList.remove('active'));
                    slot.classList.add('active');
                    updateTimeSummary();
                    updateSelectedTablesList();
                    updateMapStatus(); // Refresh map statuses for the newly selected hour
                });
            });

            // Duration Slider
            rangeSlider.addEventListener('input', (e) => {
                const val = e.target.value;
                durationSelected = true;
                durationValue.innerText = val + ' Jam';
                document.getElementById('summary-duration').innerText = val + ' Jam';
                updateTimeSummary();
                updateSelectedTablesList();
                updateMapStatus(); // Refresh map statuses for updated duration window
            });

            function updateTimeSummary() {
                const activeTimeSlot = document.querySelector('.time-slot.active');
                if (selectedTables.length === 0 || !activeTimeSlot || !durationSelected) {
                    document.getElementById('summary-time').innerText = '-';
                    document.getElementById('summary-duration').innerText = '-';
                    return;
                }

                const duration = parseInt(rangeSlider.value);
                const dataHour = parseInt(activeTimeSlot.dataset.hour);

                // For data-hour >= 24, the real hour is dataHour - 24
                const startRealHour = dataHour >= 24 ? dataHour - 24 : dataHour;
                const endRealHour = (startRealHour + duration) % 24;

                const startStr = String(startRealHour).padStart(2, '0') + ':00';
                const endStr = String(endRealHour).padStart(2, '0') + ':00';

                document.getElementById('summary-time').innerText = `${startStr} - ${endStr}`;
                document.getElementById('summary-duration').innerText = duration + ' Jam';
            }

            function updateCalculations() {
                const duration = durationSelected ? parseInt(rangeSlider.value) : 0;
                const activeTimeSlot = document.querySelector('.time-slot.active');
                
                let dynamicPrice = null;
                if (activeTimeSlot) {
                    const hour = parseInt(activeTimeSlot.dataset.hour);
                    // Logika: Jam 2-5 sore -> 25000, Jam 6 sore-1 malam -> 35000
                    if (hour >= 14 && hour <= 17) {
                        dynamicPrice = 25000;
                    } else if (hour >= 18 && hour <= 25) {
                        dynamicPrice = 35000;
                    }
                }

                let subtotal = 0;
                selectedTables.forEach(t => {
                    // Jika ada harga dinamis yang berlaku, gunakan itu
                    if (dynamicPrice !== null) {
                        t.price = dynamicPrice;
                    }
                    subtotal += (parseInt(t.price) || 0) * duration;
                });

                const tax = Math.round(subtotal * 0.1);
                const total = subtotal + tax;

                document.getElementById('summary-subtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
                document.getElementById('summary-tax').innerText = 'Rp ' + tax.toLocaleString('id-ID');
                document.getElementById('summary-total').innerText = 'Rp ' + total.toLocaleString('id-ID');
            }

            updateCalculations();
            updateTimeSummary();

            const confirmBtn = document.getElementById('confirm-booking-btn');
            if (confirmBtn) {
                confirmBtn.addEventListener('click', function (e) {
                    e.preventDefault();

                    const orderData = {
                        tables: selectedTables,
                        date: document.getElementById('summary-date').innerText,
                        isoDate: selectedDate ? selectedDate.getFullYear() + '-' + String(selectedDate.getMonth() + 1).padStart(2, '0') + '-' + String(selectedDate.getDate()).padStart(2, '0') : null,
                        time: document.getElementById('summary-time').innerText,
                        duration: document.getElementById('summary-duration').innerText,
                        subtotal: document.getElementById('summary-subtotal').innerText,
                        tax: document.getElementById('summary-tax').innerText,
                        total: document.getElementById('summary-total').innerText
                    };

                    if (selectedTables.length === 0) {
                        Swal.fire({ icon: 'warning', title: 'Meja Kosong', text: 'Silakan pilih minimal satu meja dulu.', background: '#0f1115', color: '#fff' });
                        return;
                    }

                    if (!selectedDate) {
                        Swal.fire({ icon: 'warning', title: 'Tanggal Belum Dipilih', text: 'Silakan pilih tanggal main dulu.', background: '#0f1115', color: '#fff' });
                        return;
                    }

                    const activeTimeSlot = document.querySelector('.time-slot.active');
                    if (!activeTimeSlot) {
                        Swal.fire({ icon: 'warning', title: 'Jam Belum Dipilih', text: 'Silakan pilih jam mulai main dulu.', background: '#0f1115', color: '#fff' });
                        return;
                    }

                    if (!durationSelected) {
                        Swal.fire({ icon: 'warning', title: 'Durasi Belum Dipilih', text: 'Silakan tentukan durasi main dulu.', background: '#0f1115', color: '#fff' });
                        return;
                    }

                    // Client-side Overlap Conflict Verification
                    const selectedStartHour = parseInt(activeTimeSlot.dataset.hour);
                    const duration = parseInt(rangeSlider.value);
                    const selectedEndHour = selectedStartHour + duration;
                    const selectedDateStr = orderData.isoDate;

                    let hasOverlapConflict = false;
                    let conflictingTable = '';

                    selectedTables.forEach(selected => {
                        const tableData = allTables.find(t => t.id == selected.id);
                        if (!tableData || !tableData.bookings) return;

                        tableData.bookings.forEach(b => {
                            if (b.booking_date !== selectedDateStr) return;

                            let bStart = timeToFloat(b.start_time);
                            let bEnd = timeToFloat(b.end_time);
                            if (bEnd <= bStart) bEnd += 24;

                            if (selectedStartHour < bEnd && selectedEndHour > bStart) {
                                hasOverlapConflict = true;
                                conflictingTable = tableData.name;
                            }
                        });
                    });

                    if (hasOverlapConflict) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Jadwal Bentrok',
                            text: `Meja ${conflictingTable} sudah dipesan pada slot jam tersebut. Silakan pilih waktu bermain atau meja lain.`,
                            background: '#0f1115',
                            color: '#fff'
                        });
                        return;
                    }

                    localStorage.setItem('meja_order', JSON.stringify(orderData));
                    window.location.href = "{{ route('user.meja.konfirmasi') }}";
                });
            }
        });
    </script>
@endpush
