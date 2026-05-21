<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Show login form
    public function showLogin()
    {
        return view('autentikasi.login');
    }

    // Show admin login form
    public function showAdminLogin()
    {
        return view('autentikasi.login_admin');
    }



    public function showRegister()
    {
        return view('autentikasi.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'nullable|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email ?? null,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);



        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login untuk mulai memesan.');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginType => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'username' => 'Username atau kata sandi salah.',
        ])->withInput($request->only('username', 'remember'));
    }

    // Handle logout (Smart role-based redirection)
    public function logout(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user && $user->role === 'admin';

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect based on the role of the user who just logged out
        if ($isAdmin) {
            return redirect()->route('admin.login');
        }

        return redirect()->route('login');
    }

    // Keep individual routes but point them to the same smart method if needed
    public function adminLogout(Request $request)
    {
        return $this->logout($request);
    }

    // Redirect to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }
    

    // Handle Google Callback
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $query = User::where('google_id', $googleUser->id);
            if (!empty($googleUser->email)) {
                $query->orWhere('email', $googleUser->email);
            }
            $user = $query->first();

            if (!$user) {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->name,
                    'username' => 'user_' . Str::random(8),
                    'email' => $googleUser->email,
                    'phone' => '-',
                    'password' => Hash::make(Str::random(16)),
                    'role' => 'user',
                    'google_id' => $googleUser->id,
                ]);
            } else {
                // Update google_id and email if not set
                $updates = [];
                if (!$user->google_id) {
                    $updates['google_id'] = $googleUser->id;
                }
                if (!$user->email && $googleUser->email) {
                    $updates['email'] = $googleUser->email;
                }
                if (!empty($updates)) {
                    $user->update($updates);
                }
            }

            Auth::login($user);
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }
            return redirect()->intended(route('dashboard'));

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'username' => 'Gagal login dengan Google: ' . $e->getMessage()
            ]);
        }
    }
}
