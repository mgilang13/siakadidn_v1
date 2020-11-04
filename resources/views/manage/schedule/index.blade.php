@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header bg-white">
                <h1 class="ml-1 h1-responsive">Jadwal Pelajaran {{ $className ? 'Kelas '.$className->name : ''}}</h1>
                <a href="{{ route('manage.schedule.create') }}" class="btn btn-primary-outline">
                    <i width="14" class="mr-2" data-feather="plus"></i>Tambah Jadwal
                </a>
            </div>
            @include('layouts.notification')
            <div class="card-body">
                <form action="{{ route('manage.schedule.index') }}" class="mb-5" id="form-search">
                    <div class="d-flex flex-wrap col-md-10 align-items-center">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="id_schoolyear" id="" class="form-control">
                                    <option value="">-- Pilih Tahun Ajaran --</option>
                                    @foreach($schoolyears as $schoolyear)
                                    <option value="{{ $schoolyear->id }}" {{ $schoolyear->status == 1 ? 'selected' : ''}}>{{$schoolyear->name}} {{$schoolyear->status == 1 ? '(Aktif)' : '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="id_semester" id="id_semester" class="form-control text-capitalize">
                                    <option value="">-- Pilih Semester --</option>
                                    @forelse($semesters as $semester)
                                    <option value="{{ $semester->id }}" {{ $semester->status == 1 ? 'selected' : '' }}>{{ $semester->name}} {{ $semester->status == 1 ? '(Aktif)' : '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="id_level_detail" id="id_level_detail" class="form-control">
                                    <option value="">-- Pilih Detail Jenjang --</option>
                                    @foreach ($level_details as $level_detail)
                                    <option value="{{ $level_detail->id }}">{{ $level_detail->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="id_level" id="id_level" class="form-control">
                                    <option class="text-capitalize" value="">-- Pilih Jenjang --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="grade" id="grade" class="form-control">
                                    <option value="">-- Pilih Tingkat --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="id_class" id="id_class" class="form-control">
                                    <option value="">-- Pilih Kelas --</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-indigo rounded"> Search</button>
                    </div>
                </form>
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
                            @forelse($schedules as $studytime => $days)
                                <tr>
                                    <th class="text-white blue accent-2 font-weight-bold text-center" width="25">
                                        {{ $studytime }}
                                    </th>
                                    @foreach($days as $day => $value)
                                        @if(is_array($value))
                                            <td rowspan="{{ $value['rowspan'] }}" class="align-middle text-center blue lighten-4 border border-primary">
                                                {{ $value['subjectName'] }} <br>
                                                <a class="mr-2" href="{{ route('manage.schedule.update', $value['id']) }}" data-toggle="modal" data-target="#modal" data-type="edit" data-title="Ubah Jadwal" data-method="patch">
                                                    <i width="14" data-feather="edit"></i>
                                                </a>
                                                <a href="#" title="Delete" id="deleteData" data-toggle="modal" data-target="#deleteModal" data-id="{{ $value['id'] }}" class="text-danger" data-action="{{ route('manage.schedule.destroy', $value['id']) }}" >
                                                    <i class="fas fa-times red-text"></i>
                                                </a>
                                                <textarea class="jsons d-none">{{ json_encode($value['schedule_detail']) }}</textarea>
                                            </td>
                                        @elseif ($value == 1)
                                            <td class="align-middle text-center">
                                                <a 
                                                    href="{{ route('manage.schedule.store') }}" 
                                                    class="px-3 btn border border-primary waves-effect btn-sm" 
                                                    data-id_day="{{ $day }}" 
                                                    data-id_studytime_start="{{ $studytime }}" 
                                                    data-toggle="modal" 
                                                    data-target="#modal" 
                                                    data-type="add" 
                                                    data-title="Tambah Jadwal" 
                                                    data-method="post">
                                                    <i class="fas fa-plus text-primary"></i>
                                                </a>
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            @empty
                            <tr>
                                <td colspan="7">No Schedule Class Selected</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Form Delete Schedule  -->
    @include('layouts.form-delete', [
            'method' => 'POST',
            'methodx' => 'DELETE',
            'bgDanger' => 'bg-danger',
            'boxConfirmHeader' => '',
            'textWhite' => 'text-white',
            'title_modal' => 'Delete Data Permanently',
            'showdata' => "manage.schedule.show-json",
            'title_menu' => 'data schedule'])

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        let url = window.location.href;
        
        // console.log(url);
        
        $('#form-search').on('submit', function(e) {
            var url = window.location.href;
            console.log(url); 
        });

        $('#id_level_detail').on('change', function(e) {
            $('#id_level').children().not(':first-child').remove();
            $('#grade').children().not(':first-child').remove();
            $('#id_class').children().not(':first-child').remove();

            let id_level_detail = e.target.value;
            $.ajax({
                url: "{{ route('manage.schedule.level.response') }}",
                type: "POST",
                data: {
                    id_level_detail: id_level_detail
                },
                success:function(data) {
                    $.each(data, function(key, value){         
                        value.map(function(data) {
                            $('select[name="id_level"]').append('<option class="text-uppercase" value="'+data.id+'" {{ (old('id_level') ?? "'+data.id+'") == $qLevel ? 'selected' : '' }}>'+data.levelName+'</option>');
                        });
                    });
                }
            });
            // $('#id_level').empty();
        });

        $('#id_level').on('change', function(e) {

            $('#grade').children().not(':first-child').remove();
            $('#id_class').children().not(':first-child').remove();

            let id_level = e.target.value;
            $.ajax({
                url: "{{ route('manage.schedule.grade.response') }}",
                type: "POST",
                data: {
                    id_level: id_level
                },
                success:function(data) {
                    $.each(data, function(key, value){         
                        value.map(function(data) {
                            console.log(data);
                            $('select[name="grade"]').append('<option class="text-uppercase" value="'+data.gradeID+'">'+data.gradeName+'</option>');
                        });
                    });
                }
            });
        });

        $('#grade').on('change', function(e) {
            
            $('#id_class').children().not(':first-child').remove();

            let grade = e.target.value;
            $.ajax({
                url: "{{ route('manage.schedule.class.response') }}",
                type: "POST",
                data: {
                    grade: grade
                },
                success:function(data) {
                    $.each(data, function(key, value){         
                        value.map(function(data) {
                            console.log(data);
                            $('select[name="id_class"]').append('<option class="text-uppercase" value="'+data.idClass+'">'+data.nameClass+'</option>');
                        });
                    });
                }
            });
        });

       
    });
</script>
{{-- modal --}}
@include('manage.schedule.form')
@endsection

@section('js')
<script>
$(document).ready(function () {
    // modal 
    $('#modal').on('shown.bs.modal', function (event) {
        $('#name').trigger('focus');
    });
    $('#modal').on('show.bs.modal', function (event) {
        const target = $(event.relatedTarget);
        $('#modalLabel').html(target.attr('data-title'));
        $('#id_day').val(target.attr('data-id_day')).css("pointer-events", "none");
        
        $('#id_studytime_start').val(target.attr('data-id_studytime_start')).css("pointer-events", "none");
        // let id_studytime_end = target.attr('data-id_studytime_start');
        
        // for(let i = id_studytime_end; i <=10; i++) {
        //     $('select[name="id_studytime_end"]').append('<option value="'+i+'">'+i+'</option>');
        // }
        // cek tipe
        
        if (target.attr('data-type') == 'edit') {
            // set data
            var jsons = JSON.parse( target.closest('td').find('.jsons').val() );
            // console.log(jsons.id_studytime_end);
            $('#name').val(jsons.name);
            $('#id_day').attr('readonly', false);
            $('#id_day').css('pointer-events', 'auto');
            $('#id_day').val(jsons.id_day);

            $('#id_studytime_start').attr('readonly', false);
            $('#id_studytime_start').css('pointer-events', 'auto');
            $('#id_studytime_start').val(jsons.id_studytime_start);

            $('#id_studytime_end').val(jsons.id_studytime_end);
            $('#id_subject').val(jsons.id_subject);
            $('#id_semester').val(jsons.id_semester);
            $('#id_schoolyear').val(jsons.id_schoolyear);
        }

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
                        $('select[name="id_subject"]').append('<option value="'+data.subjectID+'">'+data.subjectName+'</option>');
                    });
                });
            }
        });
    });
});
</script>
@endsection