<?php

namespace ServiceTime\Calendar\Services\Providers\Clients;

use ServiceTime\Calendar\Services\HttpClient\HttpClientService;
use ServiceTime\Calendar\Services\Providers\DTO\CreateRecordDTO;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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
        $result = $this->httpService->get($this->getAbsUrl("procedure", $procedure_id. '/record'), [
            'date_start' => $date_start,
            'date_end' => $date_end,
        ]);
        $this->checkResult($result);

        return $result['records'];
    }

    /**
     * Создать запись
     * @param CreateRecordDTO $dto
     * @return mixed
     */
    public function createRecord(CreateRecordDTO $dto): array
    {
        $result = $this->httpService->post($this->getAbsUrl("record"), $dto->toArray());
        $this->checkResult($result);

        return $result['record'];
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

    /**
     * Проверка на ошибки
     * @param array $result
     */
    private function checkResult(array $result)
    {
        if (isset($result['success']) && !$result['success']) {
            throw new BadRequestHttpException($result['message']);
        }

        if (isset($result['errors'])) {
            $inputs = [];
            foreach ($result['errors'] as $key => $errors) {
                $inputs[] = "\"$key\": ". implode("; ", $errors);
            }
            $inputs = implode("; \n\r", $inputs);

            throw new BadRequestHttpException($result['message'] . ' ['. $inputs . ']');
        }

        if (isset($result['message']) && isset($result['exception'])) {
            throw new BadRequestHttpException($result['exception'] . ': ' . $result['message']);
        }
    }
}