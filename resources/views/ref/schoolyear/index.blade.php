@extends('layouts.app')

@section('content')
<div class="content">
        <div class="card">
            <div class="card-header">
                <h5>Daftar Tahun Ajaran</h5>
                <a href="{{ route('ref.schoolyear.create') }}" class="btn btn-primary-outline">
                    <i width="14" class="mr-2" data-feather="plus"></i>Tambah Tahun Ajaran
                </a>
            </div>
            <div class="card-body">
                @include('layouts.notification')
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tahun Ajaran</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1 @endphp
                            @forelse($schoolyears as $schoolyear)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $schoolyear->name }}</td>
                                <td>{{ $schoolyear->start_date }}</td>
                                <td>{{ $schoolyear->end_date }}</td>
                                @if($schoolyear->status == 0)
                                    <td><p class="badge badge-danger">Tidak Aktif</p></td>
                                @else
                                    <td><p class="badge badge-success">Aktif</p></td>
                                @endif
                                <td>
                                    <div class="btn-action d-flex justify-content-around">
                                        <a href="{{ route('ref.schoolyear.edit', $schoolyear->id) }}">
                                            <i width="14" class="text-primary" data-feather="edit"></i>
                                        </a>
                                        <a title="Delete" id="deleteData" data-toggle="modal" data-target="#deleteModal" data-id="{{ $schoolyear->id }}" href="#" class="text-danger" data-action="{{ route('ref.schoolyear.destroy', $schoolyear->id) }}">
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
                                'showdata' => "ref.schoolyear.show-json",
                                'title_menu' => 'school year'])
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