<div class="modal fade" id="modal-primary">
    <div class="modal-dialog">
        <div class="modal-content bg-primary">
            <div class="modal-header">
                <h4 class="modal-title">Primary Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="bodyForAddEventsTime" class="modal-body">

                @include('admin.calendar.ajax-elem.addEventsTime')

            </div>
        </div>
    </div>
</div>
<button id="showAddEventsTime" style="display: none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-primary">
    Launch Primary Modal
</button>
