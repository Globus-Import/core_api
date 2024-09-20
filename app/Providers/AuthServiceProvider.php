<?php

namespace App\Providers;

use App\Models\Address;
use App\Policies\AddressPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    protected $policies = [
        Address::class => AddressPolicy::class,
    ];
}
