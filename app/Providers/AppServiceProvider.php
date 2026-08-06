<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('studioSettings', [
                'name' => Setting::get('studio_name', 'Studio Foto Booking'),
                'address' => Setting::get('studio_address', ''),
                'phone' => Setting::get('studio_phone', ''),
                'email' => Setting::get('studio_email', ''),
                'logo' => Setting::get('studio_logo', ''),
            ]);
        });
    }
}
