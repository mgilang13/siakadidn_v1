@extends('layouts.app')

@section('content')
<div class="content">
        <div class="card">
            <div class="card-header">
                <h5>Daftar Hari</h5>
                <a href="{{ route('ref.day.create') }}" class="btn btn-primary-outline">
                    <i width="14" class="mr-2" data-feather="plus"></i>Tambah Hari
                </a>
            </div>
            <div class="card-body">
                @include('layouts.notification')
                <div class="table-responsive col-md-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Hari</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1 @endphp
                            @forelse($days as $day)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $day->name }}</td>
                                <td>
                                    <div class="btn-action d-flex justify-content-around">
                                        <a href="{{ route('ref.day.edit', $day->id) }}">
                                            <i width="14" class="text-primary" data-feather="edit"></i>
                                        </a>
                                        <a title="Delete" id="deleteData" data-toggle="modal" data-target="#deleteModal" data-id="{{ $day->id }}" href="#" class="text-danger" data-action="{{ route('ref.day.destroy', $day->id) }}">
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
                                'showdata' => "ref.day.show-json",
                                'title_menu' => ''])
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