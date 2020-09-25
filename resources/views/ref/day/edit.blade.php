@extends('layouts.app')

@section('content')
<div class="content">
    <h2>Tambah Jam Pelajaran</h2>
    <form action="{{ route('ref.day.update', $day->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="content-header d-flex justify-content-end">
                <div class="header-btn">
                    <a href="{{ route('ref.day.index') }}" class="btn btn-primary-outline bg-white"><i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-body row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <label for="name">Hari</label>
                                <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" placeholder="Hari" value="{{ old('name') ?? $day->name }}" autofocus>
                                @error('name')
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