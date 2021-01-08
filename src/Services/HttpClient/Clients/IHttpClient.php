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
     * @param string $url
     * @param array $params
     * @return array|null
     */
    public function get(string $url, array $params): array;
}