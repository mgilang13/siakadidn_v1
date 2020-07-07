@extends('layouts.app')

@section('content')
<div class="content">
    <form action="{{ route('profile.update.process') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="content-header">
            <h2>Ubah Profile</h2>
            <div class="header-btn">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Avatar</h5>
                    </div>
                    <div class="input-with-icon">
                        <i width="18" data-feather="image" class="mr-15"></i>
                        <input type="file" name="image" id="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @if (Auth::user()->image)
                        <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="profile" class="img-fluid" width="100%">
                    @endif
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Data User</h5>
                    </div>
                    @include('layouts.notification')
                    <div class="form-group input-with-icon">
                        <i width="18" data-feather="edit-3" class="mr-15"></i>
                        <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" placeholder="Nama Pengguna" value="{{ old('name', Auth::user()->name) }}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group input-with-icon">
                        <i width="18" data-feather="align-center" class="mr-15"></i>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" placeholder="Email" value="{{ old('email', Auth::user()->email) }}">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group input-with-icon">
                        <i width="18" data-feather="phone" class="mr-15"></i>
                        <input class="form-control @error('phone') is-invalid @enderror" id="phone" type="text" name="phone" placeholder="Nomor Handphone" value="{{ old('phone', Auth::user()->phone) }}">
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group input-with-icon">
                        <i width="18" data-feather="user" class="mr-15"></i>
                        <input class="form-control @error('username') is-invalid @enderror" id="username" type="text" name="username" placeholder="Username Login" value="{{ old('username', Auth::user()->username) }}">
                        @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group input-with-icon">
                        <i width="18" data-feather="key" class="mr-15"></i>
                        <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" placeholder="Password Login">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <i class="text-muted">* Kosongkan jika password tidak diganti</i>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection