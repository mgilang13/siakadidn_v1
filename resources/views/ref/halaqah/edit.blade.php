@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="card">
        <form action="{{ route('ref.halaqah.update', $halaqah->id) }}" method="POST">
        @csrf
        @method('PATCH')
            <div class="content-header">
                <h5>Ubah Halaqah</h5>
                <div class="header-btn">
                    <a href="{{ route('ref.halaqah.index') }}" class="btn btn-primary-outline"><i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali</a>
                    <button type="submit" href="#" class="btn btn-primary">Update</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name" class="col-for-label">Nama Halaqah</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') ?? $halaqah->name }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="id_teacher" class="col-for-label">Pengampu</label>
                        <select name="id_teacher" id="id_teacher" class="form-control">
                            <option value="">Pilih Pengampu Halaqah</option>
                            @forelse($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ (old('id_teacher') ?? $halaqah->id_teacher) == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                            @empty
                            <option value="">Tidak ada data</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="description" class="col-for-label">Deskripsi Halaqah</label>
                        <textarea name="description" id="description" rows="5" class="form-control">{{ old('description') ?? $halaqah->description }}</textarea>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
@endsection