@extends('layouts.user')


@section('title', 'Запись')


@section('custom_css')

    <!-- fullCalendar -->
    <link rel="stylesheet" href="/adm/plugins/fullcalendar/main.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/adm/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/user/feedback.css">



@endsection

@section('custom_js')
    <!-- jQuery -->
{{--    <script src="/adm/plugins/jquery/jquery.min.js"></script>--}}

    <!-- AdminLTE App -->
    <script src="/adm/dist/js/adminlte.min.js"></script>
    <!-- fullCalendar 2.2.5 -->
    <script src="/adm/plugins/moment/moment.min.js"></script>
    <script src="/adm/plugins/fullcalendar/main.js"></script>
    <script src="/user/process-forms.js">
    <script src="/user/feedback.js"></script>

    <script>
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /* initialize the external events
             -----------------------------------------------------------------*/

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


            var calendar = new Calendar(calendarEl, {
                firstDay: 1,

                themeSystem: 'bootstrap',
                events:"/record/fullcalendar/show-events",

                selectable: true,
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
                        url: "/record/showFormRecord",
                        type: "GET",
                        data: {
                            idEvent:event.event._def.publicId
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: (data) => {

                            $('#feedbackFormModal').html(data);

                            $("#phone").mask("8(999)999-99-99");

                            $('#btn_record').click();

                            /*    $('#confirm').click(function(e) {
                                // Stop form from sending request to server
                                e.preventDefault();

                                /!*  const name = prompt('Укажите имя');
                                  const phone = prompt('Укажите телефон');*!/

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

                            $('#btn-from-chose').click();*/


                            $('#feedbackForm').on('submit', function (e){
                                // Stop form from sending request to server
                                e.preventDefault();

                                var idEent = $('#feedbackForm').attr('data-idevent');
                                var dataForm = $('#feedbackForm').serializeArray();




                                  $.ajax({
                                      type: "POST",
                                      url: '/record/addRecord',
                                      data: {
                                          id: idEent,
                                          dataForm:dataForm,
                                      },
                                      success: function (response) {

                                          calendar.refetchEvents()
                                          $('#feedbackForm').css('display', 'none');
                                          $('.alert-success').removeClass('d-none');

                                          setTimeout(function (){
                                              $('.close').click();
                                          }, 1500)

                                      }
                                  });
                            })

                        }

                    })

                }
            });


            calendar.render();
            // $('#calendar').fullCalendar()



        })
    </script>


@endsection

@section('content')


    <div class="slider-wrap home-1-slider" id="home">
        <div id="mainSlider" class="nivoSlider slider-image">
            <img src="/user/img/home2/1.jpg" alt="main slider" title="#htmlcaption1"/>
        </div>
    </div>
    <div class="about_area">
        <div class="container">
            <div class="row">
                <!--section title-->
                <div class="col-md-12 col-sm-12 col-lg-12">
                    <div class="section_title">

                    </div>
                </div>
                <!--end section title-->
            </div>
            <div class="row" >
                <div id="calendar" style="width: 100%;"></div>
            </div>
        </div>
    </div>




    <!-- Кнопка, открывающая модальное окно -->
    <button id="btn_record" style="display: none" type="button" class="btn btn-primary" data-toggle="modal" data-target="#feedbackFormModal">
        Открыть форму в модальном окне
    </button>

    <!-- Форма обратной связи в модальном окне -->
    <div class="modal" id="feedbackFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        @include('user.ajax-elem.formRecord')
    </div>


@endsection
