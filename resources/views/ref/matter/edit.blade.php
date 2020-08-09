@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="card">
        <form action="{{ route('ref.matter.update', $matter->id) }}" method="POST">
        @csrf
        @method('PATCH')
            <div class="content-header">
                <h5>Ubah Materi</h5>
                <div class="header-btn">
                    <a href="{{ route('ref.matter.index') }}" class="btn btn-primary-outline"><i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali</a>
                    <button type="submit" href="#" class="btn btn-primary">Update</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name" class="col-for-label">Nama Materi Pelajaran</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') ?? $matter->name }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="id_subject" class="col-for-label">Mata Pelajaran</label>
                        <select name="id_subject" id="id_subject" class="form-control">
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ (old('id_subject') ?? $matter->id_subject) == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="description" class="col-for-label">Deskripsi Materi</label>
                        <textarea name="description" id="description" rows="5" class="form-control">{{ old('description') ?? $matter->description }}</textarea>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
@endsection