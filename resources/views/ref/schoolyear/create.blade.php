@extends('layouts.app')

@section('content')
<div class="content">
    <h2>Tambah Tahun Ajaran</h2>
    <form action="{{ route('ref.schoolyear.store') }}" method="POST">
        @csrf
        <div class="content-header d-flex justify-content-end">
                <div class="header-btn">
                    <a href="{{ route('ref.schoolyear.index') }}" class="btn btn-primary-outline"><i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-body row">
                    <div class="col-md-4">
                        <div class="form-group row">
                            <div class="col input-with-icon d-flex">
                                <i width="18" data-feather="calendar" class="align-self-center ml-3"></i>
                                <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" placeholder="Tahun Ajaran" value="{{ old('name') }}" autofocus>
                                
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <div class="col input-with-icon d-flex">
                                <select name="semester" id="semester" class="form-control @error('semester') is-invalid @enderror">
                                    <option value="">-- Pilih Semester --</option>
                                    <option value="1">Semester Ganjil</option>
                                    <option value="2">Semester Genap</option>
                                </select>
                                @error('semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <div class="col input-with-icon d-flex">
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="0">Tidak AKtif</option>
                                    <option value="1">Aktif</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection