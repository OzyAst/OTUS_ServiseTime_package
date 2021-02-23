<?php

namespace ServiceTime\Calendar\Services\Translators;

use Illuminate\Support\Facades\Auth;
use ServiceTime\Calendar\Services\Translators\DTO\FullCalendarDTO;

/**
 * Данные записи
 */
class CalendarRecordTranslator extends BaseTranslator
{
    /**
     * @param array $item
     * @return FullCalendarDTO
     */
    public function translate($item): FullCalendarDTO
    {
        return FullCalendarDTO::fromArray([
            'title' => $item['procedure']['name'],
            'start' => $item['date_start'],
            'end' => $item['date_end'],
            'color' => (Auth::id() == $item['client_id']) ? "#2db56c" : "#3490dc",
        ]);
    }
}
