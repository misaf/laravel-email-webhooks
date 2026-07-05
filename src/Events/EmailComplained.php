<?php

declare(strict_types=1);

namespace Misaf\LaravelEmailWebhooks\Events;

/**
 * Fired when a recipient complains about an email (spam report)
 */
final class EmailComplained extends BaseEmail {}
