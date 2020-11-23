<form id="form-delete" action="" class="row" method="{{ $method }}">
@method( $methodx )
@csrf
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
        <div class="modal-content box-confirm">
        <div class="modal-header bg-danger">
            <h5 class="modal-title {{ $textWhite }}" id="deleteModalLabel" >Form Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Are you sure to delete the <span id="meta-to-delete"></span> <p id="data"></p>?
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
<script>
    $(document).on('click', '#deleteData', function() {
        let id = $(this).data('id');
        let url = "{{ route($showdata,"") }}";
        let showDataUrl = url + "/" + id;
        let urlDelete = $(this).data('action');

        axios.get(showDataUrl).then(dataMeta => {
            let data = dataMeta.data;
            console.log(data)
            $('#meta-to-delete').text(data.tanggal_setor);
            $('#form-delete').attr('action', urlDelete);
        });
    });
</script>
</form>

