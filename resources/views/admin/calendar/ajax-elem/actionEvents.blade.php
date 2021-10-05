<!-- /.card-body -->
<div class="modal-footer justify-content-between">
    <label data-idevent="{{$event->id}}" id="for_id_event" data-event-status="{{$event->status}}" for="">Время:
        <input data-idevent="{{$event->id}}" type="time" id="time_record" value="{{$event->title}}">
    </label>
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
            <input type="text" name="name" placeholder="Имя" required>
            <input id="phone" type="text" name="phone"  placeholder="Телефон" required>
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
