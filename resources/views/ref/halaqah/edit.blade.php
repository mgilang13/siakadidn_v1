@extends('layouts.app')

@section('content')
    <div class="content">
        
        <form action="{{ route('ref.halaqah.update', $halaqah->id) }}" method="POST">
        @csrf
        @method('PATCH')
            <div class="content-header">
                <h2 class="h2-responsive">Ubah Data Halaqah</h2>
                <div class="header-btn">
                    <a href="{{ route('ref.halaqah.index') }}" class="btn btn-primary-outline"><i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali</a>
                    <button type="submit" href="#" class="btn btn-primary">Update</button>
                </div>
            </div>
            <div class="card p-3">
                <div class="d-flex flex-wrap">
                    <div class="col-md-8 d-flex flex-wrap">
                        <div class="form-group col-md-6">
                            <label for="name" class="col-for-label font-weight-bold">Nama Halaqah</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') ?? $halaqah->name }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="id_teacher" class="col-for-label font-weight-bold">Pengampu</label>
                            <select name="id_teacher" id="id_teacher" class="form-control">
                                <option value="">Pilih Pengampu Halaqah</option>
                                @forelse($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ (old('id_teacher') ?? $halaqah->id_teacher) == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                                @empty
                                <option value="">Tidak ada data</option>
                                @endforelse
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="id_class" class="col-for-label font-weight-bold">Kelas</label>
                            <select name="id_class" id="id_class" class="form-control">
                                <option value="">Pilih Kelas</option>
                                @forelse($classrooms as $classroom)
                                <option value="{{ $classroom->id }}" {{ (old('id_class') ?? $halaqah->id_class) == $classroom->id ? 'selected' : '' }}>{{ $classroom->name }}</option>
                                @empty
                                <option value="">Tidak ada data</option>
                                @endforelse
                            </select>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="id_level" class="col-for-label font-weight-bold">Institusi</label>
                            <select name="id_level" id="id_level" class="form-control">
                                <option value="">Pilih Institusi</option>
                                @forelse($levels as $level)
                                <option value="{{ $level->id }}" {{ (old('id_level') ?? $halaqah->id_level) == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
                                @empty
                                <option value="">Tidak ada data</option>
                                @endforelse
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="id_level_detail" class="col-for-label font-weight-bold">Detail Institusi</label>
                            <select name="id_level_detail" id="id_level_detail" class="form-control">
                                <option value="">Pilih Detail Institusi</option>
                                @forelse($level_details as $level_detail)
                                <option value="{{ $level_detail->id }}" {{ (old('id_level_detail') ?? $halaqah->id_level_detail) == $level_detail->id ? 'selected' : '' }}>{{ $level_detail->name }}</option>
                                @empty
                                <option value="">Tidak ada data</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex flex-wrap">
                        <div class="col">
                            <div class="form-group">
                                <label for="description" class="col-for-label font-weight-bold">Deskripsi Halaqah</label>
                                <textarea name="description" id="description" rows="5" class="form-control">{{ old('description') ?? $halaqah->description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection