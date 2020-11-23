<form id="form-delete" action="" class="row" method="POST">
@method('DELETE')
@csrf
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
        <div class="modal-content box-confirm">
        <div class="modal-header bg-danger">
            <h5 class="modal-title text-white">Form Delete Permanently</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Are you sure to delete data on <span id="data-deleted"></span>?
        </div>
        <div class="modal-footer">

                <button title="Cancel" type="button" class="btn btn-confirm-cancel mr-1 rounded-circle" data-dismiss="modal">
                    <i width="20" data-feather="x-circle"></i>
                </button>
                <button title="Delete" id="btn-delete" type="submit" class="btn btn-confirm-delete mr-3 rounded-circle">
                    <i width="20" data-feather="trash"></i>
                </button>
            </div>
        </div>
    </div>
</div>
</form>

