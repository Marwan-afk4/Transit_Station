<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('location', function ($user) {
            // foreach ($user->admin_position->role as $role) {
            //     if($role->role_name=='locations'){
            //         return true;
            //     }
                // return $role->role_name == 'locations';

                return $user->admin_position->role->pluck('role_name')->contains('locations');
        });

        Gate::define('parking', function ($user) {
            return $user->admin_position->role->pluck('role_name')->contains('parkings');
        });

        Gate::define('driver',function ($user){
            return $user->admin_position->role->pluck('role_name')->contains('drivers');
        });

        Gate::define('subscription',function ($user){
            return $user->admin_position->role->pluck('role_name')->contains('subscriptions');
        });

        Gate::define('request',function ($user){
            return $user->admin_position->role->pluck('role_name')->contains('requests');
        });

        Gate::define('revenue',function ($user){
            return $user->admin_position->role->pluck('role_name')->contains('revenues');
        });

        Gate::define('expence',function ($user){
            return $user->admin_position->role->pluck('role_name')->contains('expences');
        });

        Gate::define('plan',function ($user){
            return $user->admin_position->role->pluck('role_name')->contains('plans');
        });;

        Gate::define('offer',function ($user){
            return $user->admin_position->role->pluck('role_name')->contains('offers');
        });

        Gate::define('user',function ($user){
            return $user->admin_position->role->pluck('role_name')->contains('users');
        });

        Gate::define('admin',function ($user){
            return $user->admin_position->role->pluck('role_name')->contains('admins');
        });

        Gate::define('color',function($user){
            return $user->admin_position->role->pluck('role_name')->contains('colors');
        });
    }
}
