@extends('layouts.admin')


@section('title', 'Календарь')


@section('custom_css')
    <!-- fullCalendar -->
    <link rel="stylesheet" href="/adm/plugins/fullcalendar/main.css">
@endsection


@section('custom_js')

    <script src="/adm/plugins/moment/moment.min.js"></script>
    <script src="/adm/plugins/fullcalendar/main.js"></script>
    <script src="/adm/plugins/fullcalendar/locales-all.min.js"></script>
    <script>
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function select(elem) {
                var rng, sel;
                if (document.createRange) {//Не все браузеры поддерживают createRange
                    rng = document.createRange();//создаем объект область
                    rng.selectNode(elem)//выберем текущий узел
                    sel = window.getSelection();//Получаем объект текущее выделение
                    var strSel = '' + sel; //Преобразуем в строку (ох уж js...)
                    if (!strSel.length) { //Если ничего не выделено
                        sel.removeAllRanges();//Очистим все выделения (на всякий случай)
                        sel.addRange(rng); //Выделим текущий узел
                    }
                } else {//Если браузер не поддерживает createRange (IE<9, например)
                    //Выделяем таким образом, уже без всяких проверок
                    var rng = document.body.createTextRange();
                    rng.moveToElementText(elem);
                    rng.select();
                }
            }

            function ini_events(ele) {
                ele.each(function () {

                    var eventObject = {
                        title: $.trim($(this).text()) // use the element's text as the event title
                    }

                    // store the Event Object in the DOM element so we can get to it later
                    $(this).data('eventObject', eventObject)

                    // make the event draggable using jQuery UI
                    $(this).draggable({
                        zIndex: 1070,
                        revert: true, // will cause the event to go back to its
                        revertDuration: 0  //  original position after the drag
                    })

                })
            }

            ini_events($('#external-events div.external-event'))

            /* initialize the calendar
             -----------------------------------------------------------------*/
            //Date for the calendar events (dummy data)
            var date = new Date()
            var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear()

            var Calendar = FullCalendar.Calendar;
            var Draggable = FullCalendar.Draggable;

            var containerEl = document.getElementById('external-events');
            var checkbox = document.getElementById('drop-remove');
            var calendarEl = document.getElementById('calendar');

            // initialize the external events
            // -----------------------------------------------------------------

            new Draggable(containerEl, {
                itemSelector: '.external-event',
                /*   eventData: function(eventEl) {
                       return {
                           title: eventEl.innerText,
                           backgroundColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
                           borderColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
                           textColor: window.getComputedStyle( eventEl ,null).getPropertyValue('color'),
                       };
                   }*/
            });

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
                height:700,
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
                // Stop form from sending request to server
                e.preventDefault();

                /*  const name = prompt('Укажите имя');
                  const phone = prompt('Укажите телефон');*/

                var idEent = $('#for_id_event').attr('data-idEvent');
                var eventStatus = $('#for_id_event').attr('data-event-status');

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
    </script>

@endsection


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Calendar</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Calendar</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="sticky-top mb-3">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Перетащить даты</h4>
                                </div>
                                <div class="card-body">
                                    <!-- the events -->
                                    <div id="external-events">
                                        <div class="external-event bg-success">11:00</div>
                                        <div class="external-event bg-success">14:00</div>
                                        <div class="external-event bg-success">18:00</div>
                                        <div class="external-event bg-success">20:00</div>
                                        {{--   <div class="external-event bg-warning">Go home</div>
                                           <div class="external-event bg-info">Do homework</div>
                                           <div class="external-event bg-primary">Work on UI design</div>
                                           <div class="external-event bg-danger">Sleep tight</div>--}}
                                        <div style="display: none;" class="checkbox">
                                            <label for="drop-remove">
                                                <input type="checkbox" id="drop-remove">
                                                remove after drop
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Создать событие</h3>
                                </div>


                                <div class="card-body">
                                    <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                                        <ul class="fc-color-picker" id="color-chooser">
{{--                                            <li><a class="text-success" href="#"><i class="fas fa-square"></i></a></li>--}}
                                            {{--  <li><a class="text-danger" href="#"><i class="fas fa-square"></i></a></li>
                                              <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a></li>--}}
                                            {{--     <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a></li>
                                                 <li><a class="text-primary" href="#"><i class="fas fa-square"></i></a></li>

                                                 <li><a class="text-muted" href="#"><i class="fas fa-square"></i></a></li>--}}
                                        </ul>
                                    </div>
                                    <!-- /btn-group -->
                                    <div class="input-group">
                                        <input id="new-event" type="time" class="form-control">

                                        <div class="input-group-append">
                                            <button id="add-new-event" type="button" class="btn btn-primary"
                                                    style="background-color: rgb(25, 105, 44); border-color: rgb(25, 105, 44);">
                                                Добавить
                                            </button>
                                        </div>
                                        <!-- /btn-group -->
                                    </div>
                                    <!-- /input-group -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card card-primary">
                            <div class="card-body p-0">
                                <!-- THE CALENDAR -->
                                <div id="calendar"></div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-1">
                                <div style="width: 100%;height: 49px;" class="btn-group-vertical">
                                    <button id="eventsList" type="button" class="btn btn-default">Список дат</button>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="card card-info collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title">Активные записи</h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                                    title="Collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Дата</th>
                                                <th>Время</th>
                                                <th>Имя</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($eventList as $event)
                                                <tr>

                                                    <td>{{ Date::parse($event->start)->format('j.m (D)')}}</td>
                                                    <td>{{$event->title}}</td>
                                                    <td>@if($event->user)
                                                            {{$event->user->name}} {{$event->user->surname}}
                                                        @endif
                                                    </td>

                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>


        <div class="modal fade" id="modal-info">
            <div class="modal-dialog">
                <div class="modal-content bg-info">
                    <div class="modal-header">
                        <h4 class="modal-title">Выбор действия</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="choise" class="form-horizontal">

                            @include('admin.calendar.ajax-elem.actionEvents')

                        <!-- /.card-footer -->
                        </form>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <button style="display: none" id="btn-from-chose" type="button" class="btn btn-info" data-toggle="modal"
                data-target="#modal-info">
            Launch Info Modal
        </button>

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Свободные даты</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="post-shortlink" class="modal-body">

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <button id="copy-button" data-clipboard-target="#post-shortlink" type="button"
                                class="btn btn-primary">Копировать
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <button style="display: none;" id="modalDefaultCopyText" type="button" class="btn btn-default"
                data-toggle="modal" data-target="#modal-default">
            Launch Default Modal
        </button>


        <div class="modal fade" id="modal-primary">
            <div class="modal-dialog">
                <div class="modal-content bg-primary">
                    <div class="modal-header">
                        <h4 class="modal-title">Primary Modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="bodyForAddEventsTime" class="modal-body">
                        <form id="addEventsNewTime" data-start="" data-end="" class="form-horizontal">

                            @include('admin.calendar.ajax-elem.addEventsTime')
                        <!-- /.card-footer -->
                        </form>

                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <button id="showAddEventsTime" style="display: none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-primary">
            Launch Primary Modal
        </button>


        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection
