<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Event::listen(Login::class, function ($event) {
            if ($event->user->hasRole('superadmin')) {
                activity()
                    ->causedBy($event->user)
                    ->log('Superadmin logged in');
            }

            if ($event->user->hasRole('admin')) {
                activity()
                    ->causedBy($event->user)
                    ->log('Admin logged in');
            }

            if ($event->user->hasRole('student')) {
                activity()
                    ->causedBy($event->user)
                    ->log('Student logged in');
            }
        });

        Event::listen(Logout::class, function ($event) {
            if ($event->user->hasRole('superadmin')) {
                activity()
                    ->causedBy($event->user)
                    ->log('Superadmin logged out');
            }

            if ($event->user->hasRole('admin')) {
                activity()
                    ->causedBy($event->user)
                    ->log('Admin logged out');
            }

            if ($event->user->hasRole('student')) {
                activity()
                    ->causedBy($event->user)
                    ->log('Student logged out');
            }
        });
    }
}
