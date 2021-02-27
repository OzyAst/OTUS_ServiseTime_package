<?php

use Illuminate\Support\Facades\Route;
use ServiceTime\Calendar\Controllers\CalendarController;

Route::group([
    'middleware' => ['web']
], function () {
    Route::get('/calendar/timetable/{procedure_id}', [CalendarController::class, 'timetable']);

    Route::group([
        'middleware' => ['auth']
    ], function () {
        Route::post('/calendar/create/{procedure_id}', [CalendarController::class, 'store']);
    });
});
