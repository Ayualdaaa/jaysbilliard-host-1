<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('dashboard_admin.akun.index', compact('users'));
    }

    public function create()
    {
        return view('dashboard_admin.akun.buat_akun');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.akun.index')->with('success', 'Akun berhasil ditambahkan!');
    }

    public function edit(User $akun)
    {
        return view('dashboard_admin.akun.edit_akun', ['user' => $akun]);
    }

    public function update(Request $request, User $akun)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($akun->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($akun->id)],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,user',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $updateData['password'] = Hash::make($request->password);
        }

        $akun->update($updateData);

        return redirect()->route('admin.akun.index')->with('success', 'Akun berhasil diperbarui!');
    }

    public function destroy(User $akun)
    {
        if ($akun->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $akun->delete();
        return redirect()->route('admin.akun.index')->with('success', 'Akun berhasil dihapus!');
    }
}
