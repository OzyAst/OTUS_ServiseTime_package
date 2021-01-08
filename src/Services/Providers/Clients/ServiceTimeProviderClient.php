<?php

namespace ServiceTime\Calendar\Services\Providers\Clients;

use ServiceTime\Calendar\Services\HttpClient\HttpClientService;

class ServiceTimeProviderClient implements IProviderClient
{
    private HttpClientService $httpService;
    private string $url;

    public function __construct(HttpClientService $httpService)
    {
        $this->httpService = $httpService;
        $this->url = config('serviceTimeConfig.url_provider');
    }

    /**
     * Получить список записей
     * @param int $procedure_id
     * @param string $date_start
     * @param string $date_end
     * @return array
     */
    public function getRecordByProcedure(int $procedure_id, string $date_start, string $date_end): array
    {
        $records = $this->httpService->get($this->getAbsUrl("timetable", $procedure_id), [
            'date_start' => $date_start,
            'date_end' => $date_end,
        ]);

        return $records;
    }

    /**
     * Абсолютный урл
     * @param string $controller
     * @param string $action
     * @return string
     */
    private function getAbsUrl(string $controller, string $action = '')
    {
        $action = $action ? '/' . $action : '';
        return $this->url . '/' . $controller . $action;
    }
}