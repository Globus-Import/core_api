<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class AuthLogger
{
    public static function logLogin($user)
    {
        Log::channel('auth')->info('User logged in', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => request()->ip(),
        ]);
    }

    public static function logLogout($user)
    {
        Log::channel('auth')->info('User logged out', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => request()->ip(),
        ]);
    }

    public static function logPasswordReset($user)
    {
        Log::channel('auth')->info('Password reset', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => request()->ip(),
        ]);
    }

    // Ajoutez d'autres méthodes de logging selon vos besoins
}
