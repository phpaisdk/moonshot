<?php

declare(strict_types=1);

namespace AiSdk;

use AiSdk\Contracts\Model;
use AiSdk\Moonshot\MoonshotOptions;
use AiSdk\Moonshot\MoonshotProvider;

/**
 * Friendly facade for the Moonshot provider.
 *
 *   $model = Moonshot::model('kimi-k2.7-code');
 */
final class Moonshot
{
    private static ?MoonshotProvider $default = null;

    /**
     * @param  array<string, mixed>  $config
     */
    public static function create(array $config = []): MoonshotProvider
    {
        return self::$default = new MoonshotProvider(MoonshotOptions::fromArray($config));
    }

    public static function default(): MoonshotProvider
    {
        return self::$default ??= self::create();
    }

    public static function reset(): void
    {
        self::$default = null;
    }

    public static function model(string $modelId): Model
    {
        return self::default()->model($modelId);
    }
}
