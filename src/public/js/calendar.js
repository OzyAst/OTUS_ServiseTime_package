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
        slotMinTime: "08:30:00",
        slotMaxTime: "20:00:00",
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

        // Клик по времени в календаре
        dateClick: function (arg) {
            var date_start = Date.parse(arg.date).toString("yyyy-MM-d HH:mm");
            var procedure_id = $("#calendar").attr("data-procedure");
            var procedure_name = $("#calendar").attr("data-procedure_name");

            confirmCreateRecord(procedure_name, date_start).then((result) => {
                if (result.isConfirmed) {
                    ajax("POST", "/calendar/create/" + procedure_id, {date_start: date_start}, {
                        success: function (answer) {
                            calendar.addEventSource(answer.events);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Запись добавлена!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    })
                }
            })
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

/**
 * Форма подтверждения записи
 * @param procedure
 * @param date
 * @return {*}
 */
function confirmCreateRecord(procedure, date) {
    var time = Date.parse(date).toString("HH:mm");
    var date = Date.parse(date).toString("d.MM.yyyy");

    return Swal.fire({
        title: 'Запись на процедуру ' + procedure + '?',
        text: "Вы точно хотите записться на " + date + " число, в " + time + "",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Да, записаться'
    })
}
