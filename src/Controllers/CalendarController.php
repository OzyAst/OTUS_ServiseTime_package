<?php

namespace ServiceTime\Calendar\Controllers;

use Illuminate\Routing\Controller;
use ServiceTime\Calendar\Requests\Timetable\DateParamsRequest;
use ServiceTime\Calendar\Services\Timetable\TimetableService;

class CalendarController extends Controller
{
    private TimetableService $service;

    public function __construct(TimetableService $service)
    {
        $this->service = $service;
    }

    /**
     * Получить расписание для процедуры
     * @param $procedure_id
     * @param DateParamsRequest $request
     * @return array
     */
    public function timetable($procedure_id, DateParamsRequest $request)
    {
        $date = $request->getFormData();
        $events = $this->service->getTimetableByProcedure($procedure_id, $date['date_start'], $date['date_end']);
        return ['status' => 1, "events" => $events];
    }
}