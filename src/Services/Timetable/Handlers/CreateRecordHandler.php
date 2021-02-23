<?php

namespace ServiceTime\Calendar\Services\Timetable\Handlers;

use Carbon\Carbon;
use ServiceTime\Calendar\Services\Providers\DTO\CreateRecordDTO;
use ServiceTime\Calendar\Services\Providers\ProviderService;

/**
 * Создать запись
 */
class CreateRecordHandler
{
    private ProviderService $providerService;

    public function __construct(ProviderService $providerService)
    {
        $this->providerService = $providerService;
    }

    public function handle(int $procedure_id, Carbon $date_start, int $user_id): array
    {
        return  $this->providerService->createRecord(CreateRecordDTO::fromArray([
            'procedure_id' => $procedure_id,
            'date_start' => $date_start,
            'client_id' => $user_id,
        ]));
    }
}