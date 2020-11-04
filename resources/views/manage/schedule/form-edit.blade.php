<form action="" method="post">
    @csrf
     <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_class">Kelas</label>
                        <select name="id_class" id="id_class" class="form-control"  style="pointer-events:none">
                            @forelse ($classrooms as $classroom)
                                <option value="{{ $classroom->id }}" {{ (old('id_class') ?? $classroom->id) == $qClass ? 'selected' : '' }}>{{ $classroom->name }}</option>
                            @empty
                                <option value="">Belum ada data</option>
                            @endforelse
                        </select>
                        <div class="invalid-feedback" id="id_day-message"></div>
                    </div>

                    <div class="form-group">
                        <label for="id_day">Hari</label>
                        <select name="id_day" id="id_day" class="form-control" >
                            @forelse ($days2 as $day)
                                <option value="{{ $day->id }}">{{ $day->name }}</option>
                            @empty
                                <option value="">Belum ada data</option>
                            @endforelse
                        </select>
                        <div class="invalid-feedback" id="id_day-message"></div>
                    </div>

                    <div class="form-group">
                        <label for="id_studytime_start">Jam Mulai</label>
                        <select name="id_studytime_start" id="id_studytime_start" class="form-control" >
                            @forelse ($studytimes as $studytime)
                                <option value="{{ $studytime->id }}">{{ $studytime->name }}</option>
                            @empty
                                <option value="">Belum ada data</option>
                            @endforelse
                        </select>
                        <div class="invalid-feedback" id="id_studytime_start-message"></div>
                    </div>

                    <div class="form-group">
                        <label for="id_studytime_end">Jam Akhir</label>
                        <select name="id_studytime_end" id="id_studytime_end" class="form-control">
                           
                        </select>
                        <div class="invalid-feedback" id="id_studytime_end-message"></div>
                    </div>

                    <div class="form-group">
                        <label for="id_subject">Mata Pelajaran</label>
                        <select name="id_subject" id="id_subject" class="form-control">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @forelse($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @empty
                            <option value="">No data!</option>
                            @endforelse
                        </select>
                        <div class="invalid-feedback" id="id_subject-message"></div>
                    </div>

                    <div class="form-group">
                        <label for="id_semester">Semester</label>
                        <select name="id_semester" id="id_semester" class="form-control"  style="pointer-events:none">
                            @forelse ($semesters as $semester)
                                <option class="text-capitalize" value="{{ $semester->id }}" {{ (old('id_semester') ?? $semester->id) == $qSemester ? 'selected' : '' }}>{{ $semester->name }} {{ $semester->status == 1 ? '(Aktif)' : ''}}</option>
                            @empty
                                <option value="">Belum ada data</option>
                            @endforelse
                        </select>
                        <div class="invalid-feedback" id="id_studytime_end-message"></div>
                    </div>

                    <div class="form-group">
                        <label for="id_schoolyear">Tahun Pelajaran</label>
                        <select name="id_schoolyear" id="id_schoolyear" class="form-control"  style="pointer-events:none">
                            @forelse ($schoolyears as $schoolyear)
                                <option value="{{ $schoolyear->id }}" {{ (old('id_schoolyear') ?? $schoolyear->id) == $qSchoolYear ? 'selected' : '' }}>{{ $schoolyear->name }} {{ $schoolyear->status == 1 ? '(Aktif)' : ''}}</option>
                            @empty
                                <option value="">Belum ada data</option>
                            @endforelse
                        </select>
                        <div class="invalid-feedback" id="id_studytime_end-message"></div>
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