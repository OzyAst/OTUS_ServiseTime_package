<?php

namespace ServiceTime\Calendar\Services\HttpClient\Clients;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class GuzzleHttpClient implements IHttpClient
{
    private PendingRequest $client;

    public function __construct()
    {
        $this->client = Http::withToken(config('serviceTimeConfig.api_token'))
            ->acceptJson();
    }

    public function get(string $uri, array $params): array
    {
        $request = $this->client->get($uri);
        return $request->json();
    }
}