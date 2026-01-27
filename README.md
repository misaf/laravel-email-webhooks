# Laravel Email Webhooks

**Core package for handling email webhook events in Laravel applications.**

## Features

- Easily handle incoming email webhook events.
- Built for Laravel 10+.
- Simple integration with your Laravel application.
- Fully tested with Pest and Orchestra Testbench.

## Requirements

- PHP ^8.3
- Laravel 10+

## Installation

You can install the package via Composer:

```bash
composer require misaf/laravel-email-webhooks

Usage

Publish the service provider (if you need to customize):

php artisan vendor:publish --provider="Misaf\EmailWebhooks\Providers\EmailWebhooksServiceProvider"


Handle webhook events by creating your own controllers or using the provided routes:

use Misaf\EmailWebhooks\Facades\EmailWebhooks;

EmailWebhooks::listen('event-name', function ($payload) {
    // Handle the event
});


Configure the webhook routes in your routes/web.php or routes/api.php if needed:

Route::post('/email/webhook', [\Misaf\EmailWebhooks\Controllers\WebhookController::class, 'handle']);

Testing

The package uses Pest
 and Orchestra Testbench
 for testing:

composer test

Contributing

Feel free to submit issues or pull requests. All contributions are welcome!

License

This package is open-sourced under the MIT license.