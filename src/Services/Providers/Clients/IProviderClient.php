<?php

namespace ServiceTime\Calendar\Services\Providers\Clients;

use ServiceTime\Calendar\Services\Providers\DTO\CreateRecordDTO;

interface IProviderClient
{
    /**
     * Получить список записей для процедуры
     * @param int $procedure_id
     * @param string $date_start
     * @param string $date_end
     * @return array
     */
    public function getRecordByProcedure(int $procedure_id, string $date_start, string $date_end): array;

    /**
     * Создать новую запись
     * @param CreateRecordDTO $dto
     * @return array
     */
    public function createRecord(CreateRecordDTO $dto): array;
}