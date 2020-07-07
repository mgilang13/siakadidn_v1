<!-- Modal -->
<form action="" method="post">
    @csrf
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="form-group">
                        <label for="name" class="col-form-label">Nama Akses</label>
                        <input type="text" name="name" class="form-control" id="name">
                        <div class="invalid-feedback" id="name-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="group" class="col-form-label">Grup Akses</label>
                        <input type="text" name="group" class="form-control" id="group">
                        <div class="invalid-feedback" id="group-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-form-label">Deskripsi</label>
                        <textarea name="description" id="description" rows="5" class="form-control"></textarea>
                        <div class="invalid-feedback" id="name-message"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>