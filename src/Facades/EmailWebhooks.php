<?php

declare(strict_types=1);

namespace Misaf\LaravelEmailWebhooks\Facades;

use Illuminate\Support\Facades\Facade;
use Misaf\LaravelEmailWebhooks\DTOs\EmailEvent;
use Misaf\LaravelEmailWebhooks\EmailWebhooksDriver;
use Misaf\LaravelEmailWebhooks\EmailWebhooksManager;

/**
 * @method static EmailEvent processEvent(array<string, mixed> $payload)
 *
 * @method static EmailWebhooksDriver driver(?string $driver = null)
 * @method static EmailWebhooksManager extend(string $driver, \Closure $callback)
 * @method static ?string getDefaultDriver()
 */
final class EmailWebhooks extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'email-webhooks';
    }
}
