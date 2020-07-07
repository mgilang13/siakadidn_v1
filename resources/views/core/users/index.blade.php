@extends('layouts.app')

@section('content')
<div class="content">
    <div class="card">
        <div class="card-header">
            <h5>Daftar User</h5>
            <a href="{{ route('core.users.add') }}" class="btn btn-primary-outline">
                <i width="14" class="mr-2" data-feather="plus"></i>Tambah User
            </a>
        </div>
        @include('layouts.notification')
        <form action="{{ route('core.users') }}" method="get">
            <div class="form-group row justify-content-center mt-3">
                <label class="col-2 d-flex justify-content-end col-form-label" for="q">Cari User</label>
                <div class="col-md-3">
                    <input class="form-control" id="q" type="text" name="q" placeholder="Nama, Email / Nomor HP User" value="{{ $q }}">
                </div>
                <div class="col-md-1">
                    <button class="btn btn-outline-secondary" type="submit" id="button-search">
                        <i width="14" class="" data-feather="search"></i>
                    </button>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="25">No</th>
                        <th>Nama User</th>
                        <th width="300">Email</th>
                        <th width="300">HP</th>
                        <th width="100"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rs_user as $user)
                        <tr>
                            <td class="text-center">{{ $rs_user->no++ }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>
                                @if ($user->id != 1)
                                    <div class="btn-action d-flex justify-content-around">
                                        <a href="{{ route('core.users.edit', $user->id) }}">
                                            <i width="14" data-feather="edit"></i>
                                        </a>
                                        <a href="{{ route('core.users.delete', $user->id) }}" class="text-danger">
                                            <i width="14" data-feather="trash"></i>
                                        </a>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="5">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="table-footer">
            <p>Menampilkan {{ $rs_user->startNo }} - {{ $rs_user->currentTotal }} dari {{ $rs_user->total() }} data</p>
            {{ $rs_user->onEachSide(1)->links() }}
        </div>
    </div>
</div>
@endsection