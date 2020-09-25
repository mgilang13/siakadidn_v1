@extends('layouts.app')

@section('content')
<div class="content">
    <h2>Tambah Jadwal Pelajaran</h2>
    <form action="{{ route('manage.schedule.store') }}" method="POST">
        @csrf
        <div class="content-header d-flex justify-content-end">
                <div class="header-btn">
                    <a href="{{ route('manage.schedule.index') }}" class="btn btn-primary-outline bg-white"><i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-body d-flex flex-wrap justify-content-md-around">
                    <div class="col-md-4 cyan darken-1 p-4">
                        <h5 class="mb-3 h5-responsive text-white">Pelajaran</h5>
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <select class="form-control" id="id_matter" type="text" name="id_matter">
                                <option value="">Pilih Materi Pelajaran</option>
                                @forelse($matters as $matter)
                                <option value="{{ $matter->id }}">{{ $matter->name }}</option>
                                @empty
                                <option value="">No data!</option>
                                @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <select class="form-control" id="id_class" type="text" name="id_class">
                                <option value="">Pilih Kelas</option>
                                @forelse($classrooms as $classroom)
                                <option class="text-uppercase" value="{{ $classroom->idClass }}">{{ $classroom->className }} -- {{ $classroom->levelAbbr }} {{ $classroom->levelDetailName }}</option>
                                @empty
                                <option value="">No data!</option>
                                @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <select class="form-control" id="id_teacher" type="text" name="id_teacher">
                                <option value="">Pilih Pengajar</option>
                                @forelse($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->title_ahead }} {{ $teacher->name }}{{ $teacher->back_title ? ', '.$teacher->back_title : '' }}</option>
                                @empty
                                <option value="">No data!</option>
                                @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 cyan p-4">
                        <h5 class="mb-3 h5-responsive text-white">Waktu</h5>
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <select class="form-control" id="id_day" type="text" name="id_day">
                                <option value="">Pilih Hari</option>
                                @forelse($days as $day)
                                <option value="{{ $day->id }}">{{ $day->name }}</option>
                                @empty
                                <option value="">No data!</option>
                                @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <select class="form-control" id="id_studytime_start" type="text" name="id_studytime_start">
                                <option value="">Pilih Jam Pelajaran Awal</option>
                                @forelse($studytimes as $studytime)
                                <option value="{{ $studytime->id }}">{{ $studytime->name }}</option>
                                @empty
                                <option value="">No data!</option>
                                @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <select class="form-control" id="id_studytime_end" type="text" name="id_studytime_end">
                                <option value="">Pilih Jam Pelajaran Akhir</option>
                                @forelse($studytimes as $studytime)
                                <option value="{{ $studytime->id }}">{{ $studytime->name }}</option>
                                @empty
                                <option value="">No data!</option>
                                @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 cyan lighten-1 p-4">
                        <h5 class="mb-3 h5-responsive text-white">Semester & Tahun Ajar</h5>
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <select class="form-control text-capitalize" id="id_semester" type="text" name="id_semester">
                                <option value="">Pilih Semester</option>
                                @forelse($semesters as $semester)
                                <option class="text-capitalize" value="{{ $semester->id }}" {{ $semester->status == 1 ? 'selected' : '' }}>{{ $semester->name }} {{ $semester->status == 1 ? '(Aktif)' : ''}}</option>
                                @empty
                                <option value="">No data!</option>
                                @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <select class="form-control" id="id_schoolyear" type="text" name="id_schoolyear">
                                <option value="">Pilih Tahun Ajaran</option>
                                @forelse($schoolyears as $schoolyear)
                                <option value="{{ $schoolyear->id }}" {{ $schoolyear->status == 1 ? 'selected' : '' }}>{{ $schoolyear->name }} {{ $schoolyear->status == 1 ? '(Aktif)' : ''}}</option>
                                @empty
                                <option value="">No data!</option>
                                @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection