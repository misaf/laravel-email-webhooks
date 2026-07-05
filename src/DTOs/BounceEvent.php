<?php

declare(strict_types=1);

namespace Misaf\LaravelEmailWebhooks\DTOs;

class BounceEvent
{
    public const string TypePermanent = 'Permanent';

    public const string TypeTemporary = 'Temporary';

    /**
     * @return list<string>
     */
    public static function types(): array
    {
        return [
            self::TypePermanent,
            self::TypeTemporary,
        ];
    }

    /**
     * @param  string  $type  Bounce type ('Permanent', 'Temporary')
     * @param  string  $subType  Bounce sub-type (e.g., 'OnAccountSuppressionList')
     */
    public function __construct(
        public string $type,
        public string $message,
        public string $subType,
    ) {}

    /**
     * @param array{
     *   type: string,
     *   message: string,
     *   subType: string
     * } $data
     */
    public static function fromArray(array $data): static
    {
        return new static(
            type: $data['type'],
            message: $data['message'],
            subType: $data['subType'],
        );
    }

    /**
     * @return array{
     *   type: string,
     *   message: string,
     *   subType: string
     * }
     */
    public function toArray(): array
    {
        return [
            'type'    => $this->type,
            'message' => $this->message,
            'subType' => $this->subType,
        ];
    }
}
