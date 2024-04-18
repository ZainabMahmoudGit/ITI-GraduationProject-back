<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\User;
use App\Policies\OrderPolicy;
use App\Policies\UserPolicy;
use App\Policies\ServiceCenterPolicy;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        ServiceCenterPolicy::class => ServiceCenterPolicy::class,


        User::class => UserPolicy::class,
        Order::class=>OrderPolicy::class


        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

    }
}
