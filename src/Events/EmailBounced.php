<?php

declare(strict_types=1);

namespace Misaf\LaravelEmailWebhooks\Events;

/**
 * Fired when an email bounces (hard or soft bounce)
 */
final class EmailBounced extends BaseEmail {}
