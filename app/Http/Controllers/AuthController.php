<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // 1. Arahkan user ke Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Google mengembalikan user ke sini
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Ambil domain email (contoh: student.ub.ac.id)
            $emailParts = explode('@', $googleUser->getEmail());
            $domain = end($emailParts);

            // Daftar domain yang diizinkan
            $allowedDomains = ['student.ub.ac.id', 'ub.ac.id'];

            // Cek apakah domain valid?
            if (!in_array($domain, $allowedDomains)) {
                return redirect('/')->with('error', 'Maaf, hanya email Universitas Brawijaya yang diperbolehkan!');
            }

            // Cari user berdasarkan email, atau buat baru jika belum ada
            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt('password_acak_karena_sso'), // Password dummy
                    // Default role 'student', nanti admin bisa ubah manual di database
                ]
            );

            // Login user tersebut
            Auth::login($user);

            // Redirect ke Dashboard (nanti kita buat)
            return redirect('/dashboard');

        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Gagal login dengan Google: ' . $e->getMessage());
        }
    }

    // 3. Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}