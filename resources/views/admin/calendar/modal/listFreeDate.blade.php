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
