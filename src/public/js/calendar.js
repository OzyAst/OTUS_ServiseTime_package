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
            var date_start = Date.parse(arg.date).toString("yyyy-MM-dd HH:mm");
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

        /**
         * Добавим класс для стилизации и spirit блок
         * @param params
         * @return {string}
         */
        slotLaneClassNames: function (params) {
            return 'slot-time-block';
        },
        slotLaneDidMount: function (params) {
            $(params.el).html("<div class='slot-duration'></div>");
        },

        // Установим обработчик для перемещения spirit блока
        viewDidMount() {
            addSpiritEventHandler();
        }
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
                addSpiritSlotTime();
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
    var date = Date.parse(date).toString("dd.MM.yyyy");

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

/**
 * Добавить копию записи, для отображении при наведении
 */
function addSpiritSlotTime() {
    // растянем блок по ширине колонки
    var widthColumn = $(".fc-day-today").width();

    // Увеличим высоту блока согласно продолжительности записи
    var slotHeight = $('.slot-duration').parents('tr').outerHeight();
    var duration = $("#calendar").attr("data-procedure_duration");
    var height = slotHeight * Math.round(duration / 5);

    $(".slot-duration").height(height).width(widthColumn);
}

/**
 * Перемещение spirit блока для записи
 */
function addSpiritEventHandler() {
    $("body").on('mousemove', '.slot-time-block', function (e) {
        // Узнаем в какой колонке календаря мы находимся ("+2" - отсчет со 2-ой колонки)
        var colNumber = Math.round((e.clientX - 200) / $('.slot-duration').width()) + 2;
        // Получим позицию колонки
        var positionColumn = $(".fc-day:nth-child("+ colNumber +")").position();
        if (!positionColumn) {
            return;
        }
        // Перемещаем наш блок на растояние колонки
        var colOffset = positionColumn.left;

        $('.slot-duration').not($('.slot-duration', $(this))).hide();
        $('.slot-duration', $(this)).css("left", colOffset).show();
    });
}