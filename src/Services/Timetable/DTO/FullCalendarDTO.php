<?php

namespace ServiceTime\Calendar\Services\Timetable\DTO;

/**
 * Структура массива расписания для отображения записей в календаре
 *
 * @property $title
 * @property $start
 * @property $end
 */
class FullCalendarDTO
{
    private $title;
    private $start;
    private $end;

    public function __construct(
        $title,
        $start,
        $end
    )
    {
        $this->title = $title;
        $this->start = $start;
        $this->end = $end;
    }

    public function fromArray(array $data)
    {
        return new static(
            $data['title'],
            $data['start'],
            $data['end']
        );
    }


    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'start' => $this->start,
            'end' => $this->end,
        ];
    }
}