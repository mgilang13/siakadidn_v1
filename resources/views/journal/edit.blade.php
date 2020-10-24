@extends('layouts.app')
@section('content')
<div class="content">
    <h1 class="h1-responsive mb-2">Edit Jurnal</h1>
    <form action="{{ route('journal.update', $journal->id) }}" method="post">
        @csrf
        @method('PATCH')
        <div class="d-flex justify-content-end">
            <div class="header-btn">
                <a href="{{ route('journal.show', $journal->id_schedule) }}" class="btn btn-primary-outline"><i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
        <div class="d-flex flex-wrap">
            <div class="col-5">
                <input type="hidden" value="" name="id_schedule" id="id_schedule">
                <input type="hidden" value="" id="url_sub_matter">
                <div class="form-group" inline="true">
                    <label for="teaching_date">Tanggal Mengajar</label>
                    <input name="teaching_date" type="date" class="form-control" id="teaching_date" value="{{ $journal->teaching_date }}">
                </div>
                <div class="form-group">
                    <label for="id_matter">Materi Pelajaran</label>
                    <p class="small text-info">Pilih materi apabila berbeda dengan jadwal</p>
                    <select name="id_matter" id="id_matter" class="form-control">
                        <option value="">-- Pilih Materi --</option>
                        @forelse($matter_subjected as $ms)
                        <option value="{{ $ms->id }}" {{ (old('id_matter') ?? $ms->id) == $journal->id_matter ? 'selected' : '' }}>{{ $ms->name }}</option>
                        @empty
                        <option value="">Tidak ada data!</option>
                        @endforelse
                    </select>
                </div>
                <p class="badge badge-primary px-3 px-1 mt-2" style="font-size:14px">Rincian Materi</p><br>
                <p class="small text-danger">Jangan lupa untuk diisi!</p>
                <div class="px-3 py-1 shadow grey mb-3 rounded lighten-4">
                    <div class="md-form form-sm" id="journal_details_group">
                        <!-- <input name="journal_details[]" type="text" class="form-control form-control-sm" placeholder="Sub Materi 1"> -->
                    </div>
                    <button type="button" id="add_sub_matter" class="btn btn-primary btn-sm px-2 rounded"><i data-feather="plus" width="14" class="mr-2"></i>Sub Materi</button>
                    <button type="button" onclick="cancelSubMateri()" id="cancel_sub_materi" class="btn btn-warning btn-sm px-2 rounded"><i data-feather="trash" width="14" class="mr-2"></i>Hapus</button>
                </div>
                <div class="form-group">
                    <label for="result">Hasil:</label>
                    <textarea class="form-control" name="result" id="result"rows="3" placeholder="Hasil belajar ...">{{ old('result') ?? $journal->result }}</textarea>
                </div>
                <div class="form-group">
                    <label for="obstacle">Hambatan:</label>
                    <textarea class="form-control" name="obstacle" id="obstacle"rows="3" placeholder="Hambatan selama proses belajar-mengajar ..." >{{ old('obstacle') ?? $journal->obstacle }}</textarea>
                </div>
                <div class="form-group">
                    <label for="solution">Solusi:</label>
                    <textarea class="form-control" name="solution" id="solution"rows="3" placeholder="Solusi dari hambatan di atas ...">{{ old('solution') ?? $journal->solution }}</textarea>
                </div>
                <div class="form-group">
                    <label class="badge badge-secondary" for="note">Catatan:</label>
                    <textarea class="form-control" name="note" id="note"rows="3" placeholder="Solusi dari hambatan di atas ...">{{ old('note') ?? $journal->note }}</textarea>
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
                                                <input type="radio" class="custom-control-input" id="sakit{{ $student->id }}" name="status[{{ $student->id }}]" value="s" {{ $student->status == "s" ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="sakit{{ $student->id }}">Sakit</label>
                                            </div>
                                            <div class="custom-control custom-radio mr-3">
                                                <input type="radio" class="custom-control-input" id="izin{{ $student->id }}" name="status[{{ $student->id }}]" value="i" {{ $student->status == "i" ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="izin{{ $student->id }}">Izin</label>
                                            </div>
                                            <div class="custom-control custom-radio mr-3">
                                                <input type="radio" class="custom-control-input" id="alpha{{ $student->id }}" name="status[{{ $student->id }}]" value="a" {{ $student->status == "a" ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="alpha{{ $student->id }}">Alpha</label>
                                            </div>
                                            <div class="form-group col">
                                                <input type="text" class="form-control-sm form-control" id="note_attendance{{ $student->id }}" name="note_attendance[{{ $student->id }}]" placeholder="Catatan Kehadiran" value="{{ $student->note_attendance}}">
                                            </div>
                                            <a title="Reset" type="button" id="reset{{ $student->id }}">
                                                <i data-feather="x-circle" width="14" color="red"></i>
                                            </a>
                                            <script>
                                                $('#reset{{ $student->id }}').on('click', function() {
                                                    $('#sakit{{ $student->id }}').attr('checked', false);
                                                    $('#izin{{ $student->id }}').attr('checked', false);
                                                    $('#alpha{{ $student->id }}').attr('checked', false);
                                                    $('#note_attendance{{ $student->id }}').val("");
                                                })
                                            </script>
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
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var count = 1;
var count_init = 1;
$(document).ready(function () {
    let journal_details = {!! json_encode($journal_details) !!}
    console.log(journal_details);
    count_init++;
        let id_matter_init = $('#id_matter').val();
        let url_init = "{{ route('journal.list-submatter', '') }}"+"/"+id_matter_init;
            axios.get(url_init).then(result => {
                let data_init = result.data;
                console.log(data_init);
                journal_details.map(function(result_journal, index) {
                index++;
                $('#journal_details_group').append('<select id="journal_details'+index+'" name="journal_details[]" class="form-control form-control-sm">'+
                    '<option value="">-- Pilih Sub Materi '+index+' --</option>');
                        data_init.map(function(data_init) {
                            $('#journal_details'+index+'').append('<option value="'+data_init.id+'"'+ (data_init.id === result_journal.id_matter_detail ? 'selected' : '')+'>'+data_init.name+'</option>');
                        })
                })
            })

    $('#id_matter').on('change', function(e) {

        $('select[name="journal_details[]"]').children().not(':first-child').remove();
        
        let id_matter = e.target.value;
        $.ajax({
            url: "{{ route('journal.detail.response') }}",
            type: "POST",
            data: {
                id_matter: id_matter
            },
            success:function(data) {
                $('#journal_details').children().not(':first-child').remove();
                $.each(data, function(key, value){         
                    value.map(function(data) {
                        $('select[name="journal_details[]"]').append('<option class="text-capitalize" value="'+data.idSubMatter+'">'+data.nameSubMatter+'</option>');
                    });
                });
            }
        });
    });

    let next = journal_details.length;
    $('#add_sub_matter').on('click', function() {
        next++
        let id_matter = $('#id_matter').val();
        let url = "{{ route('journal.list-submatter', '') }}"+"/"+id_matter;
            axios.get(url).then(result => {
                let data = result.data;
                $('#journal_details_group').append('<select id="journal_details'+next+'" name="journal_details[]" id="" class="form-control form-control-sm">'+
                    '<option value="">-- Pilih Sub Materi '+next+' --</option>');
                        data.map(function(data) {
                            $('#journal_details'+next+'').append('<option value="'+data.id+'">'+data.name+'</option>');
                        })
            })
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
