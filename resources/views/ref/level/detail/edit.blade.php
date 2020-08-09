@extends('layouts.app')

@section('content')
    <div class="content">
        
        <form action="{{ route('ref.level.detail.update', $level_detail->id) }}" method="POST">
        @csrf
        @method('PATCH')
            <div class="content-header">
                <h2 class="h2-responsive">Ubah Detail Jenjang</h2>
                <div class="header-btn">
                    <a href="{{ route('ref.level.index') }}" class="btn btn-primary-outline"><i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali</a>
                    <button type="submit" href="#" class="btn btn-primary">Update</button>
                </div>
            </div>
            <div class="card p-3">
                <div class="d-flex flex-wrap">
                    <div class="col-md-8 d-flex flex-wrap">
                        <div class="form-group col-md-6">
                            <label for="name" class="col-for-label font-weight-bold">Detail Jenjang</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') ?? $level_detail->name }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address" class="col-for-label font-weight-bold">Alamat</label>
                            <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('abbr') ?? $level_detail->address }}">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection