<?php

declare(strict_types=1);

namespace Misaf\LaravelEmailWebhooks\DTOs;

use InvalidArgumentException;

abstract class EmailEvent
{
    public const string TypeSent = 'email.sent';

    public const string TypeBounced = 'email.bounced';

    public const string TypeComplained = 'email.complained';

    public const string TypeFailed = 'email.failed';

    /**
     * @return list<string>
     */
    public static function types(): array
    {
        return [
            self::TypeSent,
            self::TypeBounced,
            self::TypeComplained,
            self::TypeFailed,
        ];
    }

    /**
     * @param  list<string>  $to  Recipient email addresses
     * @param  string  $from  Sender email address
     * @param  string  $subject  Email subject
     * @param  string  $emailId  Unique email ID from provider
     * @param  string  $createdAt  When the event occurred
     * @param  array<string, mixed>  $originalPayload  Original webhook payload
     * @param  string  $type  Event type ('email.sent', 'email.bounced', 'email.complained', 'email.failed')
     * @param  string  $provider  Provider name ('resend', etc.)
     * @param  BounceEvent|null  $bounce  Bounce data (can be BounceEvent, or null)
     */
    public function __construct(
        public array $to,
        public string $from,
        public string $subject,
        public string $emailId,
        public string $createdAt,
        public array $originalPayload,
        public string $type,
        public string $provider,
        public ?BounceEvent $bounce = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    abstract public static function fromArray(array $data): static;

    public function isHardBounce(): bool
    {
        return BounceEvent::TypePermanent === $this->bounce?->type;
    }

    public function isSoftBounce(): bool
    {
        return BounceEvent::TypeTemporary === $this->bounce?->type;
    }

    public function isComplaint(): bool
    {
        return self::TypeComplained === $this->type;
    }

    public function primaryRecipient(): string
    {
        return $this->to[0] ?? throw new InvalidArgumentException('Email event must have at least one recipient.');
    }

    /**
     * @return array{
     *   to: list<string>,
     *   from: string,
     *   subject: string,
     *   email_id: string,
     *   created_at: string,
     *   original_payload: array<string, mixed>,
     *   type: string,
     *   provider: string,
     *   bounce?: array{
     *     type: string,
     *     message: string,
     *     subType: string
     *   }|null,
     * } $payload
     */
    public function toArray(): array
    {
        return [
            'to'               => $this->to,
            'from'             => $this->from,
            'subject'          => $this->subject,
            'email_id'         => $this->emailId,
            'created_at'       => $this->createdAt,
            'original_payload' => $this->originalPayload,
            'type'             => $this->type,
            'provider'         => $this->provider,
            'bounce'           => $this->bounce?->toArray(),
        ];
    }
}
