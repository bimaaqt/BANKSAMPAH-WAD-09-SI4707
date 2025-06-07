<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\AuthApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Unauthorized default route
Route::get('/login', function (Request $request) {
    return response()->json(['message' => 'Unauthorized'], 401);
});

// Authentication Routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

// Simple API Routes
Route::prefix('api')->group(function () {
    Route::get('/users', [ApiController::class, 'users']);
    Route::get('/sampah', [ApiController::class, 'sampahs']);
    Route::get('/barang-bekas', [ApiController::class, 'barangBekas']);
    Route::get('/redeem', [ApiController::class, 'redeems']);
});

Route::get('users', [ApiController::class, 'users']);
Route::get('sampah', [ApiController::class, 'sampahs']);
Route::get('barang-bekas', [ApiController::class, 'barangBekas']);
Route::get('redeem', [ApiController::class, 'redeems']);

// API Routes
Route::get('/api/users', [ApiController::class, 'users']);
Route::get('/api/sampah', [ApiController::class, 'sampahs']);
Route::get('/api/barang-bekas', [ApiController::class, 'barangBekas']);
Route::get('/api/redeem', [ApiController::class, 'redeems']);

// Auth Routes
Route::post('/auth/login', [AuthApiController::class, 'login']);
Route::post('/auth/register', [AuthApiController::class, 'register']);

// Protected API Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthApiController::class, 'logout']);
    Route::get('/users', [ApiController::class, 'users']);
    Route::get('/sampah', [ApiController::class, 'sampahs']);
    Route::get('/barang-bekas', [ApiController::class, 'barangBekas']);
    Route::get('/redeem', [ApiController::class, 'redeems']);
}); 