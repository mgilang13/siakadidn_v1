<form action="" method="post">
    @csrf
     <div class="modal fade" id="modalSubMateri" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSubMateriLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_matter" value="{{ $matter_show->id }}" id="id_matter">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Nama Sub Materi</label>
                        <input type="text" name="name" class="form-control" id="name">
                        <div class="invalid-feedback" id="name-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="seq" class="col-form-label">Urutan</label>
                        <input type="number" name="seq" class="form-control" id="seq">
                        <div class="invalid-feedback" id="seq-message"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn">Reset</button>
                    <button type="submit" class="btn btn-primary" id="submit-sub">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>