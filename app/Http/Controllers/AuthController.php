<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function showRegister()
    {
        return view('register');
    }

    
public function login(Request $request)
{
    $credentials = $request->validate([
        'username' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    $user = User::where('username', $credentials['username'])->first();

    if (!$user) {
        throw ValidationException::withMessages([
            'username' => 'Username atau password salah.',
        ]);
    }

    $storedPassword = (string) $user->password;
    $passwordInfo = password_get_info($storedPassword);

    if ($passwordInfo['algoName'] !== 'unknown') {
        $passwordValid = Hash::check(
            $credentials['password'],
            $storedPassword
        );
    } else {
        $passwordValid = hash_equals(
            $storedPassword,
            $credentials['password']
        );

        if ($passwordValid) {
            $user->password = Hash::make($credentials['password']);
            $user->save();
        }
    }

    if (!$passwordValid) {
        throw ValidationException::withMessages([
            'username' => 'Username atau password salah.',
        ]);
    }

if (!in_array($user->role, ['admin', 'kasir', 'siswa'], true)) {
    throw ValidationException::withMessages([
        'username' => 'Role akun tidak valid. Silakan hubungi administrator.',
    ]);
}

$request->session()->regenerate();

session([
    'user_id' => $user->id,
    'username' => $user->username,
    'role' => $user->role,
]);

if ($user->role === 'admin') {
    return redirect()->route('admin.dashboard');
}

if ($user->role === 'kasir') {
    return redirect()->route('kasir.dashboard');
}


if ($user->role === 'kasir') {
    return redirect()->route('kasir.dashboard');
}

return redirect()->route('siswa.dashboard');
}

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role' => 'siswa',
        ]);

        $request->session()->regenerate();

        session([
            'user_id' => $user->id,
            'username' => $user->username,
            'role' => $user->role,
        ]);

        return redirect()->route('siswa.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
