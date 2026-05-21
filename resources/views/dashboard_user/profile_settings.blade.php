@extends('layouts.dashboard')

@section('title', "Profile Settings — Jay's Billiard")

@section('content')
    {{-- SweetAlert2 for premium feedback --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="ps-page-wrapper">
        {{-- Page Header --}}
        <div class="ps-header-section">
            <h1 class="ps-page-title">Profile Settings</h1>
            <p class="ps-page-subtitle">Kelola profil pribadi, kata sandi, dan preferensi akun Anda dari satu tempat.</p>
        </div>

        {{-- Avatar Card --}}
        <div class="ps-avatar-card">
            <div class="ps-avatar-card-inner">
                <div class="ps-avatar-left">
                    <div class="ps-avatar-circle" id="psAvatarCircle">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</div>
                    {{-- Hidden File Input --}}
                    <input type="file" id="psAvatarInput" accept="image/*" style="display: none;" onchange="handleFileSelect(event)">
                    
                    <div class="ps-avatar-upload-info">
                        <span class="ps-upload-label">Unggah Gambar</span>
                        <span class="ps-upload-hint">PNG, JPG hingga 10MB</span>
                    </div>
                </div>
                <div class="ps-avatar-center">
                    <h2 class="ps-user-name">{{ $user->name ?? 'User' }}</h2>
                    <p class="ps-user-meta">{{ ucfirst($user->role ?? 'User') }} <span class="ps-dot">•</span> Anggota Sejak {{ date('Y', strtotime($user->created_at ?? now())) }}</p>
                    <div class="ps-avatar-actions">
                        <button class="btn-ps-cyan" onclick="document.getElementById('psAvatarInput').click()">Upload New Photo</button>
                        <button class="btn-ps-remove" onclick="removePhoto()">Remove</button>
                    </div>
                </div>
                <div class="ps-avatar-right">
                    <label class="ps-toggle">
                        <input type="checkbox" checked onchange="toggleNotification(this)">
                        <span class="ps-toggle-slider"></span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Forms Row --}}
        <div class="ps-forms-grid">
            {{-- Informasi Pribadi --}}
            <div class="ps-form-card">
                <h3 class="ps-card-title">Informasi Pribadi</h3>
                <form id="personalInfoForm" class="ps-form">
                    <div class="ps-form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="full_name" value="{{ $user->name ?? '' }}" required>
                    </div>
                    <div class="ps-form-group">
                        <label>Username</label>
                        <input type="text" name="username" value="{{ $user->username ?? '' }}" required>
                    </div>
                    <div class="ps-form-row">
                        <div class="ps-form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ $user->email ?? '' }}" required>
                        </div>
                        <div class="ps-form-group">
                            <label>Nomor Telepon</label>
                            <input type="text" name="phone" value="{{ $user->phone ?? '' }}" required>
                        </div>
                    </div>
                    <div class="ps-form-actions">
                        <button type="button" class="btn-ps-cyan" onclick="validateAndSave('personalInfoForm')">Save Perubahan</button>
                    </div>
                </form>
            </div>

            {{-- Keamanan & Kata Sandi --}}
            <div class="ps-form-card">
                <h3 class="ps-card-title">Keamanan & Kata Sandi</h3>
                <form id="securityForm" class="ps-form">
                    <div class="ps-form-group">
                        <label>Kata Sandi Saat Ini</label>
                        <input type="password" name="current_password" placeholder="Masukkan kata sandi saat ini" required>
                    </div>
                    <div class="ps-form-row">
                        <div class="ps-form-group">
                            <label>Kata Sandi Baru</label>
                            <input type="password" name="new_password" placeholder="Masukkan kata sandi baru" required>
                        </div>
                        <div class="ps-form-group">
                            <label>Konfirmasi Kata Sandi</label>
                            <input type="password" name="confirm_password" placeholder="Konfirmasi kata sandi baru" required>
                        </div>
                    </div>
                    <div class="ps-form-actions">
                        <button type="button" class="btn-ps-cyan" onclick="validateAndSave('securityForm')">Save Kata Sandi Baru</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Final Action --}}
        <div class="ps-bottom-actions">
            <button class="btn-ps-cyan-large" onclick="validateAndSaveAll()">Save Semua</button>
        </div>
    </div>

    <script>
        /**
         * Jalankan saat halaman dimuat
         */
        window.addEventListener('DOMContentLoaded', () => {
            loadStoredAvatar();
        });

        /**
         * Load foto dari localStorage
         */
        function loadStoredAvatar() {
            const savedAvatar = localStorage.getItem('user_avatar');
            const circles = document.querySelectorAll('.ps-avatar-circle, .adm-user-avatar');
            
            if (savedAvatar) {
                circles.forEach(circle => {
                    circle.innerHTML = `<img src="${savedAvatar}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">`;
                });
            }
        }

        /**
         * Logic untuk handel upload foto
         */
        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (!file) return;

            // Validasi ukuran file (max 10MB)
            if (file.size > 10 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Terlalu Besar',
                    text: 'Ukuran foto maksimal adalah 10MB.',
                    background: '#16191d',
                    color: '#fff'
                });
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const dataUrl = e.target.result;
                
                // Simpan ke localStorage agar tidak hilang saat reload
                localStorage.setItem('user_avatar', dataUrl);
                
                // Update semua avatar di halaman
                loadStoredAvatar();
            }
            reader.readAsDataURL(file);
        }

        /**
         * Reset foto profil ke inisial
         */
        function removePhoto() {
            localStorage.removeItem('user_avatar');
            const circles = document.querySelectorAll('.ps-avatar-circle, .adm-user-avatar');
            const userInitial = '{{ strtoupper(substr($user->name ?? "U", 0, 1)) }}';
            
            circles.forEach(circle => {
                circle.innerHTML = userInitial;
            });
            
            document.getElementById('psAvatarInput').value = '';
        }

        /**
         * Validasi dan simpan satu form via AJAX ke backend
         */
        function validateAndSave(formId) {
            const form = document.getElementById(formId);
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Logika khusus untuk keamanan (password matching)
            if (formId === 'securityForm') {
                const newPass = form.querySelector('input[name="new_password"]').value;
                const confirmPass = form.querySelector('input[name="confirm_password"]').value;

                if (newPass !== confirmPass) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kata Sandi Tidak Cocok',
                        text: 'Konfirmasi kata sandi baru tidak sesuai dengan yang Anda masukkan.',
                        background: '#16191d',
                        color: '#fff',
                        confirmButtonColor: '#d33'
                    });
                    return;
                }
            }

            // Tampilkan loading spinner
            Swal.fire({
                title: 'Menyimpan...',
                text: 'Harap tunggu sebentar.',
                background: '#16191d',
                color: '#fff',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Persiapkan data
            const formData = new FormData(form);
            formData.append('_token', '{{ csrf_token() }}');

            // Send AJAX
            fetch('{{ route("user.profile.update") }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update user name di topbar & avatar card
                    if (formId === 'personalInfoForm') {
                        const newName = form.querySelector('input[name="full_name"]').value;
                        document.querySelectorAll('.adm-profile-name, .ps-user-name').forEach(el => {
                            el.textContent = newName;
                        });
                    }

                    // Reset password fields jika security form berhasil
                    if (formId === 'securityForm') {
                        form.reset();
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Disimpan',
                        text: data.message || 'Perubahan telah berhasil diperbarui.',
                        background: '#16191d',
                        color: '#fff',
                        confirmButtonColor: '#00e5ff'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message || 'Terjadi kesalahan saat menyimpan.',
                        background: '#16191d',
                        color: '#fff',
                        confirmButtonColor: '#d33'
                    });
                }
            })
            .catch(error => {
                console.error(error);
                let errMsg = 'Terjadi kesalahan sistem.';
                if (error.errors) {
                    errMsg = Object.values(error.errors).flat().join('\n');
                } else if (error.message) {
                    errMsg = error.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan',
                    text: errMsg,
                    background: '#16191d',
                    color: '#fff',
                    confirmButtonColor: '#d33'
                });
            });
        }

        /**
         * Validasi dan simpan semua data
         */
        async function validateAndSaveAll() {
            const form1 = document.getElementById('personalInfoForm');
            const form2 = document.getElementById('securityForm');

            // Cek validitas form personal
            if (!form1.checkValidity()) {
                form1.reportValidity();
                return;
            }

            // Tampilkan loading spinner
            Swal.fire({
                title: 'Menyimpan Semua Perubahan...',
                text: 'Harap tunggu sebentar.',
                background: '#16191d',
                color: '#fff',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                // Submit Form 1 (Personal Info)
                const formData1 = new FormData(form1);
                formData1.append('_token', '{{ csrf_token() }}');
                
                const response1 = await fetch('{{ route("user.profile.update") }}', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json' },
                    body: formData1
                });
                
                const resData1 = await response1.json();
                if (!response1.ok) {
                    throw resData1;
                }

                // Update UI name
                const newName = form1.querySelector('input[name="full_name"]').value;
                document.querySelectorAll('.adm-profile-name, .ps-user-name').forEach(el => {
                    el.textContent = newName;
                });

                // Cek jika ada input password, maka submit Form 2 (Security)
                const currentPass = form2.querySelector('input[name="current_password"]').value;
                const newPass = form2.querySelector('input[name="new_password"]').value;
                const confirmPass = form2.querySelector('input[name="confirm_password"]').value;

                if (currentPass || newPass || confirmPass) {
                    if (!form2.checkValidity()) {
                        Swal.close();
                        form2.reportValidity();
                        return;
                    }

                    if (newPass !== confirmPass) {
                        throw { message: 'Konfirmasi kata sandi baru tidak cocok.' };
                    }

                    const formData2 = new FormData(form2);
                    formData2.append('_token', '{{ csrf_token() }}');

                    const response2 = await fetch('{{ route("user.profile.update") }}', {
                        method: 'POST',
                        headers: { 'Accept': 'application/json' },
                        body: formData2
                    });
                    
                    const resData2 = await response2.json();
                    if (!response2.ok) {
                        throw resData2;
                    }
                    
                    form2.reset();
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Semua Perubahan Disimpan!',
                    text: 'Profil dan kredensial keamanan Anda telah berhasil diperbarui.',
                    background: '#16191d',
                    color: '#fff',
                    confirmButtonColor: '#00e5ff'
                });

            } catch (error) {
                console.error(error);
                let errMsg = 'Terjadi kesalahan sistem.';
                if (error.errors) {
                    errMsg = Object.values(error.errors).flat().join('\n');
                } else if (error.message) {
                    errMsg = error.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Penyimpanan Gagal',
                    text: errMsg,
                    background: '#16191d',
                    color: '#fff',
                    confirmButtonColor: '#d33'
                });
            }
        }

        /**
         * Feedback untuk toggle
         */
        function toggleNotification(checkbox) {
            const status = checkbox.checked ? 'diaktifkan' : 'dinonaktifkan';
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                icon: 'success',
                title: `Notifikasi sistem ${status}`,
                background: '#16191d',
                color: '#fff'
            });
        }
    </script>

    <style>
        .ps-page-wrapper {
            padding: 2.5rem 3rem;
            color: #fff;
            max-width: 1200px;
        }

        /* Header */
        .ps-header-section {
            margin-bottom: 2rem;
        }

        .ps-page-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .ps-page-subtitle {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.4);
            max-width: 800px;
        }

        /* Avatar Card */
        .ps-avatar-card {
            background: #0c0e14;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1.5rem;
            padding: 2.5rem;
            margin-bottom: 2rem;
        }

        .ps-avatar-card-inner {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .ps-avatar-left {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .ps-avatar-circle {
            width: 100px;
            height: 100px;
            background: #00e5ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 800;
            color: #0c0e14;
        }

        .ps-avatar-upload-info {
            text-align: center;
        }

        .ps-upload-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.2rem;
        }

        .ps-upload-hint {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.3);
        }

        .ps-avatar-center {
            flex: 1;
        }

        .ps-user-name {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
        }

        .ps-user-meta {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 1.5rem;
        }

        .ps-dot {
            margin: 0 0.4rem;
        }

        .ps-avatar-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn-ps-cyan {
            background: #00e5ff;
            color: #0c0e14;
            border: none;
            padding: 0.6rem 1.25rem;
            border-radius: 0.6rem;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-ps-remove {
            background: #16191d;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 0.6rem 1.25rem;
            border-radius: 0.6rem;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
        }

        /* Toggle */
        .ps-toggle {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }

        .ps-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .ps-toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #1a1d23;
            transition: .4s;
            border-radius: 24px;
        }

        .ps-toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.ps-toggle-slider {
            background-color: #00e5ff;
        }

        input:checked+.ps-toggle-slider:before {
            transform: translateX(20px);
        }

        /* Forms Grid */
        .ps-forms-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .ps-form-card {
            background: #0c0e14;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1.5rem;
            padding: 2rem;
        }

        .ps-card-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 2rem;
        }

        .ps-form-group {
            margin-bottom: 1.5rem;
        }

        .ps-form-group label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 0.75rem;
        }

        .ps-form-group input {
            width: 100%;
            background: #080a0f;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.6rem;
            padding: 0.85rem 1rem;
            color: #fff;
            font-size: 0.9rem;
        }

        .ps-form-group input:focus {
            outline: none;
            border-color: #00e5ff;
            box-shadow: 0 0 0 3px rgba(0, 229, 255, 0.1);
        }

        .ps-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .ps-form-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 1rem;
        }

        /* Bottom Actions */
        .ps-bottom-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 2rem;
        }

        .btn-ps-cyan-large {
            background: #00e5ff;
            color: #0c0e14;
            border: none;
            padding: 1rem 3.5rem;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
        }

        @media (max-width: 1024px) {
            .ps-forms-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Swal Custom Overrides */
        .swal2-popup {
            border-radius: 1.5rem !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }
    </style>
@endsection
