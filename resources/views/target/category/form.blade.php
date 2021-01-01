<!-- Modal -->
<form action="" method="POST">
<div class="modal fade" id="modalAddCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori Target</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="id_category" value="" name="id_category">
            <div class="form-group">
                <input id="name" type="text" class="form-control" placeholder = "Nama Kategori Target" name="name">
            </div>
            <div class="form-group">
                <input id="amount" type="number" class="form-control" placeholder = "Jumlah Target" name="amount">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
  </div>
</div>
</form>