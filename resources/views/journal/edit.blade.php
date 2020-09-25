@extends('layouts.app')
@section('content')
<div class="content">
    <h1 class="h1-responsive mb-2">Edit Jurnal</h1>
    <form action="{{ route('journal.update', $journal->id) }}" method="post">
        @csrf
        @method('PATCH')
        <div class="d-flex flex-wrap">
            <div class="col-5">
                <input type="hidden" value="" name="id_schedule" id="id_schedule">
                <input type="hidden" value="" id="url_sub_matter">
                <div class="md-form form-sm" inline="true">
                    <label for="teaching_date">Tanggal Mengajar</label>
                    <input name="teaching_date" type="date" class="form-control" id="teaching_date" value="{{ $tanggal_sekarang }}">
                </div>
                <div class="form-group">
                    <label for="id_matter_real">Materi Pelajaran</label>
                    <p class="small text-info">Pilih materi apabila berbeda dengan jadwal</p>
                    <select name="id_matter_real" id="id_matter_real" class="form-control">
                        <option value="">-- Pilih Materi --</option>
                        @forelse($matters as $matter)
                        <option value="{{ $matter->id }}">{{ $matter->name }}</option>
                        @empty
                        <option value="">Tidak ada data!</option>
                        @endforelse
                    </select>
                </div>
                <p class="badge badge-primary px-3 px-1 mt-2" style="font-size:14px">Rincian Materi</p><br>
                <p class="small text-danger">Jangan lupa untuk diisi!</p>
                <div class="pl-4 shadow grey mb-3 rounded lighten-4" style="padding:20px">
                    <div class="md-form form-sm" id="journal_details_group">
                        <!-- <input name="journal_details[]" type="text" class="form-control form-control-sm" placeholder="Sub Materi 1"> -->
                        <select name="journal_details[]" id="journal_details" class="form-control form-control-sm">
                            <option value="">-- Pilih Sub Materi 1 --</option>
                            
                        </select>
                    </div>
                    <button type="button" id="add_sub_matter" class="btn btn-primary btn-sm px-2 rounded"><i data-feather="plus" width="14" class="mr-2"></i>Sub Materi</button>
                    <button type="button" onclick="cancelSubMateri()" id="cancel_sub_materi" class="btn btn-warning btn-sm px-2 rounded"><i data-feather="trash" width="14" class="mr-2"></i>Hapus</button>
                </div>
                <div class="form-group">
                    <label for="result">Hasil:</label>
                    <textarea class="form-control" name="result" id="result"rows="3" placeholder="Hasil belajar ..."></textarea>
                </div>
                <div class="form-group">
                    <label for="obstacle">Hambatan:</label>
                    <textarea class="form-control" name="obstacle" id="obstacle"rows="3" placeholder="Hambatan selama proses belajar-mengajar ..."></textarea>
                </div>
                <div class="form-group">
                    <label for="solution">Solusi:</label>
                    <textarea class="form-control" name="solution" id="solution"rows="3" placeholder="Solusi dari hambatan di atas ..."></textarea>
                </div>
                <div class="form-group">
                    <label class="badge badge-secondary" for="note">Catatan:</label>
                    <textarea class="form-control" name="note" id="note"rows="3" placeholder="Solusi dari hambatan di atas ..."></textarea>
                </div>
            </div>
            <div class="col-7">
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
    </form>
</div>

<script>
var count = 1;

$(document).ready(function () {
    $('#add_sub_matter').on('click', function() {
        count++;
        let url = $('#url_sub_matter').val();
        axios.get(url).then(result => {
            let data = result.data;         
            data.map(function(data) {
                $('#journal_details_group').append('<select id="journal_details" name="journal_details[]" id="" class="form-control form-control-sm">'+
                    '<option value="">-- Pilih Sub Materi '+count+' --</option>' +
                    '<option value="'+data.id+'">'+data.name+'</option>' +
                '</select>');
            });
        });
    })
});
</script>
<script>
function cancelSubMateri() {
    count--;
    $('#journal_details_group').children().last().remove();
}
</script>
@endsection
