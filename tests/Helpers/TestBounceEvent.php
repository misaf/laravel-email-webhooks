<?php

declare(strict_types=1);

namespace Misaf\LaravelEmailWebhooks\Tests\Helpers;

use Misaf\LaravelEmailWebhooks\DTOs\BounceEvent;

final class TestBounceEvent extends BounceEvent
{
    /**
     * @param array{
     *   type?: string,
     *   message?: string,
     *   subType?: string
     * } $data
     */
    public static function fromArray(array $data): static
    {
        return new self(
            type: $data['type'] ?? self::TypePermanent,
            message: $data['message'] ?? 'Test bounce message',
            subType: $data['subType'] ?? 'General',
        );
    }
}
