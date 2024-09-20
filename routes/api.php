<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RolePermissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/generate-otp', [AuthController::class, 'generateOtp']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('addresses', AddressController::class);
    Route::post('addresses/{address}/set-primary', [AddressController::class, 'setPrimary']);
});

Route::middleware(['auth:sanctum', 'permission:manage_roles_permissions'])->group(function () {
    Route::post('users/{user}/assign-role', [RolePermissionController::class, 'assignRole']);
    Route::post('users/{user}/assign-permissions', [RolePermissionController::class, 'assignPermission']);
    Route::get('users/{user}/roles-permissions', [RolePermissionController::class, 'getUserRolesAndPermissions']);
    Route::post('roles', [RolePermissionController::class, 'createRole']);
    Route::post('permissions', [RolePermissionController::class, 'createPermission']);
});


Route::middleware(['auth:sanctum', 'throttle:6,1'])->group(function () {
    Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail']);
    Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed'])
        ->name('verification.verify');
});

Route::post('forgot-password', [PasswordResetController::class, 'forgotPassword']);
Route::post('reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.reset');
