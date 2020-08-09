@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="card">
        <form action="{{ route('ref.subject.update', $subject->id) }}" method="POST">
        @csrf
        @method('PATCH')
            <div class="content-header">
                <h5>Ubah Mata Pelajaran</h5>
                <div class="header-btn">
                    <a href="{{ route('ref.subject.index') }}" class="btn btn-primary-outline"><i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali</a>
                    <button type="submit" href="#" class="btn btn-primary">Update</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name" class="col-for-label">Nama Mata Pelajaran</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') ?? $subject->name }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="description" class="col-for-label">Deskripsi Mata Pelajaran</label>
                        <textarea name="description" id="description" rows="5" class="form-control">{{ old('description') ?? $subject->description }}</textarea>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
@endsection