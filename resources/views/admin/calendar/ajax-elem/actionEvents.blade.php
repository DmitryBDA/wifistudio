<!-- /.card-body -->
<div class="modal-footer justify-content-between">
    <label data-idevent="{{$event->id}}" id="for_id_event" data-event-status="{{$event->status}}" for="">Время:
        <input data-idevent="{{$event->id}}" type="time" id="time_record" value="{{$event->title}}">
    </label>
    <div style="width: 100%;"><label for="">Услуга:
            <span>@if($event->service){{$event->service->name}} @endif</span></label></div>
    <div style="width: 100%;"><label for="">Имя: <span>@if($event->user){{$event->user->name}} {{$event->user->surname}} @endif</span></label>
    </div>
    <div style="width: 100%;"><label for="">Телефон:
            <span>@if($event->user){{$event->user->phone}} @endif</span></label></div>

</div>
<div class="modal-footer justify-content-between">
    @if($event->status == 2)
        <input data-idEvent="{{$event->id}}"
               id="confirm"
               type="button" name="confirm" class="btn btn-outline-light" value="Подтвердить">
    @elseif($event->status == 1)
        <div>
          <div class="row">
            <div class="form-group">
              <input id="add_surname" type="text" class="form-control" name="surname" placeholder="Фамилия" autocomplete="off" required>
            </div>
            <div class="form-group">
              <input id="add_name" type="text" class="form-control" name="name" placeholder="Имя" autocomplete="off" required>
            </div>
            <div class="form-group">
              <input id="phone" class="form-control" type="text" name="phone"  placeholder="Телефон" required>
            </div>
            <div class="form-group">
              <select name="service" class="form-control" required>
                <option value="" selected>Не выбрано</option>
                @foreach($services as $service)
                  <option value="{{$service->id}}">{{$service->name}}</option>
                @endforeach
              </select>
            </div>
          </div>

        </div>
        <input data-idEvent="{{$event->id}}"
               id="record"
               type="submit" name="record" class="btn btn-outline-light" value="Записать">

    @endif
    @if($event->status !== 1)
        <input data-idEvent="{{$event->id}}"
               id="close"
               type="button" name="close" class="btn btn-outline-light" value="Отменить">
    @endif
    <input data-idEvent="{{$event->id}}"
           id="delete"
           type="button" name="delete" class="btn btn-outline-light" value="Удалить">
</div>
