<div class="modal fade right rgba-teal-light" id="modal-treat{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">

  <!-- Add class .modal-side and then add class .modal-top-right (or other classes from list above) to set a position to the modal -->
  <div class="modal-dialog modal-side modal-bottom-right" role="document">

    <form id="form-treat{{ $id }}" action="" method="POST">
    @csrf
        <div class="modal-content">
        <div class="modal-header teal accent-4">
            <h4 class="modal-title text-white w-100 font-weight-bold" id="modalTreatLabel">Tindakan Perbaikan</h4>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="teal lighten-5 p-2 rounded z-depth-1 mb-3">
                <h6 class="font-weight-bold"><i class="fa fa-question-circle mr-1" aria-hidden="true"></i> Kasus</h6>
                <p id="form-note{{ $id }}"></p>
            </div>
            <input type="hidden" value="" id="id_journal_feed{{ $id }}" name="id_journal_feedback">
            <div class="form-group">
                <textarea name="description" cols="30" rows="3" class="form-control" placeholder="Deskripsi Tindakan"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-info rounded-pill btn-sm" data-dismiss="modal">Close</button>
            <button type="submit" class="btn teal darken-1 text-white rounded-pill btn-sm">Submit</button>
        </div>
        </div>
    </form>
  </div>
</div>