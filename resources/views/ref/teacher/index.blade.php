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
            @include('layouts.form-search', ['route' => 'ref.teacher.index', 'name' => 'Guru'])
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Username</th>
                                <th>Nama Guru</th>
                                <th>Materi Pelajaran</th>
                                <th>Bidang</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $no = 1; @endphp
                        @forelse ($teacher_subjects as $ts)
                            <tr>
                                <td>{{ $teacher_subjects->no++ }}</td>
                                <td>{{ $ts->uname }}</td>
                                <td>{{ $ts->userName }}</td>
                                <td>{{ $ts->subjectName}}</td>
                                <td>{{ $ts->subject}}</td>
                                <td>
                                    <div class="btn-action d-flex justify-content-around">
                                        <a href="{{ route('ref.teacher.edit', $ts->teacherID) }}">
                                            <i width="14" color="#04396c" data-feather="edit"></i>
                                        </a>
                                        <a title="Delete" id="deleteData" data-toggle="modal" data-target="#deleteModal" data-id="{{ $ts->teacherID }}" href="#" class="text-danger" data-action="{{ route('ref.teacher.destroy', $ts->teacherID) }}">
                                            <i width="14" color="red" data-feather="trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @include('layouts.form-delete', [
                            'method' => 'POST',
                            'methodx' => 'DELETE',
                            'bgDanger' => '',
                            'boxConfirmHeader' => 'box-confirm-header',
                            'textWhite' => '',
                            'title_modal' => 'Delete Data',
                            'showdata' => "ref.teacher.show-json",
                            'title_menu' => 'teacher'])

                        @empty
                            <tr><td colspan="5" class="text-center">Data Kosong</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="table-footer">
                    <p>Menampilkan {{ $teacher_subjects->startNo }} - {{ $teacher_subjects->currentTotal }} dari {{ $teacher_subjects->total() }} data</p>
                    {{ $teacher_subjects->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection