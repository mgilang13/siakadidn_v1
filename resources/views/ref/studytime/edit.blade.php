@extends('layouts.app')

@section('content')
<div class="content">
    <h2>Tambah Jam Pelajaran</h2>
    <form action="{{ route('ref.studytime.update', $studytime->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="content-header d-flex justify-content-end">
                <div class="header-btn">
                    <a href="{{ route('ref.studytime.index') }}" class="btn btn-primary-outline bg-white"><i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-body row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <label for="name">Jam Pelajaran</label>
                                <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" placeholder="Jam Ke" value="{{ old('name') ?? $studytime->name }}" autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <label for="start_time">Waktu Mulai</label>
                                <input id="start_time" type="time" class="form-control" name="start_time" value="{{ old('start_time') ?? $studytime->start_time }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <label for="end_time">Waktu Berakhir</label>
                                <input id="end_time" type="time" class="form-control" name="end_time" value="{{ old('end_time') ?? $studytime->end_time }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <label for="information">Keterangan</label>
                                <input type="text" class="form-control" name="information" id="information" value="{{ old('information') ?? $studytime->information }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection