<?php

declare(strict_types=1);

namespace AiSdk\Moonshot;

use AiSdk\Contracts\BaseProvider;
use AiSdk\Contracts\TextModelInterface;
use AiSdk\Contracts\TextProviderInterface;
use AiSdk\Moonshot\Models\MoonshotTextModel;

final class MoonshotProvider extends BaseProvider implements TextProviderInterface
{
    public function __construct(public readonly MoonshotOptions $options) {}

    public function name(): string
    {
        return MoonshotOptions::PROVIDER_NAME;
    }

    protected function textModel(string $modelId): TextModelInterface
    {
        return new MoonshotTextModel($modelId, $this->options);
    }

}
