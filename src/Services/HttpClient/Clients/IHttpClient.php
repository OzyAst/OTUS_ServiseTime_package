<?php

namespace ServiceTime\Calendar\Services\HttpClient\Clients;

/**
 * TODO: обработчик ошибок и возврат одного определенный эксепшна для всех клиентов
 * Interface IHttpClient
 * @package ServiceTime\Calendar\Services\HttpClient\Clients
 */
interface IHttpClient
{
    /**
     * get запрос
     * @param string $uri
     * @param array $params
     * @return array|null
     */
    public function get(string $uri, array $params): array;

    /**
     * post запрос
     * @param string $uri
     * @param array $params
     * @return array
     */
    public function post(string $uri, array $params): array;
}