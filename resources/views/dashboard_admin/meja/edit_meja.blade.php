<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit {{ $table->name }} — Jay's Billiard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/css_layout/app_admin.css') }}">
    
    <style>
        /* ═══════════════════════════════ EDIT PAGE PREMIUM STYLE ═══════════════════════════════ */
        .adm-edit-grid {
            display: grid;
            grid-template-columns: 400px 1fr;
            gap: 2rem;
            margin-top: 1.5rem;
        }

        /* Preview Column */
        .adm-preview-col {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .adm-preview-card-wrap {
            padding: 2rem;
            background: #0d1117;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 28px;
            display: flex;
            justify-content: center;
        }

        /* The actual card from the grid */
        .preview-table-card {
            background: #111418;
            border: 1.5px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            width: 100%;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .preview-img-wrap {
            height: 180px;
            position: relative;
            background: #080a0f;
        }

        .preview-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-price-badge {
            position: absolute;
            top: 1rem; right: 1rem;
            background: #00d1ff;
            color: #000;
            padding: 0.4rem 0.9rem;
            font-size: 0.72rem;
            font-weight: 900;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 209, 255, 0.3);
        }

        .preview-body {
            padding: 1.5rem;
        }

        .preview-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .preview-name {
            font-size: 1.25rem;
            font-weight: 900;
            color: #fff;
        }

        .preview-status {
            font-size: 0.65rem;
            font-weight: 800;
            color: #00d1ff;
            letter-spacing: 0.05em;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .status-dot { width: 6px; height: 6px; border-radius: 50%; background: #00d1ff; box-shadow: 0 0 6px #00d1ff; }
        .status-dot--maintenance { background: #ff5252; box-shadow: 0 0 6px #ff5252; }
        .preview-status--maintenance { color: #ff5252; }

        .preview-details {
            display: flex;
            gap: 0.75rem;
            font-size: 0.72rem;
            color: rgba(255, 255, 255, 0.25);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .preview-desc {
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.4);
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Form Styling */
        .adm-form-card {
            background: #0d1117;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 28px;
            padding: 2.5rem;
        }

        .adm-form-title {
            font-size: 1.5rem;
            font-weight: 900;
            color: #fff;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .adm-form-title svg { color: #00d1ff; }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.65rem;
        }

        .form-label {
            font-size: 0.78rem;
            font-weight: 800;
            color: rgba(255, 255, 255, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .form-input {
            background: #080a0f;
            border: 1.5px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            color: #fff;
            font-size: 1rem;
            font-weight: 600;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            border-color: #00d1ff;
            background: #0a0c12;
            box-shadow: 0 0 15px rgba(0, 209, 255, 0.1);
        }

        .form-input--textarea {
            height: 120px;
            resize: none;
        }

        /* Custom Radio Status */
        .status-options {
            display: flex;
            gap: 1.5rem;
            margin-top: 0.5rem;
        }

        .status-opt {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 0.75rem 1.25rem;
            background: #080a0f;
            border: 1.5px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .status-opt input { display: none; }
        .status-opt span { font-size: 0.85rem; font-weight: 800; color: rgba(255, 255, 255, 0.4); }

        .status-opt:has(input:checked) {
            border-color: #00d1ff;
            background: rgba(0, 209, 255, 0.05);
        }

        .status-opt:has(input:checked) span { color: #fff; }

        .status-opt--maintenance:has(input:checked) {
            border-color: #ff5252;
            background: rgba(255, 82, 82, 0.05);
        }

        /* Upload Styling */
        .upload-area {
            background: #080a0f;
            border: 1.5px dashed rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .upload-area:hover { border-color: #00d1ff; background: #0a0e14; }

        .upload-icon-wrap {
            width: 48px; height: 48px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255, 255, 255, 0.2);
        }

        .upload-text { font-size: 0.85rem; font-weight: 800; color: #fff; }
        .upload-sub { font-size: 0.72rem; color: rgba(255, 255, 255, 0.25); }

        /* Actions */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .btn-update {
            background: #00d1ff;
            color: #000;
            border: none;
            padding: 1rem 3rem;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 900;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(0, 209, 255, 0.2);
        }

        .btn-cancel {
            background: transparent;
            color: rgba(255, 255, 255, 0.5);
            border: 1.5px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 3rem;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 800;
            text-decoration: none;
        }

        .btn-update:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0, 209, 255, 0.3); }

        /* Responsive */
        @media (max-width: 1024px) {
            .adm-edit-grid {
                grid-template-columns: 1fr;
            }
            .adm-preview-col {
                order: 2;
            }
            .adm-form-main-col {
                order: 1;
            }
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            .form-group[style*="grid-column"] {
                grid-column: span 1 !important;
            }
            .status-options {
                flex-direction: column;
                gap: 1rem;
            }
            .form-actions {
                flex-direction: column-reverse;
                gap: 1rem;
            }
            .btn-update, .btn-cancel {
                width: 100%;
                text-align: center;
                box-sizing: border-box;
            }
            .adm-form-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="adm-layout">
        @include('component.c_dashboard.sidebar.sidebar_admin')

        <main class="adm-main">
            @include('component.c_dashboard.topbar.topbar', [
                'topbar_title' => 'Edit Meja',
                'topbar_sub' => 'Perbarui spesifikasi dan ketersediaan meja'
            ])

            <div class="adm-content">
                <div class="adm-breadcrumb">
                    <a href="{{ route('admin.meja.index') }}" class="adm-breadcrumb-back">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    </a>
                    <a href="{{ route('admin.meja.index') }}">Manajemen Meja</a>
                    <span class="adm-breadcrumb-separator">•</span>
                    <span>{{ $table->name }}</span>
                </div>

                <form action="{{ route('admin.meja.update', $table->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
                    @csrf @method('PUT')
                    
                    <div class="adm-edit-grid">
                        {{-- SIDE: PREVIEW --}}
                        <div class="adm-preview-col">
                            <div class="adm-preview-card-wrap">
                                <div class="preview-table-card">
                                    <div class="preview-img-wrap">
                                        <div class="preview-price-badge" style="display: none;">Rp <span id="viewPrice">{{ number_format($table->price_per_hour, 0, ',', '.') }}</span></div>
                                        <img src="{{ $table->image ? asset('storage/' . $table->image) : asset('images/hero-bg.png') }}" id="renderImg" alt="Preview">
                                    </div>
                                    <div class="preview-body">
                                        <div class="preview-header-row">
                                            <h3 class="preview-name" id="viewName">{{ strtoupper($table->name) }}</h3>
                                            <div class="preview-status" id="viewStatusBox">
                                                <span class="status-dot" id="viewStatusDot"></span> 
                                                <span id="viewStatusText">{{ strtoupper($table->status === 'active' ? 'Tersedia' : 'Maintenance') }}</span>
                                            </div>
                                        </div>
                                        <div class="preview-details">
                                            <span id="viewType">{{ strtoupper($table->type === 'regular' ? 'standar' : $table->type) }}</span>
                                            <span>|</span>
                                            <span id="viewCap">{{ $table->capacity }} ORANG</span>
                                        </div>
                                        <p class="preview-desc" id="viewDesc">{{ $table->description ?: 'Deskripsi meja billiard...' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="adm-form-card">
                                <h2 class="form-label" style="margin-bottom: 1rem;">Ganti Foto Meja</h2>
                                <div class="upload-area" onclick="document.getElementById('imgInp').click()">
                                    <div class="upload-icon-wrap">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                    </div>
                                    <span class="upload-text">Unggah Foto Baru</span>
                                    <span class="upload-sub">Klik atau drag foto ke sini</span>
                                    <input type="file" name="image" id="imgInp" accept="image/*" style="display: none;" onchange="previewImgFile()">
                                </div>
                            </div>
                        </div>

                        {{-- MAIN: FORM --}}
                        <div class="adm-form-main-col">
                            <div class="adm-form-card">
                                <h2 class="adm-form-title">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    Detail Informasi Meja
                                </h2>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label">Nama / Nomor Meja</label>
                                        <input type="text" name="name" id="inpName" class="form-input" value="{{ $table->name }}" required>
                                    </div>
                                    <input type="hidden" name="type" id="inpType" value="{{ $table->type }}">
                                </div>

                                <div class="form-row">
                                    <input type="hidden" name="price_per_hour" id="inpPrice" value="{{ (int)$table->price_per_hour }}">
                                    <div class="form-group" style="grid-column: span 2;">
                                        <label class="form-label">Kapasitas Maksimal</label>
                                        <input type="number" name="capacity" id="inpCap" class="form-input" value="{{ $table->capacity }}">
                                    </div>
                                </div>

                                <div class="form-group" style="margin-bottom: 2rem;">
                                    <label class="form-label">Deskripsi & Spesifikasi</label>
                                    <textarea name="description" id="inpDesc" class="form-input form-input--textarea">{{ $table->description }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Status Ketersediaan Operasional</label>
                                    <div class="status-options">
                                        <label class="status-opt">
                                            <input type="radio" name="status" value="active" {{ $table->status == 'active' ? 'checked' : '' }} onchange="updateStatusPreview('active')">
                                            <span>ACTIVE / READY</span>
                                        </label>
                                        <label class="status-opt status-opt--maintenance">
                                            <input type="radio" name="status" value="maintenance" {{ $table->status == 'maintenance' ? 'checked' : '' }} onchange="updateStatusPreview('maintenance')">
                                            <span>MAINTENANCE</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <a href="{{ route('admin.meja.index') }}" class="btn-cancel">BATAL</a>
                                    <button type="submit" class="btn-update">SIMPAN PERUBAHAN</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Real-time Preview Script
        const inpName = document.getElementById('inpName');
        const inpPrice = document.getElementById('inpPrice');
        const inpType = document.getElementById('inpType');
        const inpCap = document.getElementById('inpCap');
        const inpDesc = document.getElementById('inpDesc');

        const viewName = document.getElementById('viewName');
        const viewPrice = document.getElementById('viewPrice');
        const viewType = document.getElementById('viewType');
        const viewCap = document.getElementById('viewCap');
        const viewDesc = document.getElementById('viewDesc');

        inpName.addEventListener('input', (e) => viewName.innerText = e.target.value.toUpperCase() || 'NAMA MEJA');
        inpPrice.addEventListener('input', (e) => viewPrice.innerText = Number(e.target.value).toLocaleString('id-ID'));
        inpType.addEventListener('change', (e) => viewType.innerText = e.target.value.toUpperCase());
        inpCap.addEventListener('input', (e) => viewCap.innerText = (e.target.value || 0) + ' ORANG');
        inpDesc.addEventListener('input', (e) => viewDesc.innerText = e.target.value || 'Deskripsi...');

        function updateStatusPreview(status) {
            const box = document.getElementById('viewStatusBox');
            const dot = document.getElementById('viewStatusDot');
            const txt = document.getElementById('viewStatusText');

            if(status === 'active') {
                box.className = 'preview-status';
                dot.className = 'status-dot';
                txt.innerText = 'TERSEDIA';
            } else {
                box.className = 'preview-status preview-status--maintenance';
                dot.className = 'status-dot status-dot--maintenance';
                txt.innerText = 'MAINTENANCE';
            }
        }

        function previewImgFile() {
            const preview = document.getElementById('renderImg');
            const file = document.getElementById('imgInp').files[0];
            const reader = new FileReader();
            reader.onloadend = () => preview.src = reader.result;
            if (file) reader.readAsDataURL(file);
        }

        // Initialize status preview
        updateStatusPreview('{{ $table->status }}');
    </script>

    {{-- Logout Modal --}}
    @include('component.c_dashboard.modal.logout_modal')
    <script src="{{ asset('js/js_component/logout.js') }}"></script>
</body>
</html>
