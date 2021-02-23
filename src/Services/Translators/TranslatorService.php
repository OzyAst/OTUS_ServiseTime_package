<?php

namespace ServiceTime\Calendar\Services\Translators;

class TranslatorService
{
    private CalendarRecordTranslator $calendarRecordTranslator;

    public function __construct(
        CalendarRecordTranslator $calendarRecordTranslator
    )
    {
        $this->calendarRecordTranslator = $calendarRecordTranslator;
    }

    /**
     * Вернет данные для вывода календаря с расписанием
     * @param array $records
     * @return array
     */
    public function translateRecordsForCalendar(array $records): array
    {
        $recordsListDTOs = $this->calendarRecordTranslator->translateAll($records);
        return array_map(function ($item) {
            return $item->toArray();
        }, $recordsListDTOs);
    }
}
