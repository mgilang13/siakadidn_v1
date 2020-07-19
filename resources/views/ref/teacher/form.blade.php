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
                        <label for="name" class="col-form-label">Nama Guru</label>
                        <select name="id_teacher" id="name" class="form-control" >
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach   
                        </select>
                        <div class="invalid-feedback" id="name-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="subject" class="col-form-label">Materi Pelajaran</label>
                        <select name="id_subject" id="subject" class="form-control">
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach  
                        </select>
                        <div class="invalid-feedback" id="subject-message"></div>
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