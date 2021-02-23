<?php

use Illuminate\Support\Facades\Route;
use ServiceTime\Calendar\Controllers\CalendarController;

Route::get('/calendar/timetable/{procedure_id}', [CalendarController::class, 'timetable']);

Route::group([
    'middleware' => ['web']
], function () {
    Route::post('/calendar/create/{procedure_id}', [CalendarController::class, 'store']);
});
