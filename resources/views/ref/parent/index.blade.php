@extends('layouts.app')

@section('content')
<div class="content">
        <div class="card">
            <div class="card-header bg-white">
                <h5>Daftar Orang Tua Santri IDN</h5>
                <a href="{{ route('ref.parent.create') }}" class="btn btn-primary-outline">
                    <i width="14" class="mr-2" data-feather="plus"></i>Tambah Data Orang Tua
                </a>
            </div>
            <div class="card-body">
                @include('layouts.notification')
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Orang Tua</th>
                                <th>Orang Tua dari</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $no = 1 @endphp
                           @forelse($parents as $parent)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $parent->namaorangtua }}</td>
                                <td>{{ $parent->namasiswa }}</td>
                                <td>
                                    <div class="btn-action d-flex justify-content-around">
                                        <a href="{{ route('ref.parent.edit', $parent->id_parents) }}">
                                            <i data-feather="edit" class="text-primary" width="14"></i>
                                        </a>
                                        <a title="Delete" id="deleteData" data-toggle="modal" data-target="#deleteModal" data-id="{{ $parent->id_parents }}" href="#" class="text-danger" data-action="{{ route('ref.parent.destroy', $parent->id_parents) }}">
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
                            'showdata' => "ref.parent.show-json",
                            'title_menu' => 'parent'])
                           @empty
                           <tr><td colspan="4" class="text-center"><p>Data Kosong!</p></td></tr>
                           @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>
@endsection