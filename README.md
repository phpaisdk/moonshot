# aisdk/moonshot

<a href="https://github.com/phpaisdk/moonshot/actions"><img alt="GitHub Workflow Status" src="https://img.shields.io/github/actions/workflow/status/phpaisdk/moonshot/tests.yml?branch=main&label=Tests"></a>
<a href="https://packagist.org/packages/aisdk/moonshot"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/aisdk/moonshot"></a>
<a href="https://packagist.org/packages/aisdk/moonshot"><img alt="Latest Version" src="https://img.shields.io/packagist/v/aisdk/moonshot"></a>
<a href="https://packagist.org/packages/aisdk/moonshot"><img alt="License" src="https://img.shields.io/packagist/l/aisdk/moonshot"></a>
<a href="https://whyphp.dev"><img src="https://img.shields.io/badge/Why_PHP-in_2026-7A86E8?style=flat-square&labelColor=18181b" alt="Why PHP in 2026"></a>

------

Official Moonshot provider for the PHP AI SDK. Uses Moonshot's Chat Completions API.

## Installation

```bash
composer require aisdk/moonshot
```

## Basic Usage

```php
use AiSdk\Generate;
use AiSdk\Moonshot;

$result = Generate::text('What happened in technology today?')
    ->model(Moonshot::model('kimi-k2.7-code'))
    ->run();

echo $result->text;
```

## Configuration

| Variable | Description | Default |
|---|---|---|
| `MOONSHOT_API_KEY` | API key for authentication | Required |
| `MOONSHOT_BASE_URL` | Base URL for API requests | `https://api.moonshot.ai` |

## Supported Capabilities

| Capability | Support |
|---|---|
| Text generation | Native |
| Streaming | Native |
| Tool calling | Native |
| Structured output | Adapted (`json_object` with an explicit JSON instruction) |
| Text input | Native |

Provider-specific fields can be passed through `providerOptions('moonshot', [...])`. Model IDs are opaque strings and Moonshot remains the authority on model availability.

## Testing

```bash
composer test:all
```

## Documentation

- [PHP AI SDK documentation](https://phpaisdk.com/docs)
- [Moonshot AI documentation](https://phpaisdk.com/docs/moonshot)

## Community

- [Contributing](https://github.com/phpaisdk/.github/blob/main/CONTRIBUTING.md)
- [Support](https://github.com/phpaisdk/.github/blob/main/SUPPORT.md)
- For private security reports, email [security@phpaisdk.com](mailto:security@phpaisdk.com).
