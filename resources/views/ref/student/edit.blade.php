@extends('layouts.app')

@section('content')
<div class="content">
    <form action="{{ route('ref.student.update', $student->id_student) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="content-header">
            <h2>Tambah Siswa</h2>
            <div class="header-btn">
                <a href="{{ route('ref.student.index') }}" class="btn btn-primary-outline">
                    <i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali
                </a>
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
                        <h5>Data Siswa 2</h5>
                    </div>
                    <div class="form-group row">
                        <div class="col input-with-icon d-flex">
                            <i width="18" data-feather="edit-3" class="align-self-center ml-3"></i>
                            <input class="form-control @error('birth_place') is-invalid @enderror" id="birth_place" type="text" name="birth_place" placeholder="Tempat Lahir" value="{{ old('birth_place', $student->user->birth_place) }}">
                            @error('birth_place')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                            <label for="birth_date" class="col-for-label">Tanggal Lahir</label>
                            <input class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" type="date" name="birth_date" placeholder="Tanggal Lahir" value="{{ old('birth_date', $student->user->birth_date) }}">
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="form-group row">
                        <div class="col input-with-icon d-flex">
                            <i width="18" data-feather="align-justify" class="align-self-start ml-3 mt-1"></i>
                            <textarea rows="4" class="form-control @error('address') is-invalid @enderror" id="address" type="text" name="address" placeholder="Alamat">{{ old('address', $student->user->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Data Spesifik Siswa</h5>
                    </div>
                    <div class="form-group row">
                        <div class="col input-with-icon d-flex">
                            <i width="18" data-feather="credit-card" class="align-self-start ml-3 mt-2"></i>
                            <input name="nisn" id="nisn" min="0" type="number" class="form-control" placeholder="NISN" value="{{ old('nisn') ?? $student->nisn }}" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col input-with-icon d-flex">
                            <i width="18" data-feather="credit-card" class="align-self-start ml-3 mt-2"></i>
                            <input name="nis" id="nis" min="0" type="number" class="form-control" placeholder="NIS" value="{{ old('nis') ?? $student->nis }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="entry_date" class="col-for-label">Tanggal Masuk</label>
                        <input name="entry_date" id="entry_date" min="0" type="date" class="form-control" value="{{ old('entry_date') ?? $student->entry_date }}" />
                    </div>

                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Data Siswa 1</h5>
                    </div>
                    <div class="form-group row">
                        <div class="col input-with-icon d-flex">
                            <i width="18" data-feather="edit-3" class="align-self-center ml-3"></i>
                            <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" placeholder="Nama Pengguna" value="{{ old('name') ?? $student->user->name }}" autocomplet="off" >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col input-with-icon d-flex">
                            <i width="18" data-feather="mail" class="align-self-center ml-3"></i>
                            <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" placeholder="Email" value="{{ old('email') ?? $student->user->email}}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col input-with-icon d-flex">
                            <i width="18" data-feather="phone" class="align-self-center ml-3"></i>
                            <input class="form-control @error('phone') is-invalid @enderror" id="phone" type="number" name="phone" placeholder="Phone" value="{{ old('phone') ?? $student->user->phone }}">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col input-with-icon d-flex">
                            <i width="18" data-feather="user" class="align-self-center ml-3"></i>
                            <input class="form-control @error('username') is-invalid @enderror" id="username" type="text" name="username" placeholder="Username Login" value="{{ old('username') ?? $student->user->username }}">
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
                    <p class="mt-n3 font-italic"><small>Kosongkan apabila ingin menggunakan password lama</small></p>
                    <div class="form-group row">
                        <div class="col-4">
                            <select id="gender" name="gender" id="" class="form-control @error('gender') is-invalid @enderror">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="l" {{ (old('gender') ?? $student->user->gender) == "l" ? 'selected' : '' }}>Laki-laki</option>
                                <option value="p" {{ (old('gender') ?? $student->user->gender) == "p" ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <input type="hidden" value="4" name="role">
                </div>
                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Data Halaqah Siswa</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="id_halaqah" id="id_halaqah">Halaqah Tahfidz</label>
                            <select name="id_halaqah" id="id_halaqah" class="form-control @error('id_halaqah') is-invalid @enderror">
                                    <option value="">Kosongkan bila belum ada kelompok</option>
                                @forelse ($halaqahs as $halaqah)
                                    <option value="{{ $halaqah->id }}" {{ (old('id_halaqah') ?? $halaqah->id) == $student->id_halaqah }}>{{ $halaqah->name }}</option>
                                @empty
                                    <option value="">Data Kosong</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="row">
                            <div class="form-group col-6 row">
                                <div class="col input-with-icon d-flex">
                                    <i width="18" data-feather="layers" class="align-self-center ml-3"></i>
                                    <input class="form-control @error('hafalan_pra_idn') is-invalid @enderror" id="hafalan_pra_idn" min="0" max="30" type="number" name="hafalan_pra_idn" placeholder="Hafalan Sebelum Masuk IDN" value="{{ old('hafalan_pra_idn') ?? $student->hafalan_pra_idn }}">
                                    @error('hafalan_pra_idn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-6 row">
                                <div class="col input-with-icon d-flex">
                                    <i width="18" data-feather="layers" class="align-self-center ml-3"></i>
                                    <input class="form-control @error('target_hafalan') @enderror" id="target_hafalan" min="0" max="30" type="number" name="target_hafalan" placeholder="Target Hafalan" value="{{ old('target_hafalan') ?? $student->target_hafalan }}">
                                    @error('target_hafalan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6 row">
                                <div class="col input-with-icon d-flex">
                                    <i width="18" data-feather="align-justify" class="align-self-center ml-3"></i>
                                    <input class="form-control @error('father_name') @enderror" id="father_name" type="text" name="father_name" placeholder="Nama Ayah" value="{{ old('father_name') ?? $student->father_name }}">
                                    @error('father_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-6 row">
                                <div class="col input-with-icon d-flex">
                                    <i width="18" data-feather="align-justify" class="align-self-center ml-3"></i>
                                    <input class="form-control" id="father_job" type="text" name="father_job" placeholder="Pekerjaan Ayah" value="{{ old('father_job') ?? $student->father_job }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6 row">
                                <div class="col input-with-icon d-flex">
                                    <i width="18" data-feather="align-justify" class="align-self-center ml-3"></i>
                                    <input class="form-control" id="mother_name" type="text" name="mother_name" placeholder="Nama Ibu" value="{{ old('mother_name') ?? $student->mother_name }}">
                                </div>
                            </div>
                            <div class="form-group col-6 row">
                                <div class="col input-with-icon d-flex">
                                    <i width="18" data-feather="align-justify" class="align-self-center ml-3"></i>
                                    <input class="form-control" id="mother_job" type="text" name="mother_job" placeholder="Pekerjaan Ibu" value="{{ old('mother_job') ?? $student->mother_job }}">
                                </div>
                            </div>
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