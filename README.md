# Laravel Email Webhooks

Provider-neutral Laravel 13 package for parsing email webhook payloads into DTOs and dispatching Laravel events.

## Requirements

- PHP 8.4+
- Laravel 13

## Installation

```bash
composer require misaf/laravel-email-webhooks
```

The service provider is auto-discovered by Laravel.

## Usage

Create a provider driver by extending `Misaf\LaravelEmailWebhooks\EmailWebhooksDriver`, then register it with the manager:

```php
use Misaf\LaravelEmailWebhooks\Facades\EmailWebhooks;
use Vendor\Package\ProviderEmailWebhooksDriver;

EmailWebhooks::extend('provider', fn ($app) => $app->make(ProviderEmailWebhooksDriver::class));
```

Process a validated provider payload through the configured driver:

```php
use Misaf\LaravelEmailWebhooks\Facades\EmailWebhooks;

$eventData = EmailWebhooks::driver('provider')->processEvent($payload);
```

The package dispatches these Laravel events:

- `Misaf\LaravelEmailWebhooks\Events\EmailSent`
- `Misaf\LaravelEmailWebhooks\Events\EmailBounced`
- `Misaf\LaravelEmailWebhooks\Events\EmailComplained`
- `Misaf\LaravelEmailWebhooks\Events\EmailFailed`

## Testing

```bash
composer test
```
