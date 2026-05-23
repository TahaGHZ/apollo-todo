<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//imports for email verification message customization
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

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
        // Customizing the email verification message
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verify your Apollo Todo email address')
                ->greeting('Welcome to Apollo Todo!')
                ->line('Please verify your email address before continuing.')
                ->action('Verify Email Address', $url)
                ->line('If you did not create this account, no action is required.');
        });

    }
}
