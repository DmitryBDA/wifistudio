<div style="margin-top: 5%;" class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">Форма для записи</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">

            <!-- Форма обратной связи -->
            <form data-idevent="{{$event->id}}" id="feedbackForm" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="col-sm-12">
                        <!-- Имя пользователя -->
                        <div class="form-group">
                            <div class="timeRecordShow"><label class="control-label">Дата: </label><span>@if($event->title)
                                        {{$event->start}}
                                    @endif</span>
                            </div>
                            <div class="timeRecordShow">
                                <label for="name" class="control-label">Время: </label><span> {{$event->title}}</span>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-6">

                        <div class="form-group">
                            <label for="name" class="control-label">Фамилия</label>
                            <input style="padding: 0" id="surname" type="text" name="surname" class="form-control" value=""
                                   placeholder="Фамилия" minlength="2" maxlength="30" required="required">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">

                        <div class="form-group">
                            <label for="name" class="control-label">Имя</label>
                            <input style="padding: 0" id="name" type="text" name="name" class="form-control" value=""
                                   placeholder="Имя" minlength="2" maxlength="30" required="required">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">

                        <div class="form-group">
                            <label for="phone" class="control-label">Телефон</label>
                            <input style="padding: 0" id="phone" type="text" name="phone" class="form-control" value=""
                                   placeholder="Телефон" minlength="2" maxlength="30" required="required">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    @if($services)
                    <div class="col-sm-12">
                        <!-- select -->
                        <div class="form-group">
                            <label>Тип услуги</label>
                            <select name="service" class="form-control" required>
                                <option value="" selected>Не выбрано</option>
                                @foreach($services as $service)
                                    <option value="{{$service->id}}">{{$service->name}}</option>
                                @endforeach


                            </select>
                        </div>
                    </div>
                    @endif

                </div>

                <!-- Сообщение -->
                <div class="alert alert-danger form-error d-none">
                    Произошли ошибки! Исправьте их и отправьте форму ещё раз.
                </div>
                <!-- Индикация загрузки данных формы на сервер -->
                <div class="progress mb-2 d-none">
                    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
                         aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0">
                        <span class="sr-only">0%</span>
                    </div>
                </div>
                <!-- Кнопка для отправки формы -->
                <button type="submit" class="btn btn-primary custom float-right">Записаться</button>
            </form>

            <!-- Сообщение об успешной отправки формы -->
            <div class="alert alert-success form-success d-none ">Вы успешно записаны.
                <div class="">Время: {{$event->title}} </div>

                <div class="">Дата: @if($event->title)
                        {{$event->start}}
                    @endif </div>
            </div>

        </div>
    </div>

</div>
