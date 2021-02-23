<?php

namespace ServiceTime\Calendar\Services\Translators\DTO;

use ServiceTime\Calendar\Services\DTO\DTO;

/**
 * Структура массива расписания для отображения записей в календаре
 *
 * @property $title
 * @property $start
 * @property $end
 */
class FullCalendarDTO extends DTO
{
    protected string $title;
    protected string $start;
    protected string $end;
}