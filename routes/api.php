<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ViolationRuleController;
use App\Http\Controllers\API\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes
Route::post('login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // User info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Logout
    Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy']);
    
    // Violation Rules - Some endpoints restricted to Polantas
    Route::get('/violation-rules', [ViolationRuleController::class, 'index']);
    Route::get('/violation-rules/{id}', [ViolationRuleController::class, 'show']);
    
    Route::middleware(['role:Polantas'])->group(function () {
        Route::post('/violation-rules', [ViolationRuleController::class, 'store']);
        Route::put('/violation-rules/{id}', [ViolationRuleController::class, 'update']);
        Route::delete('/violation-rules/{id}', [ViolationRuleController::class, 'destroy']);
    });
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index']);
    Route::get('/reports/{id}', [ReportController::class, 'show']);
    Route::get('/reports-statistics', [ReportController::class, 'statistics']);
    
    // Pelapor can only create reports
    Route::middleware(['role:Pelapor'])->group(function () {
        Route::post('/reports', [ReportController::class, 'store']);
    });
    
    // Polantas can verify reports
    Route::middleware(['role:Polantas'])->group(function () {
        Route::post('/reports/{id}/verify', [ReportController::class, 'verify']);
    });
});
