<div class="content">
    <div class="d-flex flex-wrap">
        <div class="col-md-6">
            <div class="card shadow p-2 px-md-4">
                <h3 class="h3-responsive mb-4">Laporan Tahfidz dan Murajaah</h3>
                <canvas id="myChart"></canvas>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('tahfidz.show', $user->id) }}" class="btn col-3 mt-2 btn-primary btn-sm">Detail <i data-feather="chevrons-right" width="15"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow py-2 px-md-4 " >
                <h3 class="h3-responsive mb-4">Journal Feedback</h3>
                @include('layouts.notification')
                <div class="list-group overflow-auto " style="height:350px">
                    @forelse($journalStudents as $js)
                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-2 h5">{{ $js->name }} - {{ $js->subMateri ? $js->subMateri : $js->matter_detail_other }}</h5>
                            <h6>{{ $js->created_at }}</h6>
                        </div>
                        <p class="mb-2">Ustadz {{ $js->teacherName }}</p>
                        <form action="{{ route('journal.feedback.store') }}" method="POST" class="border light-blue lighten-4 rounded shadow p-2">
                            @csrf
                            <input type="hidden" value="{{ $js->id_journal }}" name="id_journal">
                            <h6 class="font-weight-bold">Tingkat Kepahaman :</h6>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="y" name="feedback_option" value="y" checked>
                                <label class="custom-control-label" for="y">Sudah Paham</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="n" name="feedback_option" value="n">
                                <label class="custom-control-label" for="n">Belum Paham</label>
                            </div>
                            <div class="form-group mt-2">
                                <textarea class="form-control" name="note" id="note" cols="30" rows="3" placeholder="Catatan"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm p-1 px-2 rounded d-flex align-self-center ml-2">Submit</button>
                            @error('feedback_option')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </form>
                    </div>
                    @empty
                    <a href="#">No Journal!</a>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({
        placement : 'top',
        trigger : 'hover'
    });
});
</script>
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