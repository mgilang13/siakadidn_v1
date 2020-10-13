<form action="" method="post">
    @csrf
     <div class="modal fade bottom" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-full-height modal-bottom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h3 id="modalLabel"></h3>
                        <h6>Mapel <span id="subjectName"></span></h6>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex flex-wrap">
                    <div class="col-4">
                        <input type="hidden" value="" name="id_schedule" id="id_schedule">
                        
                        <div class="md-form form-sm" inline="true">
                            <label for="teaching_date">Tanggal Mengajar</label>
                            <input name="teaching_date" type="date" class="form-control" id="teaching_date" value="{{ $tanggal_sekarang }}">
                        </div>
                        <div class="form-group">
                            <label for="id_matter">Materi Pelajaran</label>
                            <select name="id_matter" id="id_matter" class="form-control">
                                <option value="">-- Pilih Materi --</option>
                                
                            </select>
                        </div>
                        <p class="badge badge-primary px-3 px-1 mt-2" style="font-size:14px">Rincian Materi</p><br>
                        <p class="small text-danger">Jangan lupa untuk diisi!</p>
                        @error('journal_details[]')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="pl-4 shadow grey mb-3 rounded lighten-4">
                            <div class="md-form form-sm" id="journal_details_group">
                                <!-- <input name="journal_details[]" type="text" class="form-control form-control-sm" placeholder="Sub Materi 1"> -->
                                <select name="journal_details[]" id="journal_details" class="form-control form-control-sm">
                                    <option value="">-- Pilih Sub Materi 1 --</option>
                                    
                                </select>
                            </div>
                            <button type="button" id="add_sub_matter" class="btn btn-primary btn-sm px-2 rounded"><i class="fas fa-plus mr-2"></i>Sub Materi</button>
                            <button type="button" onclick="cancelSubMateri()" id="cancel_sub_materi" class="btn btn-warning btn-sm px-2 rounded"><i class="fas fa-trash mr-2"></i>Hapus</button>
                        
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="result" id="result"rows="3" placeholder="Hasil..."></textarea>
                            <p class="font-italic font-small">(opsional)</p>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="obstacle" id="obstacle"rows="3" placeholder="Hambatan..."></textarea>
                            <p class="font-italic font-small">(opsional)</p>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="solution" id="solution"rows="3" placeholder="Solusi..."></textarea>
                            <p class="font-italic font-small">(opsional)</p>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="note" id="note" rows="3" placeholder="Catatan..."></textarea>
                            <p class="font-italic font-small">(opsional)</p>
                        </div>
                    </div>
                        <div class="col-8">
                            <h2>Absensi Kelas </h2>
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Keterangan</th>
                                    </thead>
                                    <tbody>
                                        @php $no = 1 @endphp
                                        @foreach($studentClass as $student)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>
                                                <fieldset id="group{{ $student->id }}">
                                                    <div class="d-flex flex-wrap">
                                                        <div class="custom-control custom-radio mr-3">
                                                            <input type="radio" class="custom-control-input" id="sakit{{ $student->id }}" name="status[{{ $student->id }}]" value="s">
                                                            <label class="custom-control-label" for="sakit{{ $student->id }}">Sakit</label>
                                                        </div>
                                                        <div class="custom-control custom-radio mr-3">
                                                            <input type="radio" class="custom-control-input" id="izin{{ $student->id }}" name="status[{{ $student->id }}]" value="i" >
                                                            <label class="custom-control-label" for="izin{{ $student->id }}">Izin</label>
                                                        </div>
                                                        <div class="custom-control custom-radio mr-3">
                                                            <input type="radio" class="custom-control-input" id="alpha{{ $student->id }}" name="status[{{ $student->id }}]" value="a">
                                                            <label class="custom-control-label" for="alpha{{ $student->id }}">Alpha</label>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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