@extends('layouts.app')

@section('content')
<div class="content">
    <div class="card">
        <div class="card-header bg-white">
            <h5>Daftar Murid</h5>
            <a href="{{ route('ref.student.create') }}" class="btn btn-primary-outline">
                <i width="14" class="mr-2" data-feather="plus"></i>Tambah Data Murid
            </a>
        </div>
        <div class="card-body">
        @include('layouts.notification')
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Tahun Masuk</th>
                            <th>Tempat Lahir</th>
                            <th>Nama Ayah</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $no = 1; @endphp
                        @forelse ($user_students as $us)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $us->nis }}</td>
                                <td>{{ $us->name }}</td>
                                <td>{{ substr($us->entry_date, 0, 4) }}</td>
                                <td>{{ $us->birth_place }}</td>
                                <td>{{ $us->father_name }}</td>
                                <td>
                                    <div class="btn-action d-flex justify-content-around">
                                        <a href="{{ route('ref.student.edit', $us->id) }}">
                                            <i width="14" color="#04396c" data-feather="edit"></i>
                                        </a>
                                        <a href="#" title="Delete" id="deleteData" data-toggle="modal" data-target="#deleteModal" data-id="{{ $us->id }}" href="#" class="text-danger" data-action="{{ route('ref.student.destroy', $us->id) }}">
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
                            'showdata' => "ref.student.show-json",
                            'title_menu' => 'student'])
                        @empty
                            <tr><td colspan="7" class="text-center">Data Kosong</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection