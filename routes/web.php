<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoanController;

/*
|--------------------------------------------------------------------------
| Web Routes (Jalur Akses)
|--------------------------------------------------------------------------
*/

// 1. HALAMAN PUBLIK (Bisa diakses tanpa login)
Route::get('/', function () {
    return view('welcome');
})->name('login'); // Halaman ini dianggap sebagai halaman login

// KATALOG SEKARANG JADI PUBLIK
Route::get('/catalog', [LoanController::class, 'index'])->name('loans.catalog');

// Route Login SSO
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// 2. HALAMAN KHUSUS MEMBER (Harus Login)
Route::middleware(['auth'])->group(function () {
    
   // Dashboard (Updated dengan Statistik)
    Route::get('/dashboard', function () {
        // 1. Data Statistik (Khusus Admin)
        $totalItems = \App\Models\Item::count();
        $activeLoans = \App\Models\Loan::where('status', 'approved')->count();
        $pendingLoans = \App\Models\Loan::where('status', 'pending')->count();
        $totalUsers = \App\Models\User::count();

        // 2. Data Personal (Khusus Mahasiswa)
        // Menghitung berapa peminjaman aktif milik user yang sedang login
        $myActiveLoans = \App\Models\Loan::where('user_id', Auth::id())
                                         ->where('status', 'approved')
                                         ->count();

        return view('dashboard', compact('totalItems', 'activeLoans', 'pendingLoans', 'totalUsers', 'myActiveLoans'));
    })->name('dashboard');

    // Fitur Peminjaman (Kecuali Katalog)
    Route::get('/loans/create/{item}', [LoanController::class, 'create'])->name('loans.create');
    Route::post('/loans/store/{item}', [LoanController::class, 'store'])->name('loans.store');
    Route::get('/my-loans', [LoanController::class, 'history'])->name('loans.history');

    // Fitur Admin Peminjaman
    Route::prefix('admin')->group(function () {
        Route::get('/loans', [LoanController::class, 'adminIndex'])->name('admin.loans');
        Route::patch('/loans/{loan}/approve', [LoanController::class, 'approve'])->name('admin.loans.approve');
        Route::patch('/loans/{loan}/reject', [LoanController::class, 'reject'])->name('admin.loans.reject');
        Route::patch('/loans/{loan}/return', [LoanController::class, 'complete'])->name('admin.loans.return');
    });

    // Fitur Admin Kelola Barang (Resource)
    Route::resource('items', ItemController::class);
});