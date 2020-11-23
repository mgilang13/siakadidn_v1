@extends('layouts.app')

@section('content')
    <div class="content" id="section-to-print">
        <h1 class="text-center text-md-left h1-responsive" name="top" id="section-title">Laporan Tahfidz SMP</h1>
        <a href="{{ route('tahfidz.report.detail-student', 3) }}" class="btn btn-primary btn-lg mb-5 mt-2">Detail Per Siswa</a>
        
        <div class="alert alert-info" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <h4 class="alert-heading text-dark">Keterangan</h4>
            <ul>
                <li class="text-dark">Data pencapaian untuk jenis hafalan <b>Ziyadah</b></li>
                <li class="text-dark">Target perhari adalah <b>3 baris</b></li>
                <li class="text-dark"><b>Senin & Ahad</b> tidak ada target ziyadah</li>
            </ul>
            <h4 id="counter" class="h5-responsive text-right text-dark" ></h4>
        </div>
        <div class="card mt-3 pt-2 ml-3 ml-md-0" id="documentPrintable">
            <div class="row mt-2">
                <div class="w-100 d-flex justify-content-around flex-wrap">
                    <div class="col-md-6 col-lg-4 mb-3 stretch-card">
                        <canvas id="kelas7"></canvas>
                        <div class="d-flex justify-content-between mt-3">
                            <small>Persentase Pencapaian: <b>{{ round($dataPerKelas[0]->persentase, 2)}} %</b> </small>    
                            <small><b>Total {{ $dataPerKelas[0]->total }} Siswa</b></small>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3 stretch-card">
                        <canvas id="kelas8"></canvas>
                        <div class="d-flex justify-content-between mt-3">
                            <small>Persentase Pencapaian: <b>{{ round($dataPerKelas[1]->persentase, 2)}} %</b> </small>    
                            <small><b>Total {{ $dataPerKelas[1]->total }} Siswa</b></small>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3 stretch-card">
                        <canvas id="kelas9"></canvas>
                        <div class="d-flex justify-content-between mt-3">
                            <small>Persentase Pencapaian: <b>{{ round($dataPerKelas[2]->persentase, 2)}} %</b> </small>
                            <small><b>Total {{ $dataPerKelas[2]->total }} Siswa</b></small>   
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive mt-5 mb-5">
            <h3 class="text-center h3-responsive font-weight-bold">Tabel Perkembangan Halaqah di SMP IDN</h3>
            <form action="{{ route('tahfidz.report.smp') }}" class="mb-2">
                <div class="d-flex flex-wrap">
                    <div class="col-md-5">
                        <div class="form-group">
                            <select name="grade" id="grade" class="form-control">
                                <option value="">Select by Grade</option>
                                @forelse($grade as $g)
                                <option value="{{ $g->grade }}" {{ (old('grade') ?? $qGrade) == $g->grade ? 'selected' : '' }}>{{ $g->grade }}</option>
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
                        <div class="form-group d-flex flex-wrap justify-content-center mt-3">
                            <label class="col-md-2 d-flex justify-content-md-end justify-content-center col-form-label" for="q">Periode</label>
                            <div class="col-md-5">
                                <input class="form-control" type="date" name="past_date" value="{{ $past_date }}">
                            </div>
                            <div class="col-md-5">
                                <input class="form-control" type="date" name="present_date" value="{{ $present_date }}">
                            </div>
                        </div>
                        <button class="btn-indigo rounded btn-sm btn mt-md-n1 ml-md-n`" type="submit" id="button-search">
                            Search <i width="14" class="" data-feather="chevron-right"></i>
                        </button>
                    </div>
                </div>
                        
            </form>
            
                @php 
                    $no = 1;
                    setlocale(LC_TIME, 'id_ID'); 
                @endphp
                <h5>Periode {{ \Carbon\Carbon::parse($past_date)->formatLocalized('%A, %d %B %Y') }} - {{ \Carbon\Carbon::parse($present_date)->formatLocalized('%A, %d %B %Y') }}</h5>
                <table class="table table-striped table-sm text-center" id="dtHalaqah">
                    <thead class="purple-gradient">
                        <tr>
                            <th class="text-white align-middle">No</th>
                            <th class="text-white align-middle">Nama Pengampu</th>
                            <th class="text-white align-middle">Nama Halaqah</th>
                            <th class="text-white align-middle">Total (Siswa)</th>
                            <th class="text-white align-middle">Tidak Tercapai</th>
                            <th class="text-white align-middle">Tercapai</th>
                            <th class="text-white align-middle">Melampaui</th>
                            <th class="text-white align-middle">Persentase</th>
                            <th class="text-white align-middle">Cek Tahfidz</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach($dataPerHalaqah as $halaqahList)
                        <tr {{ $halaqahList->id == $qHalaqah ? 'style=background-color:yellow' : ''}}>
                            <td>{{ $no++ }}</td>
                            <td>{{ $halaqahList->muhafidz }}</td>
                            <td>{{ $halaqahList->halaqoh }}</td>
                            <td>{{ $halaqahList->total }}</td>
                            <td>{{ $halaqahList->tidaktercapai }}</td>
                            <td>{{ $halaqahList->tercapai }}</td>
                            <td>{{ $halaqahList->melampaui }}</td>
                            <td><b>{{ round($halaqahList->persentase, 2) }}%</b></td>
                            <td>
                                <form action="{{ route('tahfidz.report.smp') }}">
                                    <input type="hidden" value="{{ $halaqahList->id_teacher }}" name="id_teacher">
                                    <input type="hidden" value="{{ $halaqahList->id }}" name="id_halaqah">
                                    <input type="hidden" name="id_class" value="{{ $qClass }}">
                                    <input type="hidden" name="grade" value="{{ $qGrade }}">
                                    <input type="hidden" name="present_date_check" value="{{ $present_date_check ? $present_date_check : $present_date }}">
                                    <input type="hidden" name="past_date_check" value="{{ $past_date_check ? $past_date_check : $past_date }}">
                                    <button type="submit" class="btn btn-sm btn-purple rounded-pill font-weight-bold" id="tahfidz_check">Cek</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3 btn-purple rounded shadow-lg p-3" id="detail-halaqah-table">
                    @if($halaqah != null)
                    <h5>Detail Halaqah <span class="font-weight-bold">{{ $halaqah->name }}</span></h5>
                    <table class="table table-sm bg-white table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Total Target</th>
                                <th>Total Baris</th>
                                <th>Pencapaian</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $no = 1; @endphp
                            @forelse($check_tahfidz as $ct)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $ct->name }}</td>
                                <td>{{ $ct->total_target }}</td>
                                <td>{{ $ct->total_line }}</td>
                                <td class="text-capitalize">
                                    @if($ct->pencapaian == "melampaui")
                                    <span class="badge badge-pill badge-success">{{ $ct->pencapaian }}</span>
                                    @elseif($ct->pencapaian == "tercapai")
                                    <span class="badge badge-pill badge-info">{{ $ct->pencapaian }}</span>
                                    @else
                                    <span class="badge badge-pill badge-danger">{{ $ct->pencapaian }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            
                                <h5 >No data in table!</h5>
                            
                            @endforelse
                        </tbody>
                    </table>
                    @else
                    <h2>No Selected Halaqah</h2>
                    @endif
                </div>
            </div>
            <button class="mx-auto mt-3 mb-3 btn btn-mdb-color btn-sm" onClick="window.print()"><i width="17" class="mr-2" data-feather="printer"></i> Print</button>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var count1 = 200;
            var myTimer = setInterval(function() {
                document.getElementById("counter").innerHTML = count1;
                count1--;
                if (count1 == -1) {
                    $('.alert').hide();
                    clearInterval(myTimer);
                } else if (count1 % 10 == 0) {
                    $('#counter').addClass('font-weight-bold');
                } else if (count1 % 10 != 0) {
                    $('#counter').removeClass('font-weight-bold');
                }
            }, 100);
        });
    </script>
    <script>
        var ctx7 = document.getElementById('kelas7').getContext('2d');
        var tidakTercapai7 = parseInt({!! json_encode($dataPerKelas[0]->tidaktercapai) !!});
        var tercapai7 = parseInt({!! json_encode($dataPerKelas[0]->tercapai) !!});
        var melampaui7 = parseInt({!! json_encode($dataPerKelas[0]->melampaui) !!});
        
        var data = [tidakTercapai7, tercapai7, melampaui7];
        var labels = ["Tidak Tercapai", "Tercapai", "Melampaui"];

        var chart7 = new Chart(ctx7, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets:[
                    {
                        data:data,
                        backgroundColor:[
                            "#FF6384",
                            "#36A2EB",
                            "#27ae60"
                        ],
                    },
                ]
            },
            options:{
                title: {
                    display: true,
                    text: 'Laporan Tahfidz SMP Kelas 7'
                },
                legend:{
                    display:true,
                    position:'left'
                }
            }
        });
    </script>
    <script>
        var ctx8 = document.getElementById('kelas8').getContext('2d');
        var tidakTercapai8 = parseInt({!! json_encode($dataPerKelas[1]->tidaktercapai) !!});
        var tercapai8 = parseInt({!! json_encode($dataPerKelas[1]->tercapai) !!});
        var melampaui8 = parseInt({!! json_encode($dataPerKelas[1]->melampaui) !!});
        
        var data = [tidakTercapai8, tercapai8, melampaui8];
        var labels = ["Tidak Tercapai", "Tercapai", "Melampaui"];

        var chart8 = new Chart(ctx8, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets:[
                    {
                        data:data,
                        backgroundColor:[
                            "#FF6384",
                            "#36A2EB",
                            "#27ae60"
                        ],
                    },
                ]
            },
            options:{
                title: {
                    display: true,
                    text: 'Laporan Tahfidz SMP Kelas 8'
                },
                legend:{
                    display:true,
                    position:'left'
                }
            }
        });
    </script>
    <script>
        var ctx9 = document.getElementById('kelas9').getContext('2d');
        var tidakTercapai9 = parseInt({!! json_encode($dataPerKelas[2]->tidaktercapai) !!});
        var tercapai9 = parseInt({!! json_encode($dataPerKelas[2]->tercapai) !!});
        var melampaui9 = parseInt({!! json_encode($dataPerKelas[2]->melampaui) !!});
        
        var data = [tidakTercapai9, tercapai9, melampaui9];
        var labels = ["Tidak Tercapai", "Tercapai", "Melampaui"];

        var chart9 = new Chart(ctx9, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets:[
                    {
                        data:data,
                        backgroundColor:[
                            "#FF6384",
                            "#36A2EB",
                            "#27ae60"
                        ],
                    },
                ]
            },
            options:{
                title: {
                    display: true,
                    text: 'Laporan Tahfidz SMP Kelas 9'
                },
                legend:{
                    display:true,
                    position:'left'
                }
            }
        });
    </script>
@endsection