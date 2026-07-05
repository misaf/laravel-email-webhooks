<?php

declare(strict_types=1);

use Misaf\LaravelEmailWebhooks\Tests\Helpers\TestEmailEvent;

describe('EmailEvent', function (): void {
    it('handles bounce data correctly', function (): void {
        $eventData = TestEmailEvent::fromArray([
            'type'   => 'email.bounced',
            'bounce' => [
                'type'    => 'Permanent',
                'message' => 'Test bounce message',
                'subType' => 'General',
            ],
        ]);

        $bounce = $eventData->bounce;
        assert(null !== $bounce);

        expect($bounce->toArray())->toBe([
            'type'    => 'Permanent',
            'message' => 'Test bounce message',
            'subType' => 'General',
        ]);
    });

    it('handles events without bounce data', function (): void {
        $eventData = TestEmailEvent::fromArray([
            'type' => 'email.sent',
        ]);

        expect($eventData->bounce)->toBeNull();
    });

    it('identifies bounce kind from bounce type', function (string $bounceType, bool $isHardBounce, bool $isSoftBounce): void {
        $eventData = TestEmailEvent::fromArray([
            'type'   => 'email.bounced',
            'bounce' => [
                'type'    => $bounceType,
                'message' => 'Test bounce message',
                'subType' => 'General',
            ],
        ]);

        expect($eventData->isHardBounce())->toBe($isHardBounce);
        expect($eventData->isSoftBounce())->toBe($isSoftBounce);
    })->with([
        'hard bounce' => ['Permanent', true, false],
        'soft bounce' => ['Temporary', false, true],
    ]);

    it('correctly identifies complaints', function (): void {
        $eventData = TestEmailEvent::fromArray([
            'type' => 'email.complained',
        ]);

        expect($eventData->isComplaint())->toBeTrue();
    });

    it('converts to array correctly', function (): void {
        $eventData = TestEmailEvent::fromArray([
            'type'   => 'email.bounced',
            'bounce' => [
                'type'    => 'Permanent',
                'message' => 'Test bounce message',
                'subType' => 'General',
            ],
        ]);

        expect($eventData->toArray())->toMatchArray([
            'to'         => ['test@example.com'],
            'from'       => 'sender@example.com',
            'subject'    => 'Test Email',
            'email_id'   => 'test-email-123',
            'created_at' => '2024-01-01T12:00:00Z',
            'type'       => 'email.bounced',
            'provider'   => 'test-provider',
            'bounce'     => [
                'type'    => 'Permanent',
                'message' => 'Test bounce message',
                'subType' => 'General',
            ],
        ]);
    });

    it('handles multiple recipients correctly', function (): void {
        $recipients = ['primary@example.com', 'cc@example.com', 'bcc@example.com'];
        $eventData = TestEmailEvent::fromArray([
            'to'   => $recipients,
            'type' => 'email.sent',
        ]);

        expect($eventData->to)->toBe($recipients);
        expect($eventData->primaryRecipient())->toBe('primary@example.com');
    });

    it('throws when primary recipient is missing', function (): void {
        $eventData = TestEmailEvent::fromArray([
            'to' => [],
        ]);

        expect(fn() => $eventData->primaryRecipient())
            ->toThrow(InvalidArgumentException::class, 'Email event must have at least one recipient.');
    });

    it('stores original payload correctly', function (): void {
        $eventData = TestEmailEvent::fromArray([
            'original_payload' => ['test' => 'data'],
            'type'             => 'email.sent',
        ]);

        expect($eventData->originalPayload)->toBe(['test' => 'data']);
    });
});
