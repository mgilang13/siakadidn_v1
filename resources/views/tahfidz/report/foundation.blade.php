@extends('layouts.app')

@section('content')
    <div class="content" id="section-to-print">
        <h1 class="text-center text-md-left h1-responsive" name="top" id="section-title">Laporan Tahfidz IDN</h1>
        <div class="alert alert-info" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <h4 class="alert-heading text-dark">Keterangan</h4>
            <ul>
                <li class="text-dark">Data pencapaian untuk jenis hafalan <b>Ziyadah</b></li>
                <li class="text-dark">Target perhari adalah <b>3 baris</b></li>
                <li class="text-dark"><b>Untuk SMP Senin & Ahad</b> tidak ada target ziyadah</li>
                <li class="text-dark"><b>Untuk SMK Sabtu & Ahad</b> tidak ada target ziyadah</li>
            </ul>
            <h4 id="counter" class="h5-responsive text-right text-dark" ></h4>
        </div>
        <div class="card mt-3 pt-2 ml-3 ml-md-0" id="documentPrintable">
        @include('layouts.form-periode', ['route' => 'tahfidz.report.smk', 'name' => 'past_date'])
            <div class="row mt-2 mb-4 d-flex justify-content-center">
                <div class="w-100 d-flex justify-content-around flex-wrap">
                    <div class="col-md-6 col-lg-5 mb-3 stretch-card">
                        <canvas id="smp"></canvas>
                        <div class="d-flex justify-content-between mt-3">
                            <small>Persentase Pencapaian: <b>{{ round($dataFoundation[0]->persentase, 2)}} %</b> </small>    
                            <small><b>Total {{ $dataFoundation[0]->total }} Siswa</b></small>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5 mb-3 stretch-card">
                        <canvas id="smk"></canvas>
                        <div class="d-flex justify-content-between mt-3">
                            <small>Persentase Pencapaian: <b>{{ round($dataFoundation[1]->persentase, 2)}} %</b> </small>    
                            <small><b>Total {{ $dataFoundation[1]->total }} Siswa</b></small>
                        </div>
                    </div>
                </div>
                .
                <button class="mt-5 btn btn-mdb-color btn-sm" onClick="window.print()"><i width="17" class="mr-2" data-feather="printer"></i> Print</button>
            </div>
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
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
    <script>
        var ctxSMP = document.getElementById('smp').getContext('2d');
        var tidakTercapaiSMP = parseInt({!! json_encode($dataFoundation[0]->tidaktercapai) !!});
        var tercapaiSMP = parseInt({!! json_encode($dataFoundation[0]->tercapai) !!});
        var melampauiSMP = parseInt({!! json_encode($dataFoundation[0]->melampaui) !!});
        
        var data = [tidakTercapaiSMP, tercapaiSMP, melampauiSMP];
        var labels = ["Tidak Tercapai", "Tercapai", "Melampaui"];

        var chartSMP = new Chart(ctxSMP, {
            type: 'pie',
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
                    text: 'Laporan Tahfidz SMP IDN'
                },
                legend:{
                    display:true,
                    position:'left'
                }
            }
        });
    </script>
    <script>
        var ctxSMK = document.getElementById('smk').getContext('2d');
        var tidakTercapaiSMK = parseInt({!! json_encode($dataFoundation[1]->tidaktercapai) !!});
        var tercapaiSMK = parseInt({!! json_encode($dataFoundation[1]->tercapai) !!});
        var melampauiSMK = parseInt({!! json_encode($dataFoundation[1]->melampaui) !!});
        
        var data = [tidakTercapaiSMK, tercapaiSMK, melampauiSMK];
        var labels = ["Tidak Tercapai", "Tercapai", "Melampaui"];

        var chartSMK = new Chart(ctxSMK, {
            type: 'pie',
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
                    text: 'Laporan Tahfidz SMK IDN'
                },
                legend:{
                    display:true,
                    position:'left'
                }
            }
        });
    </script>
@endsection