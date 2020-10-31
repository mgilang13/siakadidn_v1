@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header bg-white">
                <h3 class="ml-1 h3-responsive">Jadwal Mengajar <span class="font-weight-bold">{{ $teacher->name }}</span> di Kelas <span class="font-weight-bold">{{ $classroom->name }}</span> </h3>
                <a href="{{ route('journal.index') }}" class="btn btn-outline-primary">
                    <i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-sm table table-bordered table-striped">
                        <thead class="deep-purple accent-4">
                            <tr>
                                <td class="font-weight-bold px-2 text-uppercase blue accent-4 text-white">Jam</td>
                                @foreach($days as $day)
                                <th class="text-white px-2 text-center">{{ $day->name }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($journal_schedules as $studytime => $days)
                                <tr>
                                    <th class="text-white blue accent-2 font-weight-bold text-center" width="25">
                                        {{ $studytime }}
                                    </th>
                                    @foreach($days as $day => $value)
                                        @if(is_array($value))
                                            <td rowspan="{{ $value['rowspan'] }}" class="align-middle text-center blue lighten-4 border border-primary">
                                                <p>{{ $value['subjectName'] }}</p>
                                                <a  href="{{ route('journal.store') }}"
                                                    id="journal-btn{{ $value['idSchedule'] }}"
                                                    class="px-2 btn btn-primary btn-sm" 
                                                    data-id_schedule="{{ $value['idSchedule'] }}"
                                                    data-id_subject="{{ $value['idSubject'] }}"
                                                    data-subject_name="{{ $value['subjectName'] }}"
                                                    data-matter = "{{ $value['idSubject'] }},{{ $value['idLevel']}}"
                                                    data-toggle="modal" 
                                                    data-target="#modal" 
                                                    data-type="add" 
                                                    data-title="Tambah Jurnal" 
                                                    data-method="post">
                                                    <i class="mr-2 fas fa-plus"></i>Jurnal
                                                </a>
                                                <a  href="{{ route('journal.show', $value['idSchedule']) }}" 
                                                    target="_blank"
                                                    class="btn btn-secondary btn-sm px-2">
                                                    <i class="mr-2 fas fa-eye"></i>Jurnal
                                                </a>
                                                <script>
                                                $("#journal-btn{{ $value['idSchedule']}}").on('click', function() {
                                                    $('select[name="id_matter"]').children().not(':first-child').remove();
                                                    let matter = $("#journal-btn{{ $value['idSchedule'] }}").data('matter');
                                                    let url = "{{ route('journal.list-matter', '') }}"+'/'+matter;
                                                    console.log(matter);
                                                    console.log(url);
                                                    axios.get(url).then(result => {
                                                        let data = result.data;         
                                                        data.map(function(data) {
                                                            $('#id_matter').append('<option value="'+data.id+'">'+data.name+'</option>');
                                                        });
                                                    });
                                                });
                                                </script>
                                            </td>
                                        @elseif ($value == 1)
                                            <td></td>
                                        @endif
                                    @endforeach
                                </tr>
                            @empty
                            <tr>
                                <td colspan="7">Belum punya jadwal</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
{{-- modal --}}
@include('journal.form')
@endsection

@section('js')
<script>
 $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var count = 1;

$(document).ready(function () {
   

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

            $('#journal_details_group').append('<input id="journal_details_other" type="text" name="journal_details_other[]" class="form-control form-control-sm" placeholder="Lain-lain">');
        });

    $('#journal_details').on('change', function() {
        let journal_details = $('#journal_details').val();
            console.log(journal_details);
            if(journal_details === "") {
                $('#journal_details_other').prop("disabled", false);
            } else {
                $('#journal_details_other').prop("disabled", true);
            }
    });
    
    $('#add_sub_matter').on('click', function() {
        count++;
        let id_matter = $('#id_matter').val();
        let url = "{{ route('journal.list-submatter', '') }}"+"/"+id_matter;
            axios.get(url).then(result => {
                let data = result.data;
                $('#journal_details_group').append('<select id="journal_details'+count+'" name="journal_details[]" class="form-control form-control-sm">'+
                    '<option value="">-- Pilih Sub Materi '+count+' --</option>');
                        data.map(function(data) {
                                $('#journal_details'+count+'').append('<option value="'+data.id+'">'+data.name+'</option>');
                        });
                        $('#journal_details_group').append('<input type="text" id="journal_details_other'+count+'" name="journal_details_other[]" class="form-control form-control-sm" placeholder="Lain-lain">');
                        
                        $('#journal_details'+count+'').on('change', function() {
                            let journal_details = $('#journal_details'+count+'').val();
                            if(journal_details === "") {
                                $('#journal_details_other'+count+'').prop("disabled", false);
                            } else {
                                $('#journal_details_other'+count+'').prop("disabled", true);
                            }
                        });
            })
        
    })
});
</script>
<script>
function cancelSubMateri() {
    count--;
    $('#journal_details_group').children().last().remove();
}

$(document).ready(function () {
    // modal 
    $('.modal').on('hidden.bs.modal', function(){
        $(this)
        .find("textarea,select")
        .val('')
        .end()
        .find("input[type=checkbox], input[type=radio]")
        .prop("checked", "")
        .end()
    });

    $('#modal').on('shown.bs.modal', function (event) {
        $('#teaching_date').trigger('focus');
    });
    $('#modal').on('show.bs.modal', function (event) {
        const target = $(event.relatedTarget);

        $('#modalLabel').html(target.attr('data-title'));
        $('#subjectName').html(target.attr('data-subject_name'));

        $('#id_schedule').val(target.attr('data-id_schedule'));
        
        $('#modal').closest('form').attr('action', target.attr('href'));
        $('#modal').closest('form').attr('method', target.attr('data-method'));
    });

    $('#modal').closest('form').submit(function (event) {
        event.preventDefault();
        // elem
        const elem = $(this);
        const submit = elem.find('[type="submit"]');
        submit.prop('disabled', true);
        // ajax
        axios({
            method: elem.attr('method'),
            url: elem.attr('action'),
            data: elem.serialize()
        })
            .then(result => window.location.reload())
            .catch(error => {
                try {
                    const errors = error.response.data.errors;
                    Object.keys(errors).forEach(key => {
                        const elem = $(`#${key}`)
                        const err = errors[key][0] || 'Error';
                        elem.addClass('is-invalid')
                        $(`#${key}-message`).html(err);
                    })
                } catch (error) {}
            })
            .finally(() => submit.prop('disabled', false));
    });

    $('#id_teacher').on('change', function(e) {
        let id_teacher = e.target.value;
        $.ajax({
            url: "{{ route('manage.schedule.subject.byteacher') }}",
            type: "POST",
            data: {
                id_teacher: id_teacher
            },
            success:function(data) {
                $.each(data, function(key, value){         
                    value.map(function(data) {
                        $('select[name="id_matter"]').append('<option value="'+data.matterID+'">'+data.matterName+'</option>');
                    });
                });
            }
        });
    });
});
</script>
@endsection