@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h5>Daftar Guru</h5>
                <a href="{{ route('ref.teacher.create') }}" class="btn btn-primary-outline">
                    <i width="14" class="mr-2" data-feather="plus"></i>Tambah Guru
                </a>
            </div>
            <div class="card-body">
            @include('layouts.notification')
                <div class="table-responsive">
                    <table class="table table-sm table-hover" id="dtguru">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Username</th>
                                <th>Nama Guru</th>
                                <th>BIdang / Mata Pelajaran</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $no = 1; @endphp
                        @forelse ($teacher_subjects as $ts)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $ts->username }}</td>
                                <td>{{$ts->title_ahead}} {{ $ts->name }}{{$ts->back_title ? ', '.$ts->back_title : '' }}</td>
                                <td>{{ $ts->subjects ? $ts->subjects : '-' }}</td>
                                <td>
                                    <div class="btn-action d-flex justify-content-around">
                                        <a href="{{ route('ref.teacher.edit', $ts->id_teacher) }}">
                                            <i width="14" color="#04396c" data-feather="edit"></i>
                                        </a>
                                        <a title="Delete" id="deleteData" data-toggle="modal" data-target="#deleteModal" data-id="{{ $ts->id_teacher }}" href="#" class="text-danger" data-action="{{ route('ref.teacher.destroy', $ts->id_teacher) }}">
                                            <i width="14" color="red" data-feather="trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center">Data Kosong</td></tr>
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
                            'showdata' => "ref.teacher.show-json",
                            'title_menu' => 'teacher'])
                </div>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function (e) {
        
        $('#dtguru').DataTable({
            "paging":true,
        });
    });
</script>
@endsection
