<?php

namespace ServiceTime\Calendar\Services\HttpClient\Clients;

use GuzzleHttp\Client;

class GuzzleHttpClient implements IHttpClient
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function get(string $uri, array $params): array
    {
        $answer = $this->client->get($uri, [
            'query' => $params
        ]);

        return json_decode($answer->getBody()->getContents(), true);
    }
}