@extends('layouts.app')

@section('content')
    <div class="content" id="section-to-print">
        <h1 class="text-center text-md-left h1-responsive" name="top" id="section-title">Laporan Tahfidz SMK</h1>
        <div class="alert alert-info" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <h4 class="alert-heading text-dark">Keterangan</h4>
            <ul>
                <li class="text-dark">Data pencapaian untuk jenis hafalan <b>Ziyadah</b></li>
                <li class="text-dark">Target perhari adalah <b>3 baris</b></li>
                <li class="text-dark"><b>Sabtu & Ahad</b> tidak ada target ziyadah</li>
            </ul>
            <h4 id="counter" class="h5-responsive text-right text-dark" ></h4>
        </div>
        <div class="card mt-3 pt-2 ml-3 ml-md-0" id="documentPrintable">
        @include('layouts.form-periode', ['route' => 'tahfidz.report.smk', 'name' => 'past_date'])
            <div class="row mt-2">
                <div class="w-100 d-flex justify-content-around flex-wrap">
                    <div class="col-md-6 col-lg-4 mb-3 stretch-card">
                        <canvas id="kelas10"></canvas>
                        <div class="d-flex justify-content-between mt-3">
                            <small>Persentase Pencapaian: <b>{{ round($dataPerKelas[0]->persentase, 2)}} %</b> </small>    
                            <small><b>Total {{ $dataPerKelas[0]->total }} Siswa</b></small>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3 stretch-card">
                        <canvas id="kelas11"></canvas>
                        <div class="d-flex justify-content-between mt-3">
                            <small>Persentase Pencapaian: <b>{{ round($dataPerKelas[1]->persentase, 2)}} %</b> </small>    
                            <small><b>Total {{ $dataPerKelas[1]->total }} Siswa</b></small>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3 stretch-card">
                        <canvas id="kelas12"></canvas>
                        <div class="d-flex justify-content-between mt-3">
                            <small>Persentase Pencapaian: <b>{{ round($dataPerKelas[2]->persentase, 2)}} %</b> </small>
                            <small><b>Total {{ $dataPerKelas[2]->total }} Siswa</b></small>   
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive mt-5 mb-5">
            <h3 class="text-center h3-responsive font-weight-bold">Tabel Perkembangan Halaqah di SMK IDN</h3>
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
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach($dataPerHalaqah as $halaqahList)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $halaqahList->muhafidz }}</td>
                            <td>{{ $halaqahList->halaqoh }}</td>
                            <td>{{ $halaqahList->total }}</td>
                            <td>{{ $halaqahList->tidaktercapai }}</td>
                            <td>{{ $halaqahList->tercapai }}</td>
                            <td>{{ $halaqahList->melampaui }}</td>
                            <td><b>{{ round($halaqahList->persentase, 2) }}%</b></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button class="mx-auto mt-3 mb-3 btn btn-mdb-color btn-sm" onClick="window.print()"><i width="17" class="mr-2" data-feather="printer"></i> Print</button>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#dtHalaqah').DataTable({
                "paging":true,
            });
        });
    </script>

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
        var ctx10 = document.getElementById('kelas10').getContext('2d');
        var tidakTercapai10 = parseInt({!! json_encode($dataPerKelas[0]->tidaktercapai) !!});
        var tercapai10 = parseInt({!! json_encode($dataPerKelas[0]->tercapai) !!});
        var melampaui10 = parseInt({!! json_encode($dataPerKelas[0]->melampaui) !!});
        
        var data = [tidakTercapai10, tercapai10, melampaui10];
        var labels = ["Tidak Tercapai", "Tercapai", "Melampaui"];

        var chart10 = new Chart(ctx10, {
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
                    text: 'Laporan Tahfidz SMK Kelas 10'
                },
                legend:{
                    display:true,
                    position:'left'
                }
            }
        });
    </script>
    <script>
        var ctx11 = document.getElementById('kelas11').getContext('2d');
        var tidakTercapai11 = parseInt({!! json_encode($dataPerKelas[1]->tidaktercapai) !!});
        var tercapai11 = parseInt({!! json_encode($dataPerKelas[1]->tercapai) !!});
        var melampaui11 = parseInt({!! json_encode($dataPerKelas[1]->melampaui) !!});
        
        var data = [tidakTercapai11, tercapai11, melampaui11];
        var labels = ["Tidak Tercapai", "Tercapai", "Melampaui"];

        var chart11 = new Chart(ctx11, {
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
                    text: 'Laporan Tahfidz SMK Kelas 11'
                },
                legend:{
                    display:true,
                    position:'left'
                }
            }
        });
    </script>
    <script>
        var ctx12 = document.getElementById('kelas12').getContext('2d');
        var tidakTercapai12 = parseInt({!! json_encode($dataPerKelas[2]->tidaktercapai) !!});
        var tercapai12 = parseInt({!! json_encode($dataPerKelas[2]->tercapai) !!});
        var melampaui12 = parseInt({!! json_encode($dataPerKelas[2]->melampaui) !!});
        
        var data = [tidakTercapai12, tercapai12, melampaui12];
        var labels = ["Tidak Tercapai", "Tercapai", "Melampaui"];

        var chart12 = new Chart(ctx12, {
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
                    text: 'Laporan Tahfidz SMK Kelas 12'
                },
                legend:{
                    display:true,
                    position:'left'
                }
            }
        });
    </script>
@endsection