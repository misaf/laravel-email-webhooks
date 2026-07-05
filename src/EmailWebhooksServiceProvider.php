<?php

declare(strict_types=1);

namespace Misaf\LaravelEmailWebhooks;

use Composer\InstalledVersions;
use Illuminate\Foundation\Console\AboutCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class EmailWebhooksServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-email-webhooks')
            ->hasConfigFile('email_webhooks');
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(EmailWebhooksManager::class);
        $this->app->alias(EmailWebhooksManager::class, 'email-webhooks');
    }

    public function packageBooted(): void
    {
        if ( ! $this->app->runningInConsole()) {
            return;
        }

        AboutCommand::add('Laravel Email Webhooks', fn(): array => [
            'Version'        => InstalledVersions::getPrettyVersion('misaf/laravel-email-webhooks') ?? 'Unknown',
            'Default Driver' => rescue(fn(): string => $this->app->make(EmailWebhooksManager::class)->getDefaultDriver(), 'Not configured', report: false),
        ]);
    }
}
