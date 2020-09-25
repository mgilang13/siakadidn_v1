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
                        <label for="id_teacher" class="col-form-label">Nama Guru</label>
                        <select name="id_teacher" id="id_teacher" class="form-control">
                            @forelse ($teachers as $teacher)
                                <option value="{{ $teacher->id_teacher }}">{{ $teacher->title_ahead }} {{ $teacher->name }} {{ $teacher->back_title ? ', '.$teacher->back_title : '' }}</option>
                            @empty
                                <option value="">Belum ada data</option>
                            @endforelse
                        </select>
                        <div class="invalid-feedback" id="id_teacher-message"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="id_level" class="col-form-label">Jenjang</label>
                        <select name="id_level" id="id_level" class="form-control">
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}">{{ $level->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="id_level-message"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="id_level_detail" class="col-form-label">Detail Jenjang</label>
                        <select name="id_level_detail" id="id_level_detail" class="form-control">
                            @foreach ($level_details as $level_detail)
                                <option value="{{ $level_detail->id }}">{{ $level_detail->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="id_level_detail-message"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form