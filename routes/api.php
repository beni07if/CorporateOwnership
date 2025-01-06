<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'user_level:Premium'])->group(function () {
    Route::post('/landing-pages', [ProfileController::class, 'store']);
    Route::put('/landing-pages/{id}', [ProfileController::class, 'update']);
    Route::delete('/landing-pages/{id}', [ProfileController::class, 'destroy']);
});

// Contoh route dengan pembatasan level
Route::middleware(['auth:sanctum', 'user.level:1'])->group(function () {
    Route::get('/admin-only', [LandingPageController::class, 'adminData']); // Hanya Admin
});

Route::middleware(['auth:sanctum', 'user.level:2'])->group(function () {
    Route::get('/manager-only', [LandingPageController::class, 'managerData']); // Admin dan Manager
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Api for Corporate Profile 

// Grouping the routes with versioning (v1)
Route::prefix('v1')->group(function () {
    // Endpoint untuk landing pages
    Route::get('/landing-pages', [ProfileController::class, 'indexApi']); // Untuk API JSON
});

// Grouping the routes with versioning (v1)
// Endpoint untuk group yang membutuhkan autentikasi
Route::prefix('v1')->group(function () {
    // Endpoint untuk group yang membutuhkan autentikasi
    Route::middleware('auth:sanctum')->get('/group', [ProfileController::class, 'featureApi']);
});