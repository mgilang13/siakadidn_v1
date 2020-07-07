@extends('layouts.app')

@section('content')
<div class="content">
    <form action="{{ route('core.users.add.process') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="content-header">
            <h2>Tambah User</h2>
            <div class="header-btn">
                <a href="{{ route('core.users') }}" class="btn btn-primary-outline"><i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Avatar</h5>
                    </div>
                    <div class="form-group row">
                        <div class="input-with-icon d-flex">
                            <i width="18" data-feather="image" class="align-self-center ml-3"></i>
                            <input type="file" name="image" id="avatar_image" accept="image/*" class="form-control">
                        </div>
                        <div class="card-body" id="avatar-preview-body">
                            <a href="#" id="avatar-preview-click">
                                <img id="avatar_preview" src="" alt="Preview Avatar">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Data User 2</h5>
                    </div>
                    <div class="form-group row">
                        <div class="col input-with-icon d-flex">
                            <i width="18" data-feather="edit-3" class="align-self-center ml-3"></i>
                            <input class="form-control @error('birth_place') is-invalid @enderror" id="birth_place" type="text" name="birth_place" placeholder="Tempat Lahir" value="{{ old('birth_place') }}">
                            @error('birth_place')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col input-with-icon d-flex">
                            <i width="18" data-feather="calendar" class="align-self-center ml-3"></i>
                            <input class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" type="date" name="birth_date" placeholder="Tanggal Lahir" value="{{ old('birth_date') }}">
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col input-with-icon d-flex">
                            <i width="18" data-feather="align-justify" class="align-self-start ml-3 mt-1"></i>
                            <textarea rows="4" class="form-control @error('address') is-invalid @enderror" id="address" type="text" name="address" placeholder="Alamat">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Data User 1</h5>
                    </div>
                    <div class="form-group row">
                        <div class="col input-with-icon d-flex">
                            <i width="18" data-feather="edit-3" class="align-self-center ml-3"></i>
                            <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" placeholder="Nama Pengguna" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col input-with-icon d-flex">
                            <i width="18" data-feather="mail" class="align-self-center ml-3"></i>
                            <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col input-with-icon d-flex">
                            <i width="18" data-feather="phone" class="align-self-center ml-3"></i>
                            <input class="form-control @error('phone') is-invalid @enderror" id="phone" type="number" name="phone" placeholder="Phone" value="{{ old('phone') }}">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col input-with-icon d-flex">
                            <i width="18" data-feather="user" class="align-self-center ml-3"></i>
                            <input class="form-control @error('username') is-invalid @enderror" id="username" type="text" name="username" placeholder="Username Login" value="{{ old('username') }}">
                            @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col input-with-icon d-flex">
                        `   <i width="18" data-feather="key" class="align-self-center ml-3"></i>
                            <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" placeholder="Password Login">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-4">
                            <select id="gender" name="gender" id="" class="form-control @error('role') @enderror">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="l" {{ old('gender') == "l" ? selected : '' }}>Laki-laki</option>
                                <option value="p" {{ old('gender') == "p" ? selected : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class="col-4">
                            <select id="role" name="role" class="form-control @error('role') is-invalid @enderror">
                                <option value="">-- Pilih Hak Akses --</option>
                                @foreach ($rs_role as $role)
                                <option value="{{ $role->id }}" @if (old('role', '' )==$role->id ) selected @endif>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
    $('#avatar_image').change(function() {
        previewAvatar(this);
    });
    
    function previewAvatar(input) {
        let avatar_body = document.getElementById('avatar-preview-body');
        avatar_body.style.display = "block";
        if(input.files && input.files[0]) {
            let reader = new FileReader();

            reader.onload = function(e) {
                $('#avatar_preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection