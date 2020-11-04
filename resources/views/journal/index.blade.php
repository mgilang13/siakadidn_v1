@extends('layouts.app')

@section('content')
    <div class="content">
        <h1 class="ml-2 h1-responsive">Jurnal</h1>
            @if(Auth::user()->roles->first()->pivot->roles_id == 3)
            <div class="card shadow mb-4">
                <div class="card-title">
                    <h3 class="mt-2">Laporan</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap">
                        <a class="btn btn-primary" href="{{ route('journal.report.absensi-class') }}">Laporan Absensi</a>
                        <a class="btn btn-secondary" href="{{ route('journal.report.feedback-class') }}">Laporan Feedback</a>
                    </div>
                </div>
            </div>
            <div class="card shadow">          
                <div class="card-title mt-2">
                    <h3>Input Data</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap">
                        @forelse($teachedClass as $tc)
                        <a href="{{ route('journal.teacher-schedule', $tc->id) }}" class="btn btn-indigo">{{ $tc->className }}</a>
                        @empty
                        <h6>TIdak ada kelas yang diajar</h6>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="card shadow mt-3">
                <div class="card-header bg-white">
                    <h4>Data Siswa</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap">
                        <form class="form-inline" action="{{ route('journal.index') }}">
                            <div class="form-group">
                                <select name="id_class" id="id_class" class="form-control mr-2">
                                    <option value="">Pilih Berdasarkan Kelas</option>
                                    @if($qClass)
                                    @forelse($teachedClass as $tc)
                                    <option value="{{ $tc->id }}" {{ (old('id_class') ?? $tc->id) == $qClass ? 'selected' : '' }}>{{ $tc->className }}</option>
                                    @empty
                                    <option value="">No data!</option>
                                    @endforelse
                                    <!-- Check bila pertama kali diakses -->
                                    @else
                                    @forelse($teachedClass as $tc)
                                    <option value="{{ $tc->id }}" {{ (old('id_class') ?? $tc->id) == $firstTeachedClass->id ? 'selected' : '' }}>{{ $tc->className }}</option>
                                    @empty
                                    <option value="">No data!</option>
                                    @endforelse
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="date" name="start_date" class="form-control mr-2" value="{{ $start_date }}">
                            </div>
                            <div class="form-group">
                                <input type="date" name="end_date" class="form-control mr-2" value="{{ $end_date }}">
                            </div>
                            <button type="submit" class="btn indigo btn-sm text-white">Search</button>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th class="aqua-gradient text-white text-center">Sudah Paham</th>
                                        <th class="purple-gradient text-white text-center">Belum Paham</th>
                                        <th class="stylish-color text-white text-center">Belum Feedback</th>
                                        <th class="amber accent-4 text-white text-center">Sakit</th>
                                        <th class="light-blue accent-4 text-white text-center">Izin</th>
                                        <th class="red darken-1 text-white text-center">Alpha</th>
                                        <th class="teal accent-4 text-white text-center">Hadir</th>
                                        <th class="blue-gradient text-white text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no=1; @endphp
                                    @if($qClass)
                                    @php $studentsValue = $students @endphp
                                    @else
                                    @php $studentsValue = $firstStudents @endphp
                                    @endif
                                    @forelse($studentsValue as $student)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td class="text-center"><div class="badge p-1 aqua-gradient">{{ $student->sudahpaham != 0 ? $student->sudahpaham : '' }}{{ $student->persen_sudahpaham != 0 ? ' ('.round($student->persen_sudahpaham, 1).'%)' : '' }}</div></td>
                                        <td class="text-center">
                                        @if($student->belumpaham != '')
                                            <div class="badge p-1 purple-gradient" data-toggle="popover" data-content="Belum Teratasi">
                                                {{ $student->belumpaham != 0 ? $student->belumpaham : '' }}{{ $student->persen_belumpaham != 0 ? ' ('.round($student->persen_belumpaham, 1).'%)' : '' }}
                                            </div>
                                            @endif

                                            @if($student->teratasi != '')
                                            <div class="badge p-1 peach-gradient" data-toggle="popover" data-content="Sudah Teratasi">
                                                {{ $student->teratasi != 0 ? $student->teratasi : '' }}{{ $student->persen_teratasi != 0 ? ' ('.round($student->persen_teratasi, 1).'%)' : '' }}
                                            </div>
                                            @endif
                                        </td>
                                        <td class="text-center"><div class="badge p-1 stylish-color text-white">{{ $student->belumfeedback != 0 ? $student->belumfeedback : '' }}{{ $student->persen_belumfeedback != 0 ? ' ('.round($student->persen_belumfeedback, 1).'%)' : '' }}</div></td>
                                        <td class="text-center"><div class="badge p-1 amber accent-4">{{ $student->sakit != 0 ? $student->sakit : '' }}{{ $student->persen_sakit != 0 ? ' ('.round($student->persen_sakit, 1).'%)' : '' }}</div></td>
                                        <td class="text-center"><div class="badge p-1 light-blue accent-4">{{ $student->izin != 0 ? $student->izin : '' }}{{ $student->persen_izin != 0 ? ' ('.round($student->persen_izin, 1).'%)' : '' }}</div></td>
                                        <td class="text-center"><div class="badge p-1 red darken-1">{{ $student->alpha != 0 ? $student->alpha : '' }}{{ $student->persen_alpha != 0 ? ' ('.round($student->persen_alpha, 1).'%)' : '' }}</div></td>
                                        <td class="text-center"><div class="badge p-1 teal accent-4">{{ $student->hadir != 0 ? $student->hadir : '' }}{{ $student->persen_hadir != 0 ? ' ('.round($student->persen_hadir, 1).'%)' : '' }}</div></td>
                                        <td class="text-center">
                                            <a href="{{ route('journal.report.feedback-student', $student->id_student) }}" data-toggle="popover" data-content="Lihat Feedback">
                                                <i class="fas fa-comments ml-1 fa-lg" style="color:#0091ea"></i>
                                            </a>
                                            <a href="{{ route('journal.report.absensi-student', $student->id_student) }}" data-toggle="popover" data-content="Lihat Absensi {{ $student->name }}">
                                                <i class="fas fa-book ml-3 fa-lg" style="color:#00bfa5 "></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>Belum ada data!</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            @elseif(Auth::user()->id == 1)
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex flex-wrap">
                        <a class="btn btn-primary" href="{{ route('journal.report.absensi-class') }}">Laporan Absensi</a>
                        <a class="btn btn-info" href="{{ route('journal.report.detail') }}">Laporan Detail Jurnal</a>
                        <a class="btn btn-secondary" href="{{ route('journal.report.feedback-class') }}">Laporan Feedback</a>
                        <a class="btn primary-color text-white" href="{{ route('journal.report.detail-absensi') }}">Laporan Detail Absensi</a>
                    </div>
                </div>
            </div>
            @else
            
            @endif
        </div>
    </div>
    <script>
        $(function () {
            $('[data-toggle="popover"]').popover({
                trigger:'hover',
                placement: 'top',
            })
        })
    </script>
@endsection