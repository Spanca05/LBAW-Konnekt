<?php

namespace App\Providers;

use App\Models\Notification;
use App\Observers\NotificationObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        Notification::observe(NotificationObserver::class);

        View::composer('*', function ($view) {
            $unreadNotifications = 0;
            if (Auth::check()) {
                $unreadNotifications = Auth::user()->notifications()
                    ->wherePivot('seen', false)
                    ->count();
            }
            $view->with('unreadNotifications', $unreadNotifications);
        });
    }
}
