## Laravel Email Webhooks

This package provides a provider-neutral core for Laravel email webhook integrations.

### Package Structure

- The main package classes live at the root namespace: `Misaf\LaravelEmailWebhooks\EmailWebhooksDriver`, `Misaf\LaravelEmailWebhooks\EmailWebhooksManager`, and `Misaf\LaravelEmailWebhooks\EmailWebhooksServiceProvider`.
- DTOs live in `Misaf\LaravelEmailWebhooks\DTOs`.
- Provider packages should extend `Misaf\LaravelEmailWebhooks\EmailWebhooksDriver`.
- Drivers must validate provider payloads before creating DTOs.
- `processEvent()` returns an `EmailEvent` directly after dispatching the Laravel event.
- Provider packages should return provider-specific concrete implementations of `EmailEvent` and `BounceEvent`.
- The package dispatches Laravel events for `email.sent`, `email.bounced`, `email.complained`, and `email.failed`.
- Event helpers such as `isHardBounce()`, `isSoftBounce()`, `isComplaint()`, and `primaryRecipient()` belong on the event DTO, not a service wrapper.
- Do not add generic `Services`, `Providers`, `Drivers`, or `Managers` folders unless the package grows enough to justify that structure.

### Testing

- Package tests use Pest with Orchestra Testbench.
- Use the shared `Misaf\LaravelEmailWebhooks\Tests\TestCase` for tests that need the Laravel application container.
- Keep provider-specific payload parsing in provider package tests, not in this core package.
- Keep Pint available through `require-dev` because CI runs `vendor/bin/pint --test`.
- Optional Pest plugins may be installed, but only add architecture/type/profanity rules when they are enforced by tests or CI.

### Compatibility

- This package targets PHP 8.3+.
- Keep Laravel framework access behind Illuminate contracts, facades, or Testbench-backed tests.
