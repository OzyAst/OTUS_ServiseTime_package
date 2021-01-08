"use strict";

var calendar = null;

/**
 * Init calendar
 */
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        slotDuration: '00:05:00',
        headerToolbar: {
            left: 'prev,today,next',
            center: 'title',
            right: 'timeGridWeek timeGridDay'
        },
        buttonText: {
            today: 'Сегодня',
            week: 'Неделя',
            day: 'День',
        },
        locale: 'ru',
        navLinks: true,
        editable: true,
        eventLimit: true,
        slotEventOverlap: false,
        allDaySlot: false,
        height: 'auto',

        /**
         * Обновление событий в календаре
         * @param info
         */
        datesSet: function(info) {
            var procedure_id = parseInt(document.getElementById('calendar').dataset.procedure);
            var date_start = info.start.toLocaleDateString("ru");
            var date_end = info.end.toLocaleDateString("ru");

            refresh_calendar(procedure_id, date_start, date_end);
        },
    });

    calendar.render();
});

/**
 * Заполним календарь записями
 */
function refresh_calendar(procedure_id, date_start, date_end) {
    if (!check_calendar()) {
        return;
    }

    if (procedure_id) {
        ajax("get", "/calendar/timetable/" + procedure_id, {date_start: date_start, date_end: date_end}, {
            success: function (events) {
                clear_calendar();
                calendar.addEventSource(events);
            }
        })
    }
}

/**
 * Очистить календарь
 */
function clear_calendar() {
    if (!check_calendar()) {
        return;
    }

    calendar.removeAllEvents();
}

/**
 * Проверка календаря
 * @return {boolean}
 */
function check_calendar() {
    if (!calendar) {
        console.log("Календарь не инициализирован");
        return false;
    }

    return true
}
