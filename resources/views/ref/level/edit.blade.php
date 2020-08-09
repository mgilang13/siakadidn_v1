@extends('layouts.app')

@section('content')
    <div class="content">
        
        <form action="{{ route('ref.level.update', $level->id) }}" method="POST">
        @csrf
        @method('PATCH')
            <div class="content-header">
                <h2 class="h2-responsive">Ubah Jenjang Pendidikan</h2>
                <div class="header-btn">
                    <a href="{{ route('ref.level.index') }}" class="btn btn-primary-outline"><i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali</a>
                    <button type="submit" href="#" class="btn btn-primary">Update</button>
                </div>
            </div>
            <div class="card p-3">
                <div class="d-flex flex-wrap">
                    <div class="col-md-8 d-flex flex-wrap">
                        <div class="form-group col-md-6">
                            <label for="name" class="col-for-label font-weight-bold">Nama Jenjang Pendidikan</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') ?? $level->name }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="abbr" class="col-for-label font-weight-bold">Singkatan</label>
                            <input type="text" name="abbr" id="abbr" class="form-control @error('name') is-invalid @enderror" value="{{ old('abbr') ?? $level->abbr }}">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection