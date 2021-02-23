<?php

namespace ServiceTime\Calendar\Services\Providers;

use ServiceTime\Calendar\Services\Providers\Clients\IProviderClient;
use ServiceTime\Calendar\Services\Providers\DTO\CreateRecordDTO;

/**
 * Провайдер данных расписания
 * Class ProviderService
 * @package ServiceTime\Calendar\Services\Providers
 */
class ProviderService
{
    private IProviderClient $client;

    public function __construct(IProviderClient $client)
    {
        $this->client = $client;
    }

    /**
     * Получить записи для процедуры
     * @param int $procedure_id
     * @param string $date_start
     * @param string $date_end
     * @return array
     */
    public function getRecordByProcedure(int $procedure_id, string $date_start, string $date_end): array
    {
        return $this->client->getRecordByProcedure($procedure_id, $date_start, $date_end);
    }

    /**
     * Создать запись
     * @param CreateRecordDTO $dto
     * @return array
     */
    public function createRecord(CreateRecordDTO $dto): array
    {
        return $this->client->createRecord($dto);
    }
}