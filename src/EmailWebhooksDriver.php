<?php

declare(strict_types=1);

namespace Misaf\LaravelEmailWebhooks;

use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use LogicException;
use Misaf\LaravelEmailWebhooks\DTOs\EmailEvent;
use Misaf\LaravelEmailWebhooks\Events\EmailBounced;
use Misaf\LaravelEmailWebhooks\Events\EmailComplained;
use Misaf\LaravelEmailWebhooks\Events\EmailFailed;
use Misaf\LaravelEmailWebhooks\Events\EmailSent;

abstract class EmailWebhooksDriver
{
    private ?string $driverName = null;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function processEvent(array $payload): EmailEvent
    {
        $validatedPayload = $this->validatePayload($payload);
        $eventData = $this->createEventFromPayload($validatedPayload);
        $this->dispatchEvent($eventData);

        return $eventData;
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    abstract protected function validatePayload(array $payload): array;

    /**
     * @param  array<string, mixed>  $payload
     */
    abstract protected function createEventFromPayload(array $payload): EmailEvent;

    private function dispatchEvent(EmailEvent $eventData): void
    {
        match ($eventData->type) {
            EmailEvent::TypeSent          => event(new EmailSent($eventData)),
            EmailEvent::TypeBounced       => event(new EmailBounced($eventData)),
            EmailEvent::TypeComplained    => event(new EmailComplained($eventData)),
            EmailEvent::TypeFailed        => event(new EmailFailed($eventData)),
            default                       => throw new InvalidArgumentException("Unsupported email event type: {$eventData->type}"),
        };
    }

    /**
     * The driver name, set from the registration key by the manager unless overridden.
     */
    protected function driverName(): string
    {
        if (null === $this->driverName) {
            throw new LogicException(sprintf('Driver [%s] has no name. Resolve it through the Email Webhooks manager or override driverName().', static::class));
        }

        return $this->driverName;
    }

    protected function driverConfig(string $key, string $default = ''): string
    {
        return Config::string("services.{$this->driverName()}.{$key}", $default);
    }

    final public function setDriverName(string $driverName): void
    {
        $this->driverName = $driverName;
    }
}
