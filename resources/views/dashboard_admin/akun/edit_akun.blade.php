<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Akun — Jay's Billiard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/css_layout/app_admin.css') }}">
    
    <style>
        .adm-form-card {
            background: #111418;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 2.5rem;
            max-width: 800px;
            margin: 0 auto;
        }

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
            border-color: #00e5ff;
            background: rgba(0, 229, 255, 0.02);
            box-shadow: 0 0 15px rgba(0, 229, 255, 0.1);
        }

        .is-invalid {
            border-color: #ff3b3b !important;
            background: rgba(255, 59, 59, 0.05) !important;
        }
        .invalid-feedback {
            color: #ff3b3b;
            font-size: 0.75rem;
            font-weight: 700;
            margin-top: 0.25rem;
        }

        /* Custom Radio for Role */
        .role-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .role-opt {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 1rem 1.25rem;
            background: #080a0f;
            border: 1.5px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .role-opt input { display: none; }
        .role-opt .icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.4); }
        .role-opt .text { display: flex; flex-direction: column; }
        .role-opt .text strong { font-size: 0.95rem; font-weight: 800; color: #fff; }
        .role-opt .text span { font-size: 0.7rem; color: rgba(255,255,255,0.4); margin-top: 2px; }

        .role-opt:has(input:checked) {
            border-color: #00e5ff;
            background: rgba(0, 229, 255, 0.05);
        }
        .role-opt:has(input:checked) .icon {
            background: #00e5ff;
            color: #000;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1.5rem;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        .btn-update {
            background: #00e5ff;
            color: #000;
            border: none;
            padding: 1rem 3rem;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 900;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(0, 229, 255, 0.2);
            transition: all 0.2s;
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
            transition: all 0.2s;
        }

        .btn-update:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0, 229, 255, 0.3); }
        .btn-cancel:hover { background: rgba(255,255,255,0.05); color: #fff; }

        .password-info {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.4);
            margin-bottom: 0.5rem;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .form-row, .role-options { grid-template-columns: 1fr; gap: 1rem; }
            .form-actions { flex-direction: column-reverse; gap: 1rem; }
            .btn-update, .btn-cancel { width: 100%; text-align: center; box-sizing: border-box; }
        }
    </style>
</head>
<body>
    <div class="adm-layout">
        @include('component.c_dashboard.sidebar.sidebar_admin')

        <main class="adm-main">
            @include('component.c_dashboard.topbar.topbar', [
                'topbar_title' => 'Edit Akun',
                'topbar_sub' => 'Ubah detail profil dan role pengguna'
            ])

            <div class="adm-content">
                <div class="adm-breadcrumb" style="margin-bottom: 2rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; font-weight: 700; color: rgba(255,255,255,0.4);">
                    <a href="{{ route('admin.akun.index') }}" style="color: #00e5ff; text-decoration: none;">Kelola Akun</a>
                    <span>•</span>
                    <span style="color: #fff;">Edit Akun</span>
                </div>

                <div class="adm-form-card">
                    <form action="{{ route('admin.akun.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-input @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-input @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}" required>
                                @error('username') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Alamat Email</label>
                                <input type="email" name="email" class="form-input @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text" name="phone" class="form-input @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                                @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div style="margin-top: 2.5rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.05);">
                            <div class="password-info">
                                * Biarkan kosong jika tidak ingin mengubah kata sandi.
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Kata Sandi Baru (Opsional)</label>
                                    <input type="password" name="password" class="form-input @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter">
                                    @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Konfirmasi Kata Sandi Baru</label>
                                    <input type="password" name="password_confirmation" class="form-input" placeholder="Ketik ulang password">
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 2.5rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.05);">
                            <label class="form-label">Hak Akses (Role)</label>
                            @if(auth()->id() === $user->id)
                                <div style="color: #00e5ff; font-size: 0.85rem; font-weight: 700; margin-bottom: 0.5rem;">
                                    * Anda tidak dapat mengubah role Anda sendiri.
                                </div>
                                <input type="hidden" name="role" value="{{ $user->role }}">
                            @endif
                            <div class="role-options" @if(auth()->id() === $user->id) style="opacity: 0.6; pointer-events: none;" @endif>
                                <label class="role-opt">
                                    <input type="radio" name="role" value="user" {{ (old('role', $user->role) === 'user') ? 'checked' : '' }}>
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    </div>
                                    <div class="text">
                                        <strong>Reguler User</strong>
                                        <span>Pelanggan biasa (booking meja & FnB)</span>
                                    </div>
                                </label>
                                <label class="role-opt">
                                    <input type="radio" name="role" value="admin" {{ (old('role', $user->role) === 'admin') ? 'checked' : '' }}>
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/><path d="m9 12 2 2 4-4"/></svg>
                                    </div>
                                    <div class="text">
                                        <strong>Administrator</strong>
                                        <span>Akses penuh ke dashboard admin</span>
                                    </div>
                                </label>
                            </div>
                            @error('role') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('admin.akun.index') }}" class="btn-cancel">BATAL</a>
                            <button type="submit" class="btn-update">SIMPAN PERUBAHAN</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    {{-- Logout Modal --}}
    @include('component.c_dashboard.modal.logout_modal')
    <script src="{{ asset('js/js_component/logout.js') }}"></script>
</body>
</html>
