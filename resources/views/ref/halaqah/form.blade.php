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
                        <label for="name" class="col-form-label">Nama Halaqah</label>
                        <input type="text" name="name" class="form-control" id="name">
                        <div class="invalid-feedback" id="name-message"></div>
                    </div>

                    <div class="form-group">
                        <label for="id_teacher" class="col-form-label">Pengampu</label>
                        <select name="id_teacher" id="id_teacher" class="form-control" style="width:100%">
                            @forelse ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @empty
                                <option value="">Belum ada data</option>
                            @endforelse
                        </select>
                        <div class="invalid-feedback" id="id_teacher-message"></div>
                    </div>

                    <div class="form-group">
                        <label for="id_level" class="col-form-label">Institusi</label>
                        <select name="id_level" id="id_level" class="form-control">
                            @forelse ($levels as $level)
                                <option value="{{ $level->id }}">{{ $level->name }}</option>
                            @empty
                                <option value="">Belum ada data</option>
                            @endforelse
                        </select>
                        <div class="invalid-feedback" id="id_level-message"></div>
                    </div>

                    <div class="form-group">
                        <label for="id_level_detail" class="col-form-label">Detail Institusi</label>
                        <select name="id_level_detail" id="id_level_detail" class="form-control">
                            @forelse ($level_details as $level_detail)
                                <option value="{{ $level_detail->id }}">{{ $level_detail->name }}</option>
                            @empty
                                <option value="">Belum ada data</option>
                            @endforelse
                        </select>
                        <div class="invalid-feedback" id="id_level_detail-message"></div>
                    </div>

                    <div class="form-group">
                        <label for="id_class" class="col-form-label">Kelas</label>
                        <select name="id_class" id="id_class" class="form-control">
                            @forelse ($classrooms as $classroom)
                                <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                            @empty
                                <option value="">Belum ada data</option>
                            @endforelse
                        </select>
                        <div class="invalid-feedback" id="id_class-message"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="description" class="col-form-label">Deskripsi Halaqah</label>
                        <textarea name="description" id="description" rows="5" class="form-control"></textarea>
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