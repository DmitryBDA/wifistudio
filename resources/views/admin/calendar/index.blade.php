@extends('layouts.admin')


@section('title', 'Календарь')


@section('custom_css')
    <!-- fullCalendar -->
    <link rel="stylesheet" href="/adm/plugins/fullcalendar/main.css">
@endsection


@section('custom_js')

    <script src="/adm/plugins/moment/moment.min.js"></script>
    <script src="/adm/plugins/fullcalendar/main.js"></script>

    <script>
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /* initialize the external events
             -----------------------------------------------------------------*/
            function ini_events(ele) {
                ele.each(function () {

                    // create an Event Object (https://fullcalendar.io/docs/event-object)
                    // it doesn't need to have a start or end
                    var eventObject = {
                        title: $.trim($(this).text()) // use the element's text as the event title
                    }

                    // store the Event Object in the DOM element so we can get to it later
                    $(this).data('eventObject', eventObject)

                    // make the event draggable using jQuery UI
                    $(this).draggable({
                        zIndex        : 1070,
                        revert        : true, // will cause the event to go back to its
                        revertDuration: 0  //  original position after the drag
                    })

                })
            }

            ini_events($('#external-events div.external-event'))

            /* initialize the calendar
             -----------------------------------------------------------------*/
            //Date for the calendar events (dummy data)
            var date = new Date()
            var d    = date.getDate(),
                m    = date.getMonth(),
                y    = date.getFullYear()

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
                    left  : 'prev,next today',
                    center: 'title',
                    right : 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                firstDay: 1,

                themeSystem: 'bootstrap',
                events:"/admin/fullcalendar/show-events",
                editable  : true,
                droppable : true, // this allows things to be dropped onto the calendar !!!
                selectable: true,
                select:function (info) {
                    var title = prompt('Event Title:');
                    if (title) {
                        console.log(info)
                        var start = new Date(info.start);
                        start = moment(start).format("Y-MM-DD");
                        var end = new Date(info.end);
                        end = moment(end).format("Y-MM-DD");
                        var allDay = info.allDay ? 1 : 0;
                        var status = 1;

                        console.log(start)
                        console.log(end)
                        console.log(allDay)

                        $.ajax({
                            url: "/admin/fullcalendar/create",
                            data: 'title=' + title + '&start=' + start + '&end=' + end + '&allDay=' + allDay + '&status=' + status,
                            type: "POST",
                            success: function (data) {
                                calendar.refetchEvents()
                            }
                        });

                       /* $.ajax({
                            url: SITEURL + "/fullcalendarAjax",
                            data: {
                                title: title,
                                start: start,
                                end: end,
                                type: 'add'
                            },
                            type: "POST",
                            success: function (data) {
                                displayMessage("Event Created Successfully");

                                calendar.fullCalendar('renderEvent',
                                    {
                                        id: data.id,
                                        title: title,
                                        start: start,
                                        end: end,
                                        backgroundColor: '#28a745',
                                        allDay: allDay
                                    },true);

                                calendar.fullCalendar('unselect');
                            }
                        });*/
                    }

                },
                drop      : function(info) {

                    var key = $(info.draggedEl).css("background-color");
                    var arrColorEvents = new Map([
                        ['rgb(186, 139, 0)', '2'],
                        ['rgb(40, 167, 69)', '1'],
                        ['rgb(167, 29, 42)', '3'],
                    ]);

                    if(arrColorEvents.get(key)){
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


                    // is the "remove after drop" checkbox checked?
                    if (checkbox.checked) {
                        // if so, remove the element from the "Draggable Events" list
                        //info.draggedEl.parentNode.removeChild(info.draggedEl);
                    }

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

                  /*  var eventStatus = event.event._def.extendedProps.status;

                    $('#btn-from-chose').click();

                    $('input[type="submit"]').attr('data-idEvent', event.event._def.publicId)

                    var titleEvent =  event.event._def.title;

                    $('#time_record').text(titleEvent)
                    $('#for_id_event').attr('data-idevent', event.event._def.publicId)
                    $('#for_id_event').attr('data-event-status', eventStatus)
*/
                    $.ajax({
                        url: "/admin/fullcalendar/showModalAction",
                        type: "GET",
                        data: {
                            idEvent:event.event._def.publicId
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: (data) => {

                            $('#choise').html(data);

                            $("#phone").mask("8(999)999-99-99");

                            $('#confirm').click(function(e) {
                                // Stop form from sending request to server
                                e.preventDefault();

                                /*  const name = prompt('Укажите имя');
                                  const phone = prompt('Укажите телефон');*/

                                var idEent = $(this).attr('data-idEvent');
                                var eventStatus =  $('#for_id_event').attr('data-event-status');

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

                            $('#close').click(function(e) {
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

                            $('#delete').click(function(e) {
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


            $('#choise').on('submit', function (e){
                // Stop form from sending request to server
                e.preventDefault();

                /*  const name = prompt('Укажите имя');
                  const phone = prompt('Укажите телефон');*/

                var idEent = $('#for_id_event').attr('data-idEvent');
                var eventStatus =  $('#for_id_event').attr('data-event-status');

                var dataForm = $('#choise').serializeArray();



                $.ajax({
                    type: "POST",
                    url: '/admin/fullcalendar/action-with-events',
                    data: {
                        id: idEent,
                        type: 'record',
                        dataForm:dataForm,
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
                    'border-color'    : currColor
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
                    'border-color'    : currColor,
                    'color'           : '#fff'
                }).addClass('external-event')
                event.text(val)
                $('#external-events').prepend(event)

                // Add draggable funtionality
                ini_events(event)

                // Remove event from text input
                $('#new-event').val('')
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
                                    <h4 class="card-title">Draggable Events</h4>
                                </div>
                                <div class="card-body">
                                    <!-- the events -->
                                    <div id="external-events">
                                        <div class="external-event bg-success">9:00</div>
                                        <div class="external-event bg-success">11:00</div>
                                        <div class="external-event bg-success">14:00</div>
                                        <div class="external-event bg-success">18:00</div>
                                        <div class="external-event bg-success">20:00</div>
                                     {{--   <div class="external-event bg-warning">Go home</div>
                                        <div class="external-event bg-info">Do homework</div>
                                        <div class="external-event bg-primary">Work on UI design</div>
                                        <div class="external-event bg-danger">Sleep tight</div>--}}
                                        <div class="checkbox">
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
                                    <h3 class="card-title">Create Event</h3>
                                </div>


                                <div class="card-body">
                                    <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                                        <ul class="fc-color-picker" id="color-chooser">
                                            <li><a class="text-success" href="#"><i class="fas fa-square"></i></a></li>
                                          {{--  <li><a class="text-danger" href="#"><i class="fas fa-square"></i></a></li>
                                            <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a></li>--}}
                                       {{--     <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a></li>
                                            <li><a class="text-primary" href="#"><i class="fas fa-square"></i></a></li>

                                            <li><a class="text-muted" href="#"><i class="fas fa-square"></i></a></li>--}}
                                        </ul>
                                    </div>
                                    <!-- /btn-group -->
                                    <div class="input-group">
                                        <input id="new-event" type="time" class="form-control" placeholder="Event Title">

                                        <div class="input-group-append">
                                            <button id="add-new-event" type="button" class="btn btn-primary" style="background-color: rgb(25, 105, 44); border-color: rgb(25, 105, 44);">Add</button>
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
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>

      {{--  <div class="modal fade" id="modal-info">
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
                            <!-- /.card-body -->
                            <div class="modal-footer justify-content-between">
                                <label data-idevent="" id="for_id_event" data-event-status="" for="">Время <span id="time_record"></span></label>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <input data-idEvent=""
                                       id="confirm"
                                       type="submit" name="confirm" class="btn btn-outline-light" value="Подтвердить">
                                <input data-idEvent=""
                                       id="close"
                                       type="submit" name="close" class="btn btn-outline-light" value="Отменить">
                                <input data-idEvent=""
                                       id="delete"
                                       type="submit" name="delete" class="btn btn-outline-light" value="Удалить">
                            </div>

                            <!-- /.card-footer -->
                        </form>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>--}}

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

        <button style="display: none" id="btn-from-chose" type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-info">
            Launch Info Modal
        </button>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection
