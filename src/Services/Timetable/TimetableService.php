<?php

namespace ServiceTime\Calendar\Services\Timetable;

use Carbon\Carbon;
use ServiceTime\Calendar\Services\Providers\ProviderService;
use ServiceTime\Calendar\Services\Timetable\Handlers\CreateRecordHandler;

class TimetableService
{
    private ProviderService $providerService;
    private CreateRecordHandler $createRecordHandler;

    public function __construct(
        ProviderService $providerService,
        CreateRecordHandler $createRecordHandler
    )
    {
        $this->providerService = $providerService;
        $this->createRecordHandler = $createRecordHandler;
    }

    /**
     * Получить массив с записями для календаря с расписанием
     * @param int $procedure_id
     * @param string $date_start
     * @param string $date_end
     * @return array
     */
    public function getTimetableByProcedure(int $procedure_id, string $date_start, string $date_end)
    {
        return $this->providerService->getRecordByProcedure($procedure_id, $date_start, $date_end);
    }

    /**
     * Добавить новую запись
     * @param int $procedure_id
     * @param string $date_start
     * @param int $user_id
     * @return array
     */
    public function createRecordByProcedure(int $procedure_id, string $date_start, int $user_id): array
    {
        $date_start = Carbon::parse($date_start);
        return $this->createRecordHandler->handle($procedure_id, $date_start, $user_id);
    }
}