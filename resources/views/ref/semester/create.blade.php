@extends('layouts.app')

@section('content')
<div class="content">
    <h2>Tambah Semester</h2>
    <form action="{{ route('ref.semester.store') }}" method="POST">
        @csrf
        <div class="content-header d-flex justify-content-end">
                <div class="header-btn">
                    <a href="{{ route('ref.semester.index') }}" class="btn btn-primary-outline"><i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-body row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <label for="name">Semester</label>
                                <select name="name" id="name" class="form-control">
                                    <option value="ganjil">Ganjil</option>
                                    <option value="genap">Genap</option>
                                </select>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <label for="information">Keterangan</label>
                                <input type="text" name="information" id="information" value="{{ old('information') }}" class="form-control">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="d-flex flex-column">
                            <label for="status">Status</label>
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" class="form-control">
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