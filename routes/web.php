<?php

use App\Http\Controllers\WebController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SampahController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RedeemController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangBekasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminSampahController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminRedeemController;
use App\Http\Controllers\AdminBarangBekasController;
use App\Http\Controllers\AdminProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;

// Public Routes
Route::get('/', [WebController::class, 'index'])->name('home');
Route::get('/login', [WebController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [WebController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // User Sampah Routes
    Route::resource('sampah', SampahController::class);
    
    // User Redeem Routes
    Route::get('/redeem', [RedeemController::class, 'index'])->name('redeem.index');
    Route::post('/redeem/{reward}/points', [RedeemController::class, 'redeem'])->name('redeem.points');

    // Barang Bekas Routes
    Route::resource('barang-bekas', BarangBekasController::class);
    Route::post('/barang-bekas/{barangBekas}/beli', [BarangBekasController::class, 'beli'])->name('barang-bekas.beli');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Admin Sampah Routes
        Route::resource('sampah', AdminSampahController::class);
        Route::put('/sampah/{sampah}/verify', [AdminSampahController::class, 'verify'])->name('sampah.verify');
        
        // Admin Users Routes
        Route::resource('users', AdminUserController::class);
        Route::put('/users/{user}/level', [AdminUserController::class, 'updateLevel'])->name('users.level.update');

        // Kelola Redeem
        Route::resource('redeem', AdminRedeemController::class);
        Route::put('redeem/{redeem}/status', [AdminRedeemController::class, 'updateStatus'])->name('redeem.update-status');

        // Kelola Barang Bekas
        Route::resource('barang-bekas', AdminBarangBekasController::class);

        // Profile routes
        Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile/update-password', [AdminProfileController::class, 'updatePassword'])->name('profile.update-password');
    });
});

// API Routes
Route::prefix('api')->group(function () {
    Route::get('/users', [ApiController::class, 'users']);
    Route::get('/sampah', [ApiController::class, 'sampahs']);
    Route::get('/barang-bekas', [ApiController::class, 'barangBekas']);
    Route::get('/redeem', [ApiController::class, 'redeems']);
});
