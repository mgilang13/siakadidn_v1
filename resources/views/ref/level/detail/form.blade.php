<form action="" method="post">
    @csrf
     <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabelDetail"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="form-group">
                        <label for="name" class="col-form-label">Detail Jenjang</label>
                        <input type="text" name="name" class="form-control" id="name">
                        <div class="invalid-feedback" id="name-message"></div>
                    </div>
                    <div id="message"></div>
                    <div class="form-group">
                        <label for="address" class="col-form-label">Alamat</label>
                        <input type="text" name="address" class="form-control" id="name">
                        <div class="invalid-feedback" id="address-message"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn">Reset</button>
                    <button id="submit-detail" type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form