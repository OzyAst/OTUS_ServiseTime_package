<?php

namespace ServiceTime\Calendar\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use ServiceTime\Calendar\Requests\StoreRecordRequest;
use ServiceTime\Calendar\Requests\Timetable\DateParamsRequest;
use ServiceTime\Calendar\Services\Timetable\TimetableService;
use ServiceTime\Calendar\Services\Translators\TranslatorService;

class CalendarController extends Controller
{
    private TimetableService $timetableService;
    private TranslatorService $translatorService;

    public function __construct(
        TimetableService $timetableService,
        TranslatorService $translatorService
    )
    {
        $this->timetableService = $timetableService;
        $this->translatorService = $translatorService;
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
        $records = $this->timetableService->getTimetableByProcedure($procedure_id, $date['date_start'], $date['date_end']);
        $events = $this->translatorService->translateRecordsForCalendar($records);
        return ['status' => 1, "events" => $events];
    }

    /**
     * Добавить новую запись
     * @param $procedure_id
     * @param StoreRecordRequest $request
     * @return array
     */
    public function store($procedure_id, StoreRecordRequest $request)
    {
        try {
            $date = $request->getFormData();
            $record = $this->timetableService->createRecordByProcedure($procedure_id, $date['date_start'], Auth::id());
            $events = $this->translatorService->translateRecordsForCalendar([$record]);

            return ['status' => 1, "events" => $events];
        } catch (\Exception $e) {
            return ['status' => 0, "message" => $e->getMessage()];
        }
    }
}