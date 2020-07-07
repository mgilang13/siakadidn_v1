@extends('layouts.app')

@section('content')
<div class="content">
    <form action="{{ route('core.users.delete.process', $user->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('delete')
        <div class="content-header">
            <h2>User</h2>
            <div class="header-btn">
                <a href="{{ route('core.users') }}" class="btn btn-primary-outline"><i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali</a>
                <button type="submit" class="btn btn-danger">Konfirmasi Hapus</button>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Avatar</h5>
                    </div>
                    @if ($user->image)
                        <img src="{{ asset('storage/' . $user->image) }}" alt="profile" class="img-fluid" width="100%">
                    @endif
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Data User</h5>
                    </div>
                    @include('layouts.notification')
                    <p class="text-danger">
                        * Data yang sudah dihapus tidak dapat dikembalikan. Lanjutkan proses hapus?
                    </p>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="name">Nama Pengguna</label>
                        <div class="col-md-9">
                            <p class="mt-2">{{ $user->name }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="email">Email</label>
                        <div class="col-md-9">
                            <p class="mt-2">{{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="phone">Nomor Handphone</label>
                        <div class="col-md-9">
                            <p class="mt-2">{{ $user->phone }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="username">Username Login</label>
                        <div class="col-md-9">
                            <p class="mt-2">{{ $user->username }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="status">Status</label>
                        <div class="col-md-9">
                            <p class="mt-2">{{ $user->status }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="role">Hak Akses</label>
                        <div class="col-md-9">
                            <p class="mt-2">{{ $user->roles()->first() ? $user->roles()->first()->name : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('form').submit(function (event) {
            event.preventDefault();
            // konfirmasi
            if (confirm('Data yang sudah dihapus tidak dapat dikembalikan. Lanjutkan proses?')) {
                $(this).unbind('submit').submit();
            }
        });
    });
</script>
@endsection