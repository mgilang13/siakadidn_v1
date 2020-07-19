@extends('layouts.app')

@section('content')
<div class="content">
    <form action="{{ route('ref.parent.update', $parent->id_parents) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="content-header">
            <h2>Edit Data Orang Tua</h2>
            <div class="header-btn">
                <a href="{{ route('ref.parent.index') }}" class="btn btn-primary-outline"><i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Avatar</h5>
                    </div>
                    <div class="form-group ">
                        <div class="input-with-icon d-flex">
                            <i width="18" data-feather="image" class="align-self-center ml-3"></i>
                            <input type="file" name="image" id="avatar_image" accept="image/*" class="form-control">
                        </div>
                        @if($parent->user->image_medium == null)
                             <img id="avatar_preview" src="" alt="Preview Avatar">
                        @else
                        <div class="card-body">
                            <a href="#" id="avatar-preview-click">
                                <img id="avatar_preview" src="{{ asset('storage/'.$parent->user->image_medium) }}" alt="Preview Avatar">
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Data Orang Tua 2</h5>
                    </div>
                    <div class="form-group ">
                        <select name="id_student" id="student" class="form-control @error('id_student') is-invalid @enderror">
                            <option value="">-- Orang Tua Dari --</option>
                        @forelse($students as $student)
                            <option value="{{ $student->id_student }}" {{ (old('id_student') ?? $student->id_student) == $parent->id_student ? 'selected' : '' }}>{{ $student->name }}</option>
                        @empty
                            <option >No Data</option>
                        @endforelse  
                        </select>
                    </div>
                    <div class="form-group ">
                        <div class="col input-with-icon d-flex">
                            <i width="18" data-feather="edit-3" class="align-self-center ml-3"></i>
                            <input class="form-control @error('birth_place') is-invalid @enderror" id="birth_place" type="text" name="birth_place" placeholder="Tempat Lahir" value="{{ old('birth_place, $parent->user->birth_place') }}">
                            @error('birth_place')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                            <label for="birth_date" class="col-for-label">Tanggal Lahir</label>
                            <input class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" type="date" name="birth_date" placeholder="Tanggal Lahir" value="{{ old('birth_date', $parent->user->birth_date) }}">
                           
                    </div>
                    <div class="form-group ">
                        <div class="col input-with-icon d-flex">
                            <i width="18" data-feather="align-justify" class="align-self-start ml-3 mt-1"></i>
                            <textarea rows="4" class="form-control @error('address') is-invalid @enderror" id="address" type="text" name="address" placeholder="Alamat">{{ old('address', $parent->user->address) }}</textarea>
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
                        <h5>Data Orang Tua 1</h5>
                    </div>
                    <div class="form-group ">
                        <div class="col input-with-icon d-flex">
                            <i width="18" data-feather="edit-3" class="align-self-center ml-3"></i>
                            <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" placeholder="Nama Pengguna" value="{{ old('name', $parent->user->name) }}" autocomplet="off" autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col input-with-icon d-flex">
                            <i width="18" data-feather="mail" class="align-self-center ml-3"></i>
                            <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" placeholder="Email" value="{{ old('email', $parent->user->email) }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col input-with-icon d-flex">
                            <i width="18" data-feather="phone" class="align-self-center ml-3"></i>
                            <input class="form-control @error('phone') is-invalid @enderror" id="phone" type="number" name="phone" placeholder="Phone" value="{{ old('phone', $parent->user->phone) }}">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col input-with-icon d-flex">
                            <i width="18" data-feather="user" class="align-self-center ml-3"></i>
                            <input class="form-control @error('username') is-invalid @enderror" id="username" type="text" name="username" placeholder="Username Login" value="{{ old('username', $parent->user->username) }}">
                            @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col input-with-icon d-flex">
                        `   <i width="18" data-feather="key" class="align-self-center ml-3"></i>
                            <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" placeholder="Password Login">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <p class="ml-3 font-italic"><small>Kosongkan apabila ingin menggunakan password lama</small></p>
                    </div>
                    <div class="form-group ">
                        <div class="col-4">
                            <select id="gender" name="gender" id="" class="form-control @error('gender') is-invalid @enderror">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="l" {{ (old('gender') ?? $parent->user->gender) == "l" ? 'selected' : '' }}>Laki-laki</option>
                                <option value="p" {{ (old('gender') ?? $parent->user->gender) == "p" ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <input type="hidden" value="4" name="role">
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('js')

<script>
   $(document).ready(function(){
    $('#avatar_preview[src=""]').hide();    
    $('#identity_preview[src=""]').hide();    
});

function previewAvatar(input) {
    if(input.files && input.files[0]) {
        let reader = new FileReader();

        $('#avatar_preview').show(); 
        reader.onload = function(e) {
            $('#avatar_preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$('#avatar_image').change(function() {
        previewAvatar(this);
    });

</script>

@endsection