<?php

use App\Http\Controllers\Api\V1\ValuerMembershipController;
use App\Http\Controllers\Api\V1\AdminMembershipController;
use App\Http\Controllers\Api\V1\Admin\BankTypeController;
use App\Http\Controllers\Api\V1\BankMembershipController;
use App\Http\Controllers\Api\V1\MembershipController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Public Routes
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/join-us', [MembershipController::class, 'createRequest']);

    Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout']);

    // Admin Routes
    Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::apiResource('bank-types', BankTypeController::class);
        Route::get('/membership-requests', [AdminMembershipController::class, 'index']);
        Route::get('/membership-stats', [AdminMembershipController::class, 'stats']); // New stats endpoint
        Route::get('/membership-requests/{status}', [AdminMembershipController::class, 'requestsByStatus']); // Filtered by status
        Route::post('/membership/{id}/approve', [MembershipController::class, 'approve']);
        Route::post('/membership/{id}/reject', [MembershipController::class, 'reject']);
    });

    Route::prefix('bank')->middleware(['auth:sanctum', 'role:bank'])->group(function () {
        Route::get('/profile', [BankMembershipController::class, 'profile']);
        Route::get('/membership-requests', [BankMembershipController::class, 'index']);
        Route::get('/membership-stats', [BankMembershipController::class, 'stats']);
        Route::get('/membership-requests/{status}', [BankMembershipController::class, 'requestsByStatus']);
        // ... other routes
    });


    // Valuer Routes
    Route::prefix('valuer')->middleware(['auth:sanctum', 'role:valuer'])->group(function () {
        Route::get('/membership-requests', [ValuerMembershipController::class, 'index']);
        Route::post('/membership/{id}/approve', [MembershipController::class, 'approve']);
        Route::post('/membership/{id}/reject', [MembershipController::class, 'reject']);
        Route::prefix('{valuerOrg}')->group(function () {
            Route::post('/membership/{id}/approve', [MembershipController::class, 'approve']);
            Route::post('/membership/{id}/reject', [MembershipController::class, 'reject']);
        });
    });
});
