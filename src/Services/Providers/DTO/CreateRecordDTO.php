<?php

namespace ServiceTime\Calendar\Services\Providers\DTO;

use ServiceTime\Calendar\Services\DTO\DTO;
use Carbon\Carbon;

/**
 * Структура массива расписания для отображения записей в календаре
 *
 * @property $procedure_id
 * @property $client_id
 * @property $date_start
 */
class CreateRecordDTO extends DTO
{
    protected int $procedure_id;
    protected int $client_id;
    protected string $date_start;

    public function setDate_start(Carbon $value)
    {
        $this->date_start = $value->format("Y-m-d H:i");
    }
}