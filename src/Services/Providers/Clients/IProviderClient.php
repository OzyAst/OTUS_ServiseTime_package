<?php

namespace ServiceTime\Calendar\Services\Providers\Clients;

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
}