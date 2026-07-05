<?php

declare(strict_types=1);

namespace Misaf\LaravelEmailWebhooks\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Misaf\LaravelEmailWebhooks\DTOs\EmailEvent;

abstract class BaseEmail
{
    use Dispatchable;

    public function __construct(
        public readonly EmailEvent $eventData,
    ) {}
}
