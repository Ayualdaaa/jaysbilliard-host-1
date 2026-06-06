<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Add Meja Baru — Jay's Billiard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/css_layout/app_admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css_page/css_interaksi page/buat_meja.css') }}">
</head>
<body>
    <div class="adm-layout">
        @include('component.c_dashboard.sidebar.sidebar_admin')
        <main class="adm-main">
            @include('component.c_dashboard.topbar.topbar', [
                'topbar_title' => 'Meja',
                'topbar_sub' => "Kelola kebutuhan operasional jay's billiard"
            ])
            <div class="adm-content">
                <div class="adm-content-header">
                    <div class="adm-breadcrumb">
                        <a href="{{ url('/admin-dashboard') }}" class="adm-breadcrumb-back">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                        </a>
                        <a href="{{ url('/admin-dashboard') }}">Dashboard</a>
                        <span class="adm-breadcrumb-separator">•</span>
                        <span>Add Meja Baru</span>
                    </div>
                </div>

                {{-- Alert Error --}}
                @if ($errors->any())
                    <div class="adm-alert adm-alert--error">
                        <div class="adm-alert-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m10.29 3.86 7.22 12.42A2 2 0 0 1 15.78 19H3.22a2 2 0 0 1-1.73-3L8.71 3.86a2 2 0 0 1 3.58 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        </div>
                        <div class="adm-alert-content">
                            <span class="adm-alert-title">Ups! Something Wrong</span>
                            <ul class="adm-alert-list">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <form action="{{ route('admin.meja.store') }}" method="POST" enctype="multipart/form-data" id="mejaForm">
                    @csrf
                    <div class="adm-meja-form-grid">
                        <div class="adm-form-side">
                            <div class="adm-card">
                                <h2 class="adm-card-title">Preview Card - Add Meja Baru</h2>
                                <div class="adm-preview-container">
                                    <div class="table-preview-card">
                                        <div class="table-preview-image">
                                            <img src="/images/hero-bg.png" id="previewImg" alt="Preview Table">
                                            <div class="table-preview-price-tag" style="display: none;">Rp <span id="previewPriceText">Lorem</span></div>
                                        </div>
                                        <div class="table-preview-content">
                                            <div class="table-preview-header">
                                                <h3 class="table-preview-name" id="previewNameText">Lorem</h3>
                                                <div class="table-preview-status"><div class="status-dot"></div> TERSEDIA</div>
                                            </div>
                                            <div class="table-preview-sub-info">
                                                <span class="sub-info-item">Lorem</span>
                                                <span class="sub-info-item">Lorem</span>
                                            </div>
                                            <p class="table-preview-desc" id="previewDescText">.Lorem ipsum dolor sit amet</p>
                                        </div>
                                        <div class="table-preview-actions">
                                            <div class="btn-preview-edit">EDIT MEJA</div>
                                            <div class="btn-preview-delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="adm-card">
                                <h2 class="adm-card-title">Masukan Gambar</h2>
                                <div class="upload-box" onclick="document.getElementById('imageInput').click()">
                                    <div class="upload-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                    </div>
                                    <span class="upload-title">Unggah Gambar</span>
                                    <span class="upload-subtext">PNG, JPG hingga 10MB</span>
                                    <input type="file" name="image" id="imageInput" accept="image/*" style="display: none;" onchange="previewFile()">
                                </div>
                            </div>
                        </div>
                        <div class="adm-form-main">
                            <div class="adm-card">
                                <h2 class="adm-card-title">Masukan Data Meja</h2>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label">Nomor/Nama Meja</label>
                                        <input type="text" name="name" id="nameInput" class="form-input @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Cth. Meja 0..." required>
                                    </div>
                                    <input type="hidden" name="type" id="typeInput" value="regular">
                                </div>
                                <div class="form-row">
                                    <input type="hidden" name="price_per_hour" id="priceInput" value="0">
                                    <div class="form-group" style="grid-column: span 2;">
                                        <label class="form-label">Kapasitas</label>
                                        <input type="number" name="capacity" id="capacityInput" class="form-input" value="0">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Deskripsi / Catatan Khusus</label>
                                    <textarea name="description" id="descInput" class="form-input form-input--textarea" placeholder="Masukkan kondisi meja, detail produsen, atau spesifikasi lokasi..."></textarea>
                                </div>
                                
                                <div class="form-group--status">
                                    <label class="form-label">Status</label>
                                    <div class="status-radio-group">
                                        <label class="status-radio">
                                            <input type="radio" name="status" value="active" checked>
                                            <div class="radio-circle"></div>
                                            <span>Active</span>
                                        </label>
                                        <label class="status-radio status-radio--maintenance">
                                            <input type="radio" name="status" value="maintenance">
                                            <div class="radio-circle"></div>
                                            <span>Maintenance</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="adm-form-footer">
                                <a href="{{ route('admin.meja.index') }}" class="btn-cancel">Cancel</a>
                                <button type="submit" class="btn-submit">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <script>
        const nameInput = document.getElementById('nameInput');
        const typeInput = document.getElementById('typeInput');
        const priceInput = document.getElementById('priceInput');
        const descInput = document.getElementById('descInput');
        
        const previewNameText = document.getElementById('previewNameText');
        const previewPriceText = document.getElementById('previewPriceText');
        const previewDescText = document.getElementById('previewDescText');
        
        // Dynamic Preview Logic
        nameInput.addEventListener('input', (e) => {
            previewNameText.textContent = e.target.value || 'Meja Baru';
        });

        priceInput.addEventListener('input', (e) => {
            const val = e.target.value;
            previewPriceText.textContent = val && val != 0 ? Number(val).toLocaleString('id-ID') : '0';
        });

        descInput.addEventListener('input', (e) => {
            previewDescText.textContent = e.target.value || 'Deskripsi meja akan tampil di sini...';
        });
        
        // Image Preview Logic
        function previewFile() {
            const preview = document.getElementById('previewImg');
            const file = document.getElementById('imageInput').files[0];
            const reader = new FileReader();

            reader.onloadend = () => {
                preview.src = reader.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "/images/hero-bg.png";
            }
        }

        // Form Submission visual feedback
        document.getElementById('mejaForm').addEventListener('submit', function() {
            const btn = this.querySelector('.btn-submit');
            btn.innerHTML = '<svg class="animate-spin" style="width:18px;height:18px;margin-right:8px" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" stroke-dasharray="32" /></svg> Memproses...';
            btn.style.opacity = '0.7';
            btn.style.pointerEvents = 'none';
        });
    </script>
    <style>
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .animate-spin { animation: spin 1s linear infinite; vertical-align: middle; }
    </style>

    {{-- Logout Modal --}}
    @include('component.c_dashboard.modal.logout_modal')
    <script src="{{ asset('js/js_component/logout.js') }}"></script>
</body>
</html>
