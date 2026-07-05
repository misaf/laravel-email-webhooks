<?php

declare(strict_types=1);

namespace Misaf\LaravelEmailWebhooks;

use Illuminate\Support\Manager;
use InvalidArgumentException;

final class EmailWebhooksManager extends Manager
{
    public function getDefaultDriver(): string
    {
        $driver = $this->config->get('services.email-webhooks.default_provider');

        if ( ! is_string($driver)) {
            throw new InvalidArgumentException('Please set services.email-webhooks.default_provider in your config.');
        }

        return $driver;
    }

    /**
     * @param string $driver
     */
    protected function createDriver($driver): mixed
    {
        $driverInstance = parent::createDriver($driver);

        if ($driverInstance instanceof EmailWebhooksDriver) {
            $driverInstance->setDriverName($driver);
        }

        return $driverInstance;
    }
}
