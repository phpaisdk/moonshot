# aisdk/moonshot

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

## Links

- [Moonshot API documentation](https://docs.moonshot.ai/)
- [Core Package](https://github.com/phpaisdk/core)
- [OpenAI-Compatible Package](https://github.com/phpaisdk/openai-compatible)
