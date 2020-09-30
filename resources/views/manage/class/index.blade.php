@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header bg-white">
                <h1 class="ml-1 h1-responsive">Manajemen Kelas</h1>
            </div>
            
            @include('layouts.notification')
            <div class="card-body flex-wrap d-flex justify-content-between">
                <div class="col-md-6">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <a href="{{ route('manage.class.store') }}" class="btn btn-indigo btn-sm rounded" data-toggle="modal" data-target="#modal" data-type="add" data-title="Atur Kelas" data-method="post">
                                <i width="14" class="mr-2" data-feather="plus"></i>Atur
                            </a>
                        </div>
                        <div>
                            <form method="GET" action="{{ route('manage.class.index') }}">
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
                        <table class="table table-striped table-sm" id="managekelas">
                            <thead class="indigo">
                                <tr>
                                    <th class="text-white">No.</th>
                                    <th class="text-white">Nama Kelas</th>
                                    <th class="text-white">Wali Kelas</th>
                                    <th class="text-white">Tahun Ajar</th>
                                    <th class="text-white">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php $no = 1; @endphp
                            @forelse ($managedClasses as $managedClass)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $managedClass->className }}</td>
                                    <td>{{ $managedClass->title_ahead }} {{ $managedClass->teacherName }} {{ $managedClass->back_title ? ', '.$managedClass->back_title : '' }}</td>
                                    <td>{{ $managedClass->schyearName }}</td>
                                    <td>
                                        <div class="btn-action d-flex justify-content-around">
                                            <a href="{{ route('manage.class.edit', $managedClass->idMC) }}">
                                                <i width="14" color="#04396c" data-feather="edit"></i>
                                            </a>
                                            <a title="Delete" id="deleteData" data-toggle="modal" data-target="#deleteModal" data-id="{{ $managedClass->idMC }}" href="#" class="text-danger" data-action="{{ route('manage.class.destroy', $managedClass->idMC) }}">
                                                <i width="14" color="red" data-feather="trash"></i>
                                            </a>
                                            <a title="Lihat Kelas" href="{{ route('manage.class.show', $managedClass->idMC) }}">
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
                            'showdata' => "manage.class.show-json",
                            'title_menu' => 'managed class'])
                    </div>
                </div>
                @if($mgtClassDetail == null)
                <div class="col-md-5">
                    <h6 class="h6-responsive text-center mt-5">No Data Selected</h6>
                </div>
                @else
                    <div class="col-md-5">
                        <div class="d-flex flex-wrap justify-content-between">
                            <h5 class="mt-3">Ruang Kelas {{ $class->className }}</h5>
                            <a href="{{ route('manage.class.add-student', $class->idMC ) }}" class="btn btn-sm btn-indigo">Tambah Murid</a>
                        </div>
                        <div class="table-responsive shadow p-2">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Siswa</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @forelse ($mgtClassDetail as $student)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->status }}</td>
                                        <td> 
                                            <form method="POST" action="{{ route('manage.class.detail.destroy', $student->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Delete" class="btn btn-sm py-1 px-2">
                                                    <i width="14" color="red" data-feather="trash"></i>
                                                </button>
                                            </form>
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
                @endif
            </div>
        </div>
    </div>
{{-- modal --}}
@include('manage.class.form')
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