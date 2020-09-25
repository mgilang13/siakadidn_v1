@extends('layouts.app')

@section('content')
<div class="content">
    <h1 class="text-center text-md-left h1-responsive" name="top">Laporan Absensi per Tingkat</h1>
    <h3>Laporan Absensi Kelas</h3>
    <div class="card shadow">
        <div class="card-title mt-2">
            <h2>Filter</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('journal.report.absensi-class') }}" class="form-inline">
                <div class="d-flex flex-wrap align-items-center">
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                        <label for="start_date" class="mb-1">Periode:</label>
                            <input class="form-control" type="date" id="start_date" name="start_date" value="{{ $start_date }}">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="date" name="end_date" value="{{ $end_date }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <select name="id_level_detail" id="id_level_detail" class="form-control w-100">
                                <option value="">Pilih Detail Jenjang</option>
                                @forelse($level_details as $ld)
                                <option value="{{ $ld->id }}" {{ (old('id_level_detail') ?? $ld->id) == $id_level_detail ? 'selected' : '' }}>{{ $ld->name }}</option>
                                @empty  
                                <option value="">No data!</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <select name="id_level" id="id_level" class="form-control w-100">
                                <option value="">Pilih Jenjang</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="grade" id="grade" class="form-control w-100">
                                <option value="">Pilih Tingkat</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4"> 
                        <div class="form-group">
                            <select name="id_subject" id="id_subject" class="form-control w-100">
                                <option value="">Pilih Mapel</option>
                                @forelse($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ (old('id_subject') ?? $subject->id) == $id_subject ? 'selected' : '' }}>{{ $subject->name }}</option>
                                @empty
                                <option value="">No data !</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-indigo rounded px-3 py-2"><i class="fas fa-search" class="mr-1"></i> Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="d-flex flex-wrap row-cols-1 row-cols-md-3 mt-4" ">
        @forelse($absensi_class as $ac)
            <div class="col mb-4">
                <div class="card shadow pb-2">
                    <canvas id="canvas{{ $ac->id_class }}"></canvas>
                </div>
            </div>
        @empty
        <div>
            <h6>Data kosong!</h6>
        </div>
        @endforelse
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#id_level_detail').on('change', function(e) {
        $('#id_level').children().not(':first-child').remove();
        $('#grade').children().not(':first-child').remove();

        let id_level_detail = e.target.value;
        $.ajax({
            url: "{{ route('manage.schedule.level.response') }}",
            type: "POST",
            data: {
                id_level_detail: id_level_detail
            },
            success:function(data) {
                $.each(data, function(key, value){         
                    value.map(function(data) {
                        $('select[name="id_level"]').append('<option class="text-uppercase" value="'+data.id+'" {{ (old('id_level') ?? "'+data.id+'") == $id_level ? 'selected' : '' }}>'+data.levelName+'</option>');
                    });
                });
            }
        });
        // $('#id_level').empty();
    });

    $('#id_level').on('change', function(e) {

        $('#grade').children().not(':first-child').remove();

        let id_level = e.target.value;
        $.ajax({
            url: "{{ route('manage.schedule.grade.response') }}",
            type: "POST",
            data: {
                id_level: id_level
            },
            success:function(data) {
                $.each(data, function(key, value){         
                    value.map(function(data) {
                        console.log(data);
                        $('select[name="grade"]').append('<option class="text-uppercase" value="'+data.gradeID+'">'+data.gradeName+'</option>');
                    });
                });
            }
        });
    });
</script>
<script>
        $(document).ready(function() {
            let absensi_class = {!! json_encode($absensi_class) !!}

            absensi_class.map(result => {
                console.log(result);

                let idCanvas = 'canvas'+result.id_class;
                
                let ctx = document.getElementById(idCanvas).getContext('2d');

                let data = [result.persensakit, result.persenizin, result.persenalpha, result.persenhadir];
                let labels = ["Sakit", "Izin", "Alpha", "Hadir"];

                let chart = new Chart(ctx, {
                    type: "doughnut",
                    data: {
                        labels: labels,
                        datasets:[
                            {
                                data:data,
                                backgroundColor:[
                                    "#ffab00 ",
                                    "#1E88E5 ",
                                    "#FF6384",
                                    "#27ae60",
                                ],
                            },
                        ]
                    },
                    options:{
                        responsive:true,
                        title: {
                            display: true,
                            text: "Laporan Absensi Kelas: "+result.classname
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