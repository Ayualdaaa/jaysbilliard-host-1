@extends('layouts.dashboard')

@section('title', 'Pesan Makanan & Minuman')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/css_page/user_fnb.css') }}">
@endpush

@section('content')
    <div class="fnb-wrapper">
        {{-- Left Column: Menu Selection --}}
        <div class="fnb-selection-area">

            {{-- Category Filter --}}
            <div class="category-filter">
                <button class="category-btn active" data-category="all">All Items</button>
                <button class="category-btn" data-category="Camilan">Camilan</button>
                <button class="category-btn" data-category="Minuman">Minuman</button>
            </div>

            {{-- Menu Grid --}}
            <div class="menu-grid">
                @forelse($menus as $menu)
                    <div class="menu-card" data-category="{{ $menu->category }}">
                        <div class="item-img-container">
                            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="item-img"
                                onerror="this.src='{{ asset('images/hero-bg.png') }}'">
                            <div class="item-price-tag">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="item-details">
                            <h3 class="item-name">{{ $menu->name }}</h3>
                            <div class="item-category">{{ $menu->category }} <span style="margin-left: 10px; color: {{ $menu->stock > 0 ? '#00e5ff' : '#ff5252' }}; font-weight: 700;">• {{ $menu->stock > 0 ? 'TERSEDIA' : 'HABIS' }}</span></div>
                            <p class="item-desc">{{ $menu->description }}</p>
                            <button class="add-btn" data-id="{{ $menu->id }}" data-name="{{ $menu->name }}"
                                data-price="{{ $menu->price }}" data-image="{{ asset('storage/' . $menu->image) }}"
                                data-category="{{ $menu->category }}" data-stock="{{ $menu->stock }}"
                                {{ $menu->stock <= 0 ? 'disabled' : '' }}>
                                {{ $menu->stock <= 0 ? 'HABIS' : 'TAMBAH' }}
                            </button>
                        </div>
                    </div>
                @empty
                    <div style="color: var(--text-muted); padding: 50px; text-align: center; grid-column: 1/-1;">
                        Belum ada menu yang tersedia.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Right Column: Order Cart --}}
        <div class="fnb-cart-area">
            <div class="cart-card">
                <h2 class="cart-title">Pesanan Saat Ini</h2>

                <div class="table-selection-wrap">
                    <label class="input-label">Antarkan ke Meja</label>
                    <select class="table-select">
                        <option value="" disabled selected>Pilih Meja</option>
                        @foreach($tables as $table)
                            <option value="{{ $table->id }}">{{ $table->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="cart-items-list" id="cart-items-list">
                    {{-- Dynamic Cart Items --}}
                    <div class="empty-cart-msg" style="text-align: center; color: var(--text-muted); padding: 40px 0;">
                        Belum ada pesanan
                    </div>
                </div>

                <div class="cart-calculation">
                    <div class="calc-row">
                        <span>Subtotal</span>
                        <span id="cart-subtotal">Rp 0</span>
                    </div>
                    <div class="calc-row">
                        <span>Service & Tax (10%)</span>
                        <span id="cart-tax">Rp 0</span>
                    </div>
                    <div class="calc-total">
                        <span class="total-label">Total</span>
                        <span class="total-value" id="cart-total">Rp 0</span>
                    </div>
                </div>

                <button class="checkout-btn" id="confirm-order-btn">Konfirmasi Pemesanan</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categoryBtns = document.querySelectorAll('.category-btn');
            const menuCards = document.querySelectorAll('.menu-card');
            const addBtns = document.querySelectorAll('.add-btn');
            const cartList = document.getElementById('cart-items-list');
            const subtotalEl = document.getElementById('cart-subtotal');
            const taxEl = document.getElementById('cart-tax');
            const totalEl = document.getElementById('cart-total');
            const checkoutBtn = document.getElementById('confirm-order-btn');

            let cart = [];
            const fallbackImage = "{{ asset('images/hero-bg.png') }}";

            function escapeHtml(value) {
                return String(value || '').replace(/[&<>"']/g, function (char) {
                    return {
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#039;'
                    }[char];
                });
            }

            // Category Filtering
            categoryBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    categoryBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');

                    const category = btn.dataset.category;
                    menuCards.forEach(card => {
                        if (category === 'all' || card.dataset.category === category) {
                            card.style.display = 'flex';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });

            // Add to Cart Logic
            addBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    const name = btn.dataset.name;
                    const price = parseInt(btn.dataset.price);
                    const image = btn.dataset.image;
                    const category = btn.dataset.category;
                    const maxStock = parseInt(btn.dataset.stock);

                    const existingItem = cart.find(item => item.id === id);

                    if (existingItem) {
                        if (existingItem.quantity >= maxStock) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Stok Terbatas',
                                text: `Maaf, stok ${name} hanya tersedia ${maxStock} item.`,
                                background: '#141418',
                                color: '#fff'
                            });
                            return;
                        }
                        existingItem.quantity += 1;
                    } else {
                        cart.push({ id, name, price, image, category, quantity: 1, maxStock });
                    }

                    renderCart();

                    // feedback
                    btn.innerText = 'DITAMBAHKAN!';
                    btn.style.background = 'var(--primary-glow)';
                    setTimeout(() => {
                        btn.innerText = 'TAMBAH';
                        btn.style.background = 'rgba(255, 255, 255, 0.03)';
                    }, 1000);
                });
            });

            function renderCart() {
                if (cart.length === 0) {
                    cartList.innerHTML = `
                                <div class="empty-cart-msg" style="text-align: center; color: var(--text-muted); padding: 40px 0;">
                                    Belum ada pesanan
                                </div>
                            `;
                    updateTotals(0);
                    return;
                }

                cartList.innerHTML = '';
                let subtotal = 0;

                cart.forEach((item, index) => {
                    subtotal += item.price * item.quantity;
                    const itemHtml = `
                                <div class="cart-item">
                                    <img src="${escapeHtml(item.image)}" class="cart-item-img" onerror="this.src='${fallbackImage}'">
                                    <div class="cart-item-info">
                                        <div class="cart-item-name">${escapeHtml(item.name)}</div>
                                        <div class="cart-item-meta">${escapeHtml(item.category)}</div>
                                    </div>
                                    <div class="cart-item-right">
                                        <div class="cart-item-price">Rp ${(item.price * item.quantity).toLocaleString('id-ID')}</div>
                                        <div class="quantity-control">
                                            <button class="qty-btn" onclick="updateQty(${index}, -1)">-</button>
                                            <span class="qty-value">${item.quantity}</span>
                                            <button class="qty-btn" onclick="updateQty(${index}, 1)">+</button>
                                        </div>
                                    </div>
                                </div>
                            `;
                    cartList.insertAdjacentHTML('beforeend', itemHtml);
                });

                updateTotals(subtotal);
            }

            window.updateQty = function (index, delta) {
                const item = cart[index];
                if (delta > 0 && item.quantity >= item.maxStock) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Stok Terbatas',
                        text: `Maaf, stok hanya tersedia ${item.maxStock} item.`,
                        background: '#141418',
                        color: '#fff'
                    });
                    return;
                }
                
                item.quantity += delta;
                if (item.quantity <= 0) {
                    cart.splice(index, 1);
                }
                renderCart();
            }

            function updateTotals(subtotal) {
                const tax = subtotal * 0.1;
                const total = subtotal + tax;

                subtotalEl.innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
                taxEl.innerText = 'Rp ' + tax.toLocaleString('id-ID');
                totalEl.innerText = 'Rp ' + total.toLocaleString('id-ID');
            }

            checkoutBtn.addEventListener('click', () => {
                if (cart.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Cart Kosong',
                        text: 'Silakan pilih menu terlebih dahulu!',
                        background: '#141418',
                        color: '#fff'
                    });
                    return;
                }

                const tableSelect = document.querySelector('.table-select');
                if (!tableSelect.value) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Meja Belum Dipilih',
                        text: 'Silakan pilih nomor meja Anda!',
                        background: '#141418',
                        color: '#fff'
                    });
                    return;
                }

                let finalSubtotal = 0;
                cart.forEach(item => finalSubtotal += item.price * item.quantity);
                const finalTax = finalSubtotal * 0.1;

                const orderSummary = {
                    tableId: tableSelect.value,
                    tableName: tableSelect.options[tableSelect.selectedIndex].text,
                    items: cart,
                    subtotal: finalSubtotal,
                    tax: finalTax,
                    total: finalSubtotal + finalTax
                };
                localStorage.setItem('fnb_order', JSON.stringify(orderSummary));

                window.location.href = "{{ route('user.fnb.konfirmasi') }}";
            });
        });
    </script>
@endpush
