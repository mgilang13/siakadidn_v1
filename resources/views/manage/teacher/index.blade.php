@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header bg-white">
                <h1 class="ml-1 h1-responsive">Manajemen Guru</h1>
            </div>
            
            @include('layouts.notification')
            <div class="card-body flex-wrap d-flex justify-content-between">
                <div class="col-md-6">
                    <h4>Daftar Guru</h4>
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <a href="{{ route('manage.teacher.store') }}" class="btn btn-indigo btn-sm rounded" data-toggle="modal" data-target="#modal" data-type="add" data-title="Atur Guru" data-method="post">
                                <i width="14" class="mr-2" data-feather="plus"></i>Atur
                            </a>
                        </div>
                        <div>
                            <form method="GET" action="{{ route('manage.teacher.index') }}">
                                <div class="form-group">
                                    <select name="id_level" id="" class="form-control-sm form-control">
                                        <option value="">-- Jenjang Pendidikan --</option>
                                        @forelse($levels as $level)
                                        <option value="{{ $level->id }}" {{ (old('id_level') ?? $level->id) == $qLevel ? 'selected' : '' }}>{{ $level->name }}</option>
                                        @empty
                                        <option value="">Belum ada data</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="id_level_detail" id="" class="form-control-sm form-control">
                                        <option value="">-- Detail Jenjang --</option>
                                        @forelse($level_details as $level_detail)
                                        <option value="{{ $level_detail->id }}" {{ (old('id_level_detail') ?? $level_detail->id) == $qLevelDt ? 'selected' : '' }}>{{ $level_detail->name }}</option>
                                        @empty
                                        <option value="">Belum ada data</option>
                                        @endforelse
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-sm btn-indigo">Search</button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive shadow p-2">
                        <table class="table table-striped table-sm" id="manageTeacher">
                            <thead class="indigo">
                                <tr>
                                    <th class="text-white">No.</th>
                                    <th class="text-white">Nama Guru</th>
                                    <th class="text-white">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php $no = 1; @endphp
                            @forelse($managedTeachers as $mt)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $mt->name }}</td>
                                <td>
                                    <div class="btn-action d-flex justify-content-around">
                                        <a href="{{ route('manage.teacher.edit', $mt->idMT) }}">
                                            <i width="14" color="#04396c" data-feather="edit"></i>
                                        </a>
                                        <a title="Delete" id="deleteData" data-toggle="modal" data-target="#deleteModal" data-id="{{ $mt->idMT }}" href="#" class="text-danger" data-action="{{ route('manage.teacher.destroy', $mt->idMT) }}">
                                            <i width="14" color="red" data-feather="trash"></i>
                                        </a>
                                        <a title="Lihat Kelas" href="{{ route('manage.teacher.show', $mt->idMT) }}">
                                            <i width="14" color="#04396c" data-feather="chevron-right"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Data Kosong!</td>
                            </tr>
                            @endforelse
                            </tbody>
                        </table>
                        @include('layouts.form-delete', [
                            'method' => 'POST',
                            'methodx' => 'DELETE',
                            'bgDanger' => '',
                            'boxConfirmHeader' => 'box-confirm-header',
                            'textWhite' => '',
                            'title_modal' => 'Delete Data',
                            'showdata' => "manage.teacher.show-json",
                            'title_menu' => 'managed teacher'])
                    </div>
                </div>
                @if($mgtTeacherClass == null)
                <div class="col-md-5">
                    <h6 class="h6-responsive text-center mt-5">No Data Selected</h6>
                </div>
                @else
                <div class="col-md-5">
                    <div>
                        <div class="d-flex flex-wrap justify-content-between">
                            <h5 class="mt-3">Kelas yang diajar</h5>
                            <a href="{{ route('manage.teacher.add-class', $id) }}" class="btn btn-sm btn-indigo">Tambah Kelas</a>
                        </div>
                        <div class="table-responsive shadow p-2">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Kelas</th>
                                        <th>Instansi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @forelse ($mgtTeacherClass as $mtc)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $mtc->className }}</td>
                                        <td><span class="text-uppercase">{{ $mtc->levelAbbr }}</span> {{ $mtc->levelDetailName }}</td>
                                        <td>
                                            <div class="btn-action d-flex justify-content-around">
                                                <a href="#">
                                                    <i width="14" color="#04396c" data-feather="edit"></i>
                                                </a>
                                                <a href="#">
                                                    <i width="14" color="red" data-feather="trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>    
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada data</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
{{-- modal --}}
@include('manage.teacher.form')
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
});
</script>
@endsection