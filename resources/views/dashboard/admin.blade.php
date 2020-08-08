<div class="content">
    <h1 class="h1-responsive mb-2">Dashboard Admin</h1>
        <div class="card shadow">
            <div class="card-header bg-white"><h2><i data-feather="book-open" class="mr-1"></i> Tahfidz</h2></div>
            <div class="card-body">
                <div class="d-flex justify-content-around">
                    <div class="col-md-4 shadow">
                        <h3 class="h3-responsive"><i width="16" data-feather="chevron-right"></i> Laporan SMP</h3>
                        <canvas id="smp"></canvas>
                        <div class="d-flex justify-content-between mt-3">
                            <small>Persentase Pencapaian: <b>{{ round($dataFoundation[0]->persentase, 2)}} %</b> </small>    
                            <small><b>Total {{ $dataFoundation[0]->total }} Siswa</b></small>
                        </div>
                        <div class="d-flex justify-content-end mt-1 mb-2">
                            <a href="{{ route('tahfidz.report.smp') }}" class="btn btn-primary btn-sm px-3 py-1">Detail <i width="14" data-feather="chevrons-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4 shadow">
                        <h3 class="h3-responsive"><i width="16" data-feather="chevron-right"></i> Laporan SMK</h3>
                        <canvas id="smk"></canvas>
                        <div class="d-flex justify-content-between mt-3">
                            <small>Persentase Pencapaian: <b>{{ round($dataFoundation[1]->persentase, 2)}} %</b> </small>    
                            <small><b>Total {{ $dataFoundation[1]->total }} Siswa</b></small>
                        </div>
                        <div class="d-flex justify-content-end mt-1 mb-2">
                            <a href="{{ route('tahfidz.report.smk') }}" class="btn btn-primary btn-sm px-3 py-1">Detail <i width="14" data-feather="chevrons-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4 shadow">
                        <h3 class="h3-responsive"><i width="16" data-feather="chevron-right"></i> Milestones</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var ctxSMP = document.getElementById('smp').getContext('2d');
        var tidakTercapaiSMP = parseInt({!! json_encode($dataFoundation[0]->tidaktercapai) !!});
        var tercapaiSMP = parseInt({!! json_encode($dataFoundation[0]->tercapai) !!});
        var melampauiSMP = parseInt({!! json_encode($dataFoundation[0]->melampaui) !!});
        
        var data = [tidakTercapaiSMP, tercapaiSMP, melampauiSMP];
        var labels = ["Tidak Tercapai", "Tercapai", "Melampaui"];

        var chartSMP = new Chart(ctxSMP, {
            type: 'polarArea',
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
            type: 'polarArea',
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