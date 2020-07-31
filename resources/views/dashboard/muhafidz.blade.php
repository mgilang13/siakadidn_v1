<div class="content" id="section-to-print">
        <h1 class="text-center text-md-left h1-responsive" name="top" id="section-title">Dashboard {{ $reportMuhafidz[0]->halaqoh }}</h1>
        
        <div class="card mt-3 pt-2 ml-3 ml-md-0" id="documentPrintable">
            <div class="row mt-2 mb-4 d-flex justify-content-center">
                <div class="w-100 d-flex justify-content-between flex-wrap">
                    <div class="col-md-5 mb-3">
                        @include('layouts.form-periode', ['route' => 'dashboard', 'name' => 'past_date'])
                        <canvas id="report-muhafidz"></canvas>
                        <div class="d-flex justify-content-between mt-3">
                            <small>Persentase Pencapaian: <b>{{ round($reportMuhafidz[0]->persentase, 2)}} %</b> </small>    
                            <small><b>Total {{ $reportMuhafidz[0]->total }} Siswa</b></small>
                        </div>
                    </div>
                    <div class="col-md-7 mb-3">
                        <div class="table-responsive shadow">
                            <table class="table table-sm px-2">
                                <thead class="blue-gradient">
                                    <tr>
                                        <th class="text-white">Lihat</th>
                                        <th class="text-white">Nama</th>
                                        <th class="text-white">Target</th>
                                        <th class="text-white">Pencapaian</th>
                                        <th class="text-white">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($reportMuhafidzSantri as $santri)
                                    @if($santri->pencapaian == "tidak tercapai")
                                    <tr class="pink lighten-4">
                                    @elseif($santri->pencapaian == "tercapai")
                                    <tr class="blue lighten-4">
                                    @else
                                    <tr class="green lighten-4">
                                    @endif
                                        <td class="d-flex justify-content-center"><a href="{{ route('tahfidz.show', $santri->id_student) }}"><i width="15" color="#0d47a1" data-feather="external-link"></i></a></td>
                                        <td>{{ $santri->name }}</td>
                                        <td>{{ $santri->total_target }} baris</td>
                                        <td>{{ $santri->total_line }} baris</td>
                                        @if($santri->pencapaian == "tidak tercapai")
                                        <td>Unreached</td>
                                        @elseif($santri->pencapaian == "melampaui")
                                        <td>Surpassed</td>
                                        @else
                                        <td>Reached</td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var ctxMuhafidz = document.getElementById('report-muhafidz').getContext('2d');
        var tidakTercapaiMuhafidz = parseInt({!! json_encode($reportMuhafidz[0]->tidaktercapai) !!});
        var tercapaiMuhafidz = parseInt({!! json_encode($reportMuhafidz[0]->tercapai) !!});
        var melampauiMuhafidz = parseInt({!! json_encode($reportMuhafidz[0]->melampaui) !!});
        
        var data = [tidakTercapaiMuhafidz, tercapaiMuhafidz, melampauiMuhafidz];
        var labels = ["Tidak Tercapai", "Tercapai", "Melampaui"];

        var chartMuhafidz = new Chart(ctxMuhafidz, {
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
                    text: 'Laporan Tahfidz Halaqah'
                },
                legend:{
                    display:true,
                    position:'bottom'
                }
            }
        });
    </script>