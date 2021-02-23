<?php

namespace ServiceTime\Calendar\Services\HttpClient;

use ServiceTime\Calendar\Services\HttpClient\Clients\IHttpClient;

/**
 * Http client для удаленных запросов
 * Class HttpClientService
 * @package ServiceTime\Calendar\Services\HttpClient
 */
class HttpClientService
{
    private IHttpClient $client;

    public function __construct(IHttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * GET
     * @param string $url
     * @param array $params
     * @return array
     */
    public function get(string $url, array $params = [])
    {
        return $this->client->get($url, $params);
    }

    /**
     * POST
     * @param string $url
     * @param array $params
     * @return array
     */
    public function post(string $url, array $params = [])
    {
        return $this->client->post($url, $params);
    }
}