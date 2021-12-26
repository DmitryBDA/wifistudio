@extends('layouts.admin')


@section('title', 'История записей')


@section('custom_css')
  <link rel="stylesheet" href="/adm/plugins/fullcalendar/main.css">
  <style>
    .timeline>div>.timeline-item{
      margin-left: 0!important;
      margin-right: 0!important;
    }
    .timeline>div{
      margin-right: 0!important;
      margin-bottom: 3px!important;
    }
  </style>
@endsection


@section('custom_js')

@endsection


@section('content')
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="form-group mt-2 mr-2 ml-2">
      <input type="text" class="form-control _search_active_record_history"
             placeholder="Введите чтобы начать поиск">
    </div>
    <div class="_users_active_history_list_wrapper">
      @include('admin.history.ajax-elem.list')
    </div>


    <!-- /.content -->
  </div>
@endsection
