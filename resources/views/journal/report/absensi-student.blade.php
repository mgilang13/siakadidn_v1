@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="d-flex flex-wrap justify-content-between">
        <div>
            <h1 class="text-center text-md-left h1-responsive" name="top">Laporan Absensi / {{ $student->name }}</h1>
            <h3>Laporan Absensi per Mata Pelajaran</h3>
        </div>
        <div>
            <a href="{{ route('journal.index' )}}" class="btn btn-outline-primary"><i class="fas fa-chevron-left mr-1"></i> Kembali</a>
        </div>
        </div>
        @include('layouts.form-periode-with-id', ['route' => 'journal.report.absensi-student', 'name' => 'start_date', 'id' => $student->id ])
        <div class="d-flex flex-wrap text-center my-4">
            <div class="w-25 teal accent-4 text-white px-4 py-2 waves-effect waves-light">
                <h4>{{ round($absensi_total[0]->persen_hadir, 2) }}%</h4>
                <h5>{{ $absensi_total[0]->hadir }} kali</h5>
                <h6 class="font-weight-bold">Hadir</h6>
            </div>
            <div class="w-25 amber accent-4 text-white px-4 py-2 waves-effect waves-light">
                <h4>{{ round($absensi_total[0]->persen_sakit, 2) }}%</h4>
                <h5>{{ $absensi_total[0]->sakit }} kali</h5>
                <h6 class="font-weight-bold text-center">Sakit</h6>
            </div>
            <div class="w-25 light-blue accent-4 text-white px-4 py-2 waves-effect waves-light">
                <h4>{{ round($absensi_total[0]->persen_izin, 2) }}%</h4>
                <h5>{{ $absensi_total[0]->izin }} kali</h5>
                <h6 class="font-weight-bold text-center">Izin</h6>
            </div>
            <div class="w-25 red darken-1 text-white px-4 py-2 waves-effect waves-light">
                <h4>{{ round($absensi_total[0]->persen_alpha, 2) }}%</h4>
                <h5>{{ $absensi_total[0]->alpha }} kali</h5>
                <h6 class="font-weight-bold text-center">Alpha</h6>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-3">
            @forelse($absensi as $absen)
                <div class="col mb-4">
                    <div class="card">
                        <div class="view overlay">
                            <canvas id="canvas{{ $absen->id_subject }}"></canvas>
                        </div>
                        <div class="card-body">
                            <h6>Sakit : {{ round($absen->persen_sakit) }}% <i data-feather="arrow-right" class="ml-1 mr-1" width="13"></i> {{ $absen->sakit }} kali</h6>
                            <h6>Izin : {{ round($absen->persen_izin) }}% <i data-feather="arrow-right" class="ml-1 mr-1" width="13"></i> {{ $absen->izin }} kali</h6>
                            <h6>Alpha : {{ round($absen->persen_alpha) }}% <i data-feather="arrow-right" class="ml-1 mr-1" width="13"></i> {{ $absen->alpha }} kali</h6>
                            <h6>Hadir : {{ round($absen->persen_hadir) }}% <i data-feather="arrow-right" class="ml-1 mr-1" width="13"></i> {{ $absen->hadir }} kali</h6>
                        </div>
                    </div>
                </div>
            @empty
            <div>
                <h6>Data kosong!</h6>
            </div>
            @endforelse
        </div>
        <div class="mt-2">
            <h2>Detail Keabsenan {{ $student->name }}</h2>
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal Pelajaran</th>
                                    <th>Nama Pelajaran</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php $no=1; @endphp
                            @forelse($absensi_detail as $ad)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $ad->teaching_date }}</td>
                                    <td>{{ $ad->subjectName }}</td>
                                    <td>
                                        @if($ad->status == 'i')
                                            <p class="badge badge-primary">Izin</p>
                                        @elseif($ad->status == 's')
                                            <p class="badge badge-warning">Sakit</p>
                                        @else
                                            <p class="badge badge-red">Alpha</p>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>No data!</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            let absensi = {!! json_encode($absensi) !!}

            absensi.map(result => {
                let idCanvas = 'canvas'+result.id_subject;
                
                let ctx = document.getElementById(idCanvas).getContext('2d');

                let data = [result.sakit, result.izin, result.alpha, result.hadir];
                let labels = ["Sakit", "Izin", "Alpha", "Hadir"];

                let chart = new Chart(ctx, {
                    type: "doughnut",
                    data: {
                        labels: labels,
                        datasets:[
                            {
                                data:data,
                                backgroundColor:[
                                    "#ffab00",
                                    "#1E88E5",
                                    "#e53935",
                                    "#27ae60",
                                ],
                            },
                        ]
                    },
                    options:{
                        title: {
                            display: true,
                            text: "Laporan Absensi Mapel: "+result.subject_name
                        },
                        legend:{
                            display:true,
                            position:'left'
                        }
                    }
                })
            })
        });
    </script>
@endsection