<?php

namespace ServiceTime\Calendar\Services\Timetable;

use ServiceTime\Calendar\Services\Providers\ProviderService;
use ServiceTime\Calendar\Services\Timetable\DTO\FullCalendarDTO;

class TimetableService
{
    private ProviderService $providerService;

    public function __construct(ProviderService $providerService)
    {
        $this->providerService = $providerService;
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
        $records = $this->providerService->getRecordByProcedure($procedure_id, $date_start, $date_end);
        foreach ($records as $record) {
            $timetable[] = (new FullCalendarDTO(
                $record['procedure']['name'],
                $record['date_start'],
                $record['date_end']
            ))->toArray();
        }

        return $timetable ?? [];
    }
}