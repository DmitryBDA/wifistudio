<form id="addEventsNewTime"
      data-start="@isset($dateRecord){{$dateRecord}}@endisset"
      data-end="@isset($dateRecord){{$dateRecord}}@endisset"
      class="form-horizontal">
    <div class="addAfterThisElement"></div>

    <div id="id_event_1" class="modal-footer justify-content-between addEventsTimer">
        <label for="">Время:
            <input name="event_1" type="time" value="00:00">
        </label>
    </div>

    <div class="modal-footer justify-content-between">

        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Закрыть</button>

        <button id="addEventsTime" type="button" class="btn btn-outline-light">Добавить</button>

        <button type="submit" class="btn btn-outline-light">Сохранить</button>
    </div>
</form>
