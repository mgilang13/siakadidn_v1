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
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <label for="name">Tahun Ajar</label>
                                <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" placeholder="Tahun Ajaran" value="{{ old('name') }}" autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <label for="start_date">Tanggal Mulai</label>
                                <input id="start_date" type="date" class="form-control" name="start_date" value="{{ old('start_date') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <label for="end_date">Tanggal Berakhir</label>
                                <input id="end_date" type="date" class="form-control" name="end_date" value="{{ old('end_date') }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="d-flex flex-column">
                            <label for="status">Status</label>
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