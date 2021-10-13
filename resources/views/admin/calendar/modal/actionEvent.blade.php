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
