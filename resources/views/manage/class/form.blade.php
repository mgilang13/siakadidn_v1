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
                        <label for="name" class="col-form-label">Nama Kelas</label>
                        <select name="id_class" id="id_class" class="form-control">
                            @forelse ($classrooms as $classroom)
                                <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                            @empty
                                <option value="">Belum ada data</option>
                            @endforelse
                        </select>
                        <div class="invalid-feedback" id="name-message"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="id_teacher" class="col-form-label">Wali Kelas</label>
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
                        <label for="id_schoolyear" class="col-form-label">Tahun Pelajaran</label>
                        <select name="id_schoolyear" id="id_schoolyear" class="form-control">
                            @forelse ($schoolyears as $schoolyear)
                                <option value="{{ $schoolyear->id }}">{{ $schoolyear->name }} {{ $schoolyear->status == 1 ? '(Aktif)' : '' }}</option>
                            @empty
                                <option value="">Belum ada data</option>
                            @endforelse
                        </select>
                        <div class="invalid-feedback" id="id_teacher-message"></div>
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