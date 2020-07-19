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
                        <label for="id_student" class="col-form-label">Nama Murid</label>
                        <select name="id_student" id="id_student" class="form-control">
                            @forelse ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @empty
                                <p>Belum ada data murid</p>
                            @endforelse
                        </select>
                        <div class="invalid-feedback" id="name-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="nisn" class="col-form-label">NISN</label>
                        <input name="nisn" id="nisn" min="0" type="number" class="form-control"/>
                        <div class="invalid-feedback" id="nisn-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="nis" class="col-form-label">NIS</label>
                        <input name="nis" id="nisn" min="0" type="number" class="form-control" />
                        <div class="invalid-feedback" id="nis-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="entry_date" class="col-form-label">Tanggal Masuk</label>
                        <input name="entry_date" id="entry_date" type="date" class="form-control"/>
                        <div class="invalid-feedback" id="entry_date-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="id_halaqah" id="id_halaqah">Halaqah Tahfidz</label>
                        <select name="id_halaqah" id="id_halaqah" class="form-control">
                            @forelse ($halaqahs as $halaqah)
                                <option value="">Kosongkan bila belum ada kelompok</option>
                                <option value="{{ $halaqah->id }}">{{ $halaqah->name }}</option>
                            @empty
                                <option value="">Data Kosong</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="hafalan_pra_idn" class="col-form-label">Hafalan Sebelum Masuk IDN</label>
                        <span class="row ml-2"><input name="hafalan_pra_idn" id="hafalan_pra_idn" type="number" min="0" max="30" class="form-control col-2" />&nbsp; Juz</span>
                        <div class="invalid-feedback" id="hafalan_pra_idn-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="target_hafalan" class="col-form-label">Target Hafalan</label>
                        <span class="row ml-2"><input name="target_hafalan" id="target_hafalan" type="number" min="0" max="30" class="form-control col-2" />&nbsp; Juz</span>
                        <div class="invalid-feedback" id="target_hafalan-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="father_name" class="col-form-label">Nama Ayah</label>
                        <input name="father_name" id="father_name" type="text" class="form-control" />
                        <div class="invalid-feedback" id="father_name-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="father_job" class="col-form-label">Pekerjaan Ayah</label>
                        <select name="father_job" id="father_job" class="form-control">
                            <option value="pns">PNS</option>
                            <option value="swasta">Swasta</option>
                            <option value="wirausaha">Wirausaha</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                        <div class="invalid-feedback" id="father_job-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="mother_name" class="col-form-label">Nama Ibu</label>
                        <input name="mother_name" id="mother_name" type="text" class="form-control" />
                        <div class="invalid-feedback" id="mother_name-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="mother_job" class="col-form-label">Pekerjaan Ibu</label>
                        <select name="mother_job" id="father_job" class="form-control">
                            <option value="pns">PNS</option>
                            <option value="swasta">Swasta</option>
                            <option value="wirausaha">Wirausaha</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                        <div class="invalid-feedback" id="mother_job-message"></div>
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