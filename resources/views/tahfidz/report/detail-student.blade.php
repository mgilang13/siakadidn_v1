@extends('layouts.app')
@section('content')
    <div class="content">
        <h1>Laporan Detail Per Siswa {{ $id_level == 3 ? 'SMP' : 'SMK' }}</h1>
        <a href="{{ $id_level == 3 ? route('tahfidz.report.smp') : route('tahfidz.report.smk') }}" class="btn btn-outline-primary">Kembali</a>
        <div class="card p-3">
            <form class="col-md-5 mt-2" action="{{ route('tahfidz.report.detail-student', $id_level) }}">
                <div class="form-group">
                    
                    <select name="grade" id="grade" class="form-control">
                        <option value="">Select by Grade</option>
                        @forelse($grade as $g)
                            @if($qGrade == null and $qClass == null)
                                <option value="{{ $g->grade }}" {{ (old('grade') ?? $gradeSelected->grade) ==  $g->grade ? 'selected' : '' }}>{{ $g->grade }}</option>
                            @else
                                <option value="{{ $g->grade }}" {{ (old('grade') ?? $qGrade) == $g->grade ? 'selected' : '' }}>{{ $g->grade }}</option>
                            @endif
                        @empty
                        <option value="">No data!</option>
                        @endforelse
                    </select>
                </div>
                <div class="form-group">
                    <select name="id_class" id="id_class" class="form-control">
                        <option value="">Select by Class</option>
                        @forelse($class as $c)
                        <option value="{{ $c->id }}" {{ (old('id_class') ?? $qClass) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @empty
                        <option value="">No data!</option>
                        @endforelse
                    </select>
                </div>
                <button class="btn-indigo rounded btn-sm btn mt-md-n1 ml-md-n`" type="submit" id="button-search">
                    <i stroke-width="3" width="15" data-feather="search"></i>
                </button>
            </form>

            <div class="table-responsive">
                <div class="col-6 mb-5">
                    <div class="d-flex flex-wrap">
                        <div class="col-md-4 bg-success">Tercapai</div>
                        <div class="col-md-4 bg-danger">Tidak Tercapai</div>
                    </div>
                </div>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Pengampu</th>
                            <th>Target Lulus <br> (3 Juz)</th>
                            <th>Target Semester <br> (1 Juz)</th>
                            <th>Target Bulanan <br> (4 Halaman)</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $no = 1; @endphp
                        @forelse($detailStudent as $ds)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $ds->name }}</td>
                            <td>{{ $ds->className }}</td>
                            <td>{{ $ds->pengampu }}</td>
                            <td class="{{ $ds->ttl_style }}">{{ $ds->tahfidz_lulus }}</td>
                            <td class="{{ $ds->tts_style }}">{{ $ds->tahfidz_persemester }}</td>
                            <td class="{{ $ds->ttb_style }}">{{ $ds->tahfidz_perbulan }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4"><p class="text-center">No Data!</p></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection