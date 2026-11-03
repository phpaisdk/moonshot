# PHP AI SDK — Moonshot AI

Text generation, streaming, reasoning, and tool calling with Kimi. Part of the framework-agnostic [PHP AI SDK](https://phpaisdk.com).

## Installation

```bash
composer require aisdk/moonshot
```

Set `MOONSHOT_API_KEY` in your environment.

## Usage

```php
use AiSdk\Generate;
use AiSdk\Moonshot;

$result = Generate::text('Explain closures in PHP in one sentence.')
    ->model(Moonshot::model('kimi-k3.1-pro'))
    ->run();

echo $result->text;
```

## Documentation

[Read the documentation](https://phpaisdk.com/docs/0.x/providers/moonshot) for configuration, supported features, and more examples.

[Contributing](https://github.com/phpaisdk/.github/blob/main/CONTRIBUTING.md) · [Support](https://github.com/phpaisdk/.github/blob/main/SUPPORT.md)

## License

The MIT License (MIT). See [LICENSE](LICENSE) for details.
