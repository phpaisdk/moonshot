<?php

declare(strict_types=1);

use AiSdk\Generate;
use AiSdk\Moonshot;

afterEach(function () {
    Generate::reset();
    Moonshot::reset();
});

it('uses adapter capabilities for opaque Moonshot model ids', function () {
    Moonshot::create(['apiKey' => 'moonshot-test']);
    $model = Moonshot::model('vendor/private-model');

    expect($model->modelId())->toBe('vendor/private-model');
});
