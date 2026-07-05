<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Misaf\LaravelEmailWebhooks\Facades\EmailWebhooks;
use Misaf\LaravelEmailWebhooks\Tests\Helpers\TestEmailEvent;

beforeEach(function (): void {
    Event::fake();
});

describe('Email Webhook Integration', function (): void {
    it('can process email events through the complete workflow', function (): void {
        $eventData = TestEmailEvent::fromArray([
            'type'   => 'email.bounced',
            'bounce' => [
                'type'    => 'Permanent',
                'message' => 'Test bounce message',
                'subType' => 'General',
            ],
        ]);

        expect($eventData->isHardBounce())->toBeTrue();
        expect($eventData->primaryRecipient())->toBe('test@example.com');
    });

    it('can handle the :dataset event type', function (string $eventType, bool $shouldBeBounce): void {
        $payload = ['type' => $eventType];

        if ('email.bounced' === $eventType) {
            $payload['bounce'] = [
                'type'    => 'Permanent',
                'message' => 'Test bounce message',
                'subType' => 'General',
            ];
        }

        expect(TestEmailEvent::fromArray($payload)->isHardBounce())->toBe($shouldBeBounce);
    })->with([
        'sent'       => ['email.sent', false],
        'bounced'    => ['email.bounced', true],
        'complained' => ['email.complained', false],
    ]);

    it('can retrieve default driver configuration', function (): void {
        config(['services.email-webhooks.default_provider' => 'test-provider']);

        expect(EmailWebhooks::getDefaultDriver())->toBe('test-provider');
    });
});
