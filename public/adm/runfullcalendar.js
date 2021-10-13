$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var Calendar = FullCalendar.Calendar;
    var calendarEl = document.getElementById('calendar');


    var calendar = new Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        firstDay: 1,
        locale: 'ru',
        themeSystem: 'bootstrap',
        events: "/admin/fullcalendar/show-events",
        height:1000,
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar !!!
        selectable: true,
        dateClick: function (date) {

            $('#addEventsNewTime').remove();

            var HtmlForm = " <form id=\"addEventsNewTime\" data-start=\"\" data-end=\"\" class=\"form-horizontal\">" +
                "<div class=\"addAfterThisElement\"></div>" +
                "<div id=\"id_event_1\" class=\"modal-footer justify-content-between addEventsTimer\">" +
                "<label>Время:" +
                "<input name=\"event_1\" type=\"time\" value=\"00:00\">" +
                "</label>" +
                "</div>" +
                "<div class=\"modal-footer justify-content-between\">" +
                "<button type=\"button\" class=\"btn btn-outline-light\" data-dismiss=\"modal\">Закрыть</button>" +
                "<button id=\"addEventsTime\" type=\"button\" class=\"btn btn-outline-light\">Добавить</button>" +
                "<button type=\"submit\" class=\"btn btn-outline-light\">Сохранить</button>" +
                "</div>" +
                "</form>"

            $('#bodyForAddEventsTime').append(HtmlForm);

            var start = new Date(date.dateStr);
            start = moment(start).format("Y-MM-DD");
            var end = new Date(date.dateStr);
            end = moment(end).format("Y-MM-DD");
            $('#addEventsNewTime').attr('data-start',start)
            $('#addEventsNewTime').attr('data-end',end)

            $('#showAddEventsTime').click()


            $('#addEventsNewTime').on('submit', function (e, start, end) {
                // Stop form from sending request to server
                e.preventDefault();



                var dataForm = $('#addEventsNewTime').serializeArray();

                var start = $('#addEventsNewTime').data('start')
                var end = $('#addEventsNewTime').data('end')

                $.ajax({
                    url: "/admin/fullcalendar/create-list",
                    data: {
                        dataForm: dataForm,
                        start:start,
                        end:end,
                    },
                    type: "POST",
                    success: function (data) {
                        $('.close').click();
                        calendar.refetchEvents()
                    }
                });

            })

            $('#addEventsTime').click(function (e) {
                var allEventTimer = $('.addEventsTimer');

                var countElements = allEventTimer.length
                var idNextElem = countElements + 1
                console.log(idNextElem)

                var addAfterThisElem = $('#id_event_' + countElements);

                addAfterThisElem.after("<div id=\"id_event_"+idNextElem+"\" class=\"modal-footer justify-content-between addEventsTimer\"><label>Время:<input name=\"event_"+idNextElem+"\" type=\"time\" value=\"00:00\"></label></div>");

            })



        },
        drop: function (info) {

            var key = $(info.draggedEl).css("background-color");
            var arrColorEvents = new Map([
                ['rgb(186, 139, 0)', '2'],
                ['rgb(40, 167, 69)', '1'],
                ['rgb(167, 29, 42)', '3'],
            ]);

            if (arrColorEvents.get(key)) {
                var status = arrColorEvents.get(key);
            } else {
                var status = info.draggedEl.classList[1];
            }

            var start = new Date(info.dateStr);
            start = moment(start).format("Y-MM-DD");
            var end = new Date(info.dateStr);
            end = moment(end).format("Y-MM-DD");

            var allDay = info.allDay ? 1 : 0;
            var title = info.draggedEl.innerText;


            $.ajax({
                url: "/admin/fullcalendar/create",
                data: 'title=' + title + '&start=' + start + '&end=' + end + '&allDay=' + allDay + '&status=' + status,
                type: "POST",
                success: function (data) {
                    calendar.refetchEvents()
                }
            });
        },
        eventDrop: function (event) {

            var start = moment(event.event._instance.range.start).format("Y-MM-DD");
            var end = moment(event.event._instance.range.end).format("Y-MM-DD");

            $.ajax({
                url: '/admin/fullcalendar/update',
                data: {
                    title: event.event._def.title,
                    start: start,
                    end: end,
                    id: event.oldEvent._def.publicId,
                },
                type: "POST",
                success: function (response) {

                }
            });
        },
        eventClick: function (event) {

            $.ajax({
                url: "/admin/fullcalendar/showModalAction",
                type: "GET",
                data: {
                    idEvent: event.event._def.publicId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {

                    $('#choise').html(data);

                    $('#time_record').blur(function () {
                        var newTitle = $(this).val();
                        var idEvent = $(this).data('idevent')

                        $.ajax({
                            url: '/admin/fullcalendar/change-time',
                            data: {
                                title: newTitle,
                                id: idEvent,
                            },
                            type: "POST",
                            success: function (response) {
                                calendar.refetchEvents()
                            }
                        });
                    })

                    $("#phone").mask("8(999)999-99-99");

                    $('#confirm').click(function (e) {
                        // Stop form from sending request to server
                        e.preventDefault();

                        /*  const name = prompt('Укажите имя');
                          const phone = prompt('Укажите телефон');*/

                        var idEent = $(this).attr('data-idEvent');
                        var eventStatus = $('#for_id_event').attr('data-event-status');

                        $.ajax({
                            type: "POST",
                            url: '/admin/fullcalendar/action-with-events',
                            data: {
                                id: idEent,
                                type: 'confirm'
                            },
                            success: function (response) {
                                calendar.refetchEvents()
                                $('.close').click();
                            }
                        });
                    })

                    $('#close').click(function (e) {
                        // Stop form from sending request to server
                        e.preventDefault();

                        var idEent = $(this).attr('data-idEvent');

                        $.ajax({
                            type: "POST",
                            url: '/admin/fullcalendar/action-with-events',
                            data: {
                                id: idEent,
                                type: 'close'
                            },
                            success: function (response) {

                                calendar.refetchEvents()
                                $('.close').click();
                            }
                        });
                    })

                    $('#delete').click(function (e) {
                        // Stop form from sending request to server
                        e.preventDefault();

                        var idEent = $(this).attr('data-idEvent');

                        $.ajax({
                            type: "POST",
                            url: '/admin/fullcalendar/action-with-events',
                            data: {
                                id: idEent,
                                type: 'delete'
                            },
                            success: function (response) {
                                calendar.refetchEvents()
                                $('.close').click();
                            }
                        });
                    })

                    $('#btn-from-chose').click();

                }

            })

        }
    });


    $('#choise').on('submit', function (e) {

        e.preventDefault();

        var idEent = $('#for_id_event').attr('data-idEvent');
        var dataForm = $('#choise').serializeArray();

        $.ajax({
            type: "POST",
            url: '/admin/fullcalendar/action-with-events',
            data: {
                id: idEent,
                type: 'record',
                dataForm: dataForm,
            },
            success: function (response) {

                calendar.refetchEvents()
                $('.close').click();
            }
        });
    })

    calendar.render();
    // $('#calendar').fullCalendar()

    /* ADDING EVENTS */
    var currColor = '#28a745' //Red by default
    // Color chooser button
    $('#color-chooser > li > a').click(function (e) {
        e.preventDefault()
        // Save color
        currColor = $(this).css('color')
        // Add color effect to button
        $('#add-new-event').css({
            'background-color': currColor,
            'border-color': currColor
        })
    })
    $('#add-new-event').click(function (e) {
        console.log(e)
        e.preventDefault()
        // Get value and make sure it is not null
        var val = $('#new-event').val()
        if (val.length == 0) {
            return
        }

        // Create events
        var event = $('<div />')
        event.css({
            'background-color': currColor,
            'border-color': currColor,
            'color': '#fff'
        }).addClass('external-event')
        event.text(val)
        $('#external-events').prepend(event)

        // Add draggable funtionality
        ini_events(event)

        // Remove event from text input
        $('#new-event').val('')
    })
    $('#eventsList').on('click', function () {
        /* Get the text field */

        $.ajax({
            type: "get",
            url: '/admin/fullcalendar/copy-data',
            success: function (response) {

                str = '';
                firstDate = '';
                for (i = 0; i < response.length; i++) {

                    var date = moment(response[i].start).format("DD.MM");

                    if (i == 0) {
                        str = date + ': ' + response[i].title
                        firstDate = date;
                    }
                    if (i != 0) {
                        if (firstDate == date) {
                            str = str + ', ' + response[i].title;
                        } else {
                            str = str + '<br>'
                            str = str + date + ': ' + response[i].title
                        }
                    }
                    firstDate = date;

                }

                $('#modalDefaultCopyText').click()

                $('#post-shortlink')[0].innerHTML = str;

            }
        });
    })
})
