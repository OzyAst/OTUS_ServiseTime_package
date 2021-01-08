<?php

use Illuminate\Support\Facades\Route;
use ServiceTime\Calendar\Controllers\CalendarController;

Route::get('/calendar/timetable/{procedure_id}', [CalendarController::class, 'timetable']);
