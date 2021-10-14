@extends('layouts.admin')

@section('title', 'Календарь')

@section('custom_css')
  <link rel="stylesheet" href="/adm/plugins/fullcalendar/main.css">
@endsection

@section('custom_js')

  <script src="/adm/plugins/moment/moment.min.js"></script>
  <script src="/adm/plugins/fullcalendar/main.js"></script>
  <script src="/adm/plugins/fullcalendar/locales-all.min.js"></script>
  <script src="/adm/runfullcalendar.js"></script>

@endsection

@section('content')

  <div class="content-wrapper">
    <section class="content-header">
      @include('admin.calendar.index-page.breadcrumbs')
    </section>

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
                  <div id="external-events">
                    <div class="external-event bg-success">11:00</div>
                    <div style="display: none;" class="checkbox">
                      <label for="drop-remove">
                        <input type="checkbox" id="drop-remove">
                        remove after drop
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-9">
            <div class="card card-primary">
              <div id="fullcalendar_main" class="card-body p-0">
                <div id="calendar">

                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-3">
                <div style="width: 100%;height: 49px;" class="btn-group-vertical">
                  <button id="eventsList" type="button" class="btn btn-default">Список дат</button>
                </div>
              </div>
              <div class="col-md-9">
                <div class="card card-info collapsed-card">
                  <div id="list_active_records" class="card-header">
                    <h3 class="card-title">Активные записи</h3>

                    <div class="card-tools _btn_collapse">
                      <button class="btn btn-tool " data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                      </button>
                    </div>
                  </div>

                  <div class="card-body p-0">
                    <div class="form-group mt-2 mr-2 ml-2">
                      <input type="text" class="form-control _search_active_record"
                             placeholder="Введите чтобы начать поиск">
                    </div>
                    <div class="_users_active_list_wrapper">
                      @include('admin.calendar.ajax-elem.usersActiveList')
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    @include('admin.calendar.modal.actionEvent')

    @include('admin.calendar.modal.listFreeDate')

    @include('admin.calendar.modal.addEvents')

  </div>

@endsection
