@extends('layouts.app')

@section('content')
    <div class="content">
        <form action="{{ route('manage.class.update', $class->id) }}" method="POST">
        @csrf
        @method('PATCH')
            <div class="content-header">
                <h2 class="h2-responsive">Ubah Data Manajemen Kelas</h2>
                <div class="header-btn">
                    <a href="{{ route('manage.class.index') }}" class="btn btn-primary-outline bg-white">
                        <i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali
                    </a>
                    <button type="submit" href="#" class="btn btn-primary">Update</button>
                </div>
            </div>
            <div class="card p-3">
                <div class="d-flex flex-wrap">
                    <div class="col-md-8 d-flex flex-wrap">
                        <div class="form-group col-md-6">
                            <label for="name" class="col-for-label font-weight-bold">Nama Kelas</label>
                            <select name="id_class" class="form-control">
                                @foreach($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}" {{ (old('id_class') ?? $classroom->id) == $class->id_class ? 'selected' : ''}}>{{ $classroom->name }}</option>
                                @endforeach
                            </select>                            
                        </div>
                        <div class="form-group col-md-6">
                            <label for="id_teacher" class="col-form-label font-weight-bold">Wali Kelas</label>
                            <select name="id_teacher" id="id_teacher" class="form-control">
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id_teacher }}" {{ (old('id_teacher') ?? $teacher->id_teacher) == $class->id_teacher ? 'selected' : '' }}>{{$teacher->title_ahead }} {{ $teacher->name }} {{ $teacher->back_title ? ', '.$teacher->back_title : ''}}</option>
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