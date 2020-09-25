@extends('layouts.app')

@section('content')
<div class="content">
        <div class="card">
            <div class="card-header">
                <h5>Daftar Jam Belajar</h5>
                <a href="{{ route('ref.studytime.create') }}" class="btn btn-primary-outline">
                    <i width="14" class="mr-2" data-feather="plus"></i>Tambah Jam Belajar
                </a>
            </div>
            <div class="card-body">
                @include('layouts.notification')
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jam Belajar</th>
                                <th>Waktu</th>
                                <th>Keterangan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1 @endphp
                            @forelse($studytimes as $studytime)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $studytime->name }}</td>
                                <td>{{ $studytime->start_time }} - {{ $studytime->end_time }}</td>
                                <td>{{ $studytime->information }}</td>
                                <td>
                                    <div class="btn-action d-flex justify-content-around">
                                        <a href="{{ route('ref.studytime.edit', $studytime->id) }}">
                                            <i width="14" class="text-primary" data-feather="edit"></i>
                                        </a>
                                        <a title="Delete" id="deleteData" data-toggle="modal" data-target="#deleteModal" data-id="{{ $studytime->id }}" href="#" class="text-danger" data-action="{{ route('ref.studytime.destroy', $studytime->id) }}">
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
                                'showdata' => "ref.studytime.show-json",
                                'title_menu' => 'study time'])
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