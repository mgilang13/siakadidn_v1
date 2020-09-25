@extends('layouts.app')

@section('content')
<div class="content">
        <div class="card">
            <div class="card-header">
                <h5>Daftar Semester</h5>
                <a href="{{ route('ref.semester.create') }}" class="btn btn-primary-outline">
                    <i width="14" class="mr-2" data-feather="plus"></i>Tambah Semester
                </a>
            </div>
            <div class="card-body">
                @include('layouts.notification')
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Semester</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1 @endphp
                            @forelse($semesters as $semester)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td class="text-capitalize">{{ $semester->name }}</td>
                                <td>{{ $semester->information }}</td>
                                @if($semester->status == 0)
                                    <td><p class="badge badge-danger">Tidak Aktif</p></td>
                                @else
                                    <td><p class="badge badge-success">Aktif</p></td>
                                @endif
                                <td>
                                    <div class="btn-action d-flex justify-content-around">
                                        <a href="{{ route('ref.semester.edit', $semester->id) }}">
                                            <i width="14" class="text-primary" data-feather="edit"></i>
                                        </a>
                                        <a title="Delete" id="deleteData" data-toggle="modal" data-target="#deleteModal" data-id="{{ $semester->id }}" href="#" class="text-danger" data-action="{{ route('ref.semester.destroy', $semester->id) }}">
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
                                'showdata' => "ref.semester.show-json",
                                'title_menu' => 'semester'])
                            @empty
                            <tr><td colspan="5" class="text-center">Data Kosong!</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>
@endsection