<?php

declare(strict_types=1);

use AiSdk\Generate;
use AiSdk\Moonshot;
use AiSdk\Moonshot\Tests\Fakes\FakeHttpClient;
use AiSdk\Schema;
use AiSdk\Support\Sdk;

afterEach(function () {
    Generate::reset();
    Moonshot::reset();
});

function configureMoonshotWith(FakeHttpClient $client): void
{
    $factory = new \Nyholm\Psr7\Factory\Psr17Factory();
    Generate::configure(new Sdk(
        httpClient: $client,
        requestFactory: $factory,
        streamFactory: $factory,
    ));
}

it('generates text end to end through the Moonshot vertical', function () {
    $client = new FakeHttpClient(200, json_encode([
        'id' => 'chatcmpl_moonshot',
        'object' => 'chat.completion',
        'created' => 1710000000,
        'model' => 'kimi-k2.7-code',
        'system_fingerprint' => 'fp_moonshot',
        'choices' => [['index' => 0, 'message' => ['content' => 'Hello from Moonshot'], 'finish_reason' => 'stop']],
        'usage' => ['prompt_tokens' => 7, 'completion_tokens' => 3],
    ]));
    configureMoonshotWith($client);

    Moonshot::create(['apiKey' => 'moonshot-test']);

    $result = Generate::text('Hi')->model(Moonshot::model('kimi-k2.7-code'))->run();

    expect($result->text)->toBe('Hello from Moonshot')
        ->and($result->usage->inputTokens)->toBe(7)
        ->and($result->providerMetadata['moonshot']['id'])->toBe('chatcmpl_moonshot')
        ->and($result->providerMetadata['moonshot']['model'])->toBe('kimi-k2.7-code')
        ->and($result->providerMetadata['moonshot']['choice_finish_reason'])->toBe('stop');

    $body = $client->sentBody();
    expect($body['model'])->toBe('kimi-k2.7-code')
        ->and($body['messages'][0]['role'])->toBe('user')
        ->and($body['stream'])->toBeFalse();

    expect($client->lastRequest->getHeaderLine('Authorization'))->toBe('Bearer moonshot-test');
});

it('normalizes provider-neutral text usage fields', function () {
    $client = new FakeHttpClient(200, json_encode([
        'choices' => [['index' => 0, 'message' => ['content' => 'Hello from Moonshot'], 'finish_reason' => 'stop']],
        'usage' => ['input_tokens' => 13, 'output_tokens' => 6, 'total_tokens' => 19],
    ]));
    configureMoonshotWith($client);

    Moonshot::create(['apiKey' => 'moonshot-test']);

    $result = Generate::text('Hi')->model(Moonshot::model('kimi-k2.7-code'))->run();

    expect($result->usage->inputTokens)->toBe(13)
        ->and($result->usage->outputTokens)->toBe(6)
        ->and($result->usage->totalTokens)->toBe(19);
});

it('maps a 429 to a rate limit exception', function () {
    $client = new FakeHttpClient(429, json_encode(['error' => ['message' => 'slow down']]));
    configureMoonshotWith($client);
    Moonshot::create(['apiKey' => 'moonshot-test']);

    Generate::text('Hi')->model(Moonshot::model('kimi-k2.7-code'))->run();
})->throws(\AiSdk\Exceptions\RateLimitException::class);

it('falls back to json_object structured output for models without json_schema support', function () {
    $client = new FakeHttpClient(200, json_encode([
        'choices' => [['message' => ['content' => '{"city":"Lahore","country":"Pakistan"}'], 'finish_reason' => 'stop']],
        'usage' => ['prompt_tokens' => 10, 'completion_tokens' => 7],
    ]));
    configureMoonshotWith($client);
    Moonshot::create(['apiKey' => 'moonshot-test']);

    $result = Generate::text('Extract the city and country from: Lahore, Pakistan.')
        ->model(Moonshot::model('moonshot-small-latest'))
        ->output(Schema::object(
            name: 'address',
            properties: [
                Schema::string(name: 'city')->required(),
                Schema::string(name: 'country')->required(),
            ],
        ))
        ->run();

    $body = $client->sentBody();

    expect($body['response_format'])->toBe(['type' => 'json_object'])
        ->and($body['messages'][0]['role'])->toBe('system')
        ->and($body['messages'][0]['content'])->toContain('valid JSON object')
        ->and($result->output)->toBe(['city' => 'Lahore', 'country' => 'Pakistan']);
});

it('accepts opaque text model ids without a model inventory', function () {
    Moonshot::create(['apiKey' => 'moonshot-test']);

    expect(Moonshot::model('future-private-model')->modelId())->toBe('future-private-model');
});
