@extends('layouts.app')

@section('content')
    <div class="content">
        <form action="{{ route('manage.teacher.update', $teacher->id) }}" method="POST">
        @csrf
        @method('PATCH')
            <div class="content-header">
                <h2 class="h2-responsive">Ubah Data Manajemen Guru</h2>
                <div class="header-btn">
                    <a href="{{ route('manage.teacher.index') }}" class="btn btn-primary-outline bg-white">
                        <i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali
                    </a>
                    <button type="submit" href="#" class="btn btn-primary">Update</button>
                </div>
            </div>
            <div class="card p-3">
                <div class="d-flex flex-wrap">
                    <div class="col d-flex flex-wrap">
                        <div class="form-group col-md-4">
                            <label for="name" class="col-for-label font-weight-bold">Nama Guru</label>
                            <select name="id_teacher" class="form-control">
                                @foreach($teachers as $t)
                                    <option value="{{ $t->id }}" {{ (old('id_teacher') ?? $t->id) == $teacher->id_teacher ? 'selected' : ''}}>{{$t->title_ahead }} {{ $t->name }} {{ $t->back_title ? ', '.$t->back_title : ''}}</option>
                                @endforeach
                            </select>                            
                        </div>
                        <div class="form-group col-md-4">
                            <label for="id_level" class="col-form-label font-weight-bold">Jenjang</label>
                            <select name="id_level" id="id_level" class="form-control">
                                @foreach($levels as $level)
                                    <option value="{{ $level->id }}" {{ (old('id_level') ?? $level->id_level) == $teacher->id_level ? 'selected' : '' }}>{{ $level->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="id_teacher-message"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="id_level_detail" class="col-form-label font-weight-bold">Detail Jenjang</label>
                            <select name="id_level_detail" id="id_level_detail" class="form-control">
                                @foreach($level_details as $level_detail)
                                    <option value="{{ $level_detail->id }}" {{ (old('id_level_detail') ?? $level_detail->id) == $teacher->id_level_detail ? 'selected' : '' }}>{{ $level_detail->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="id_teacher-message"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>               
@endsection