<div class="content">
    <div class="col-md-6">
        <div class="card shadow p-2 px-md-4">
            <h3 class="h3-responsive mb-4">Laporan Tahfidz dan Murajaah</h3>
            <canvas id="myChart"></canvas>
            <div class="d-flex justify-content-end">
                <a href="{{ route('tahfidz.show', $user->id) }}" class="btn col-3 mt-2 btn-primary btn-sm">Detail <i data-feather="chevrons-right" width="15"></i></a>
            </div>
        </div>
    </div>

</div>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');

    var tgl_bln_ziyadah = {!! json_encode($tgl_bln_ziyadah) !!}
    var total_line_ziyadah = {!! json_encode($total_line_ziyadah) !!}
    
    var tgl_bln_murajaah = {!! json_encode($tgl_bln_murajaah) !!}
    var total_line_murajaah = {!! json_encode($total_line_murajaah) !!}

    
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: tgl_bln_ziyadah,
            datasets: [{
                label: 'Hafalan Ziyadah',
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1.0)',
                data: total_line_ziyadah,
            },{
                label: 'Hafalan Murajaah',
                backgroundColor:'rgba(142, 68, 173,0.5)',
                borderColor:'rgba(142, 68, 173,1.0)',
                data:total_line_murajaah,
            }]
        },

        // Configuration options go here
        options: {
            scales: {
                yAxes: [{
                    scaleLabel: {
                        display:true,
                        labelString:'Baris'
                    }
                }],
                xAxes: [{
                    scaleLabel: {
                        display:true,
                        labelString:'Periode'
                    }
                }],
            },
            title: {
                display: true,
                text: 'Grafik Hafalan 1 Bulan Terakhir '
            },
            legend: {
                display:false
            }
        }
    });
</script>