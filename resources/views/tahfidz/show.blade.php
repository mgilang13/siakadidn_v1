@extends('layouts.app')

@section('content')
    <div class="content" id="section-to-print">
        <div id="section-title">
            <h1 class="text-center text-md-left h1-responsive" name="top">Tahfidz / {{ $student->user->name }}</h1>
            <h6 class="text-center text-md-left">Lembar Mutaba'ah</h6>
        </div>
        <div class="card mt-5 pt-2 ml-3 ml-md-0" id="documentPrintable">
            <div class="row mt-2">
                <div class="w-100 d-flex justify-content-around flex-wrap">
                    <div class="col-md-6 col-lg-3 mb-3 stretch-card">
                        <div class="card aqua-gradient text-white text-center card-shadow-info px-0">
                            <div class="card-body">
                                <h6 class="font-weight-normal">Hafalan Pra IDN</h6>
                                <h6 class="mb-0 font-weight-bold">{{ $student->hafalan_pra_idn == null ? '0' : $student->hafalan_pra_idn }} Juz</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3 stretch-card">
                        <div class="card purple-gradient text-white text-center card-shadow-info px-0">
                            <div class="card-body">
                                <h6 class="font-weight-normal">Target Hafalan Baru</h6>
                                <h6 class="mb-0 font-weight-bold">{{ $student->target_hafalan == null ? '0' : $student->target_hafalan }} Juz</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3 stretch-card">
                        <div class="card peach-gradient text-white text-center card-shadow-info px-0">
                            <div class="card-body">
                                <h6 class="font-weight-normal">Total Ziyadah</h6>
                                @foreach($tahfidz_total_ziyadah as $th)
                                    @if($th->total_ayat != null)
                                    <h6 class="mb-0 font-weight-bold">{{ $th->total_ayat }}</h6>
                                    @else
                                    <h6 class="mb-0 font-weight-bold">Belum ada data</h6>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3 stretch-card">
                        <div class="card blue-gradient text-white text-center card-shadow-info px-0">
                            <div class="card-body">
                                <h6 class="font-weight-normal">Total Muraja'ah</h6>
                                @foreach($tahfidz_total_murajaah as $th)
                                    @if($th->total_ayat != null)
                                    <h6 class="mb-0 font-weight-bold">{{ $th->total_ayat }}</h6>
                                    @else
                                    <h6 class="mb-0 font-weight-bold">Belum ada data</h6>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
            <div class="card-body">
            <div class="flex-wrap flex-md-nowrap d-flex justify-content-between align-items-end w-100 mb-5">
                <div class="col-md-9 mb-2">
                    <canvas id="myChart"></canvas>
                </div>
                <img src="" alt="" id="imageFromCanvas">
                <div class="d-flex flex-column col-md align-items-center" style="height:300px">
                    <div class="card shadow text-white bg-secondary">
                        <div class="card-header ">
                            <h6 class="font-weight-bold">Data Absensi</h6>
                        </div>
                        <div class="card-body bg-white text-secondary rounded-top d-flex flex-column justify-content-center">
                                <div class="badge badge-success py-2 mb-2">Hadir {{ $tahfidz_absensi->total_hadir }} kali</div>
                                <div class="badge badge-danger py-2 mb-2">Alpha {{ $tahfidz_absensi->total_alpha }} kali</div> 
                                <div class="badge badge-info py-2 mb-2">Izin {{ $tahfidz_absensi->total_izin }} kali</div> 
                                <div class="badge badge-warning py-2">Sakit {{ $tahfidz_absensi->total_sakit }} kali</div> 
                        </div>
                    </div>
                    <div class="mt-auto mx-auto">
                        <a href="{{ route('tahfidz.add-notes', $student->id_student) }}" class="btn btn-dark-green btn-sm">
                            <i class="text-light" data-feather="plus" width="14"></i> Tambah Catatan
                        </a>
                    </div>
                </div>
            </div>
            <img id= "image-grafik" src="" alt="">
            @include('layouts.notification')
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal Setor</th>
                                <th>Surat</th>
                                <th>Jumlah Hafalan</th>
                                <th>Waktu Setoran</th>
                                <th>Tipe Setoran</th>
                                <th>Penilaian</th>
                                <th>Absensi</th>
                                <th class="hide">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php 
                            $no = 1;
                            setlocale(LC_TIME, 'id_ID'); 
                        @endphp
                            @forelse($tahfidzs as $tahfidz)
                                <tr>
                                    <td>{{ $tahfidzs->no++ }}</td>
                                    <td>{{ \Carbon\Carbon::parse($tahfidz->tanggal_setor)->formatLocalized('%A, %d %B %Y') }}</td>
                                    <td>
                                        @if($tahfidz->soorah_start == $tahfidz->soorah_end)
                                        {{ $tahfidz->soorah_start }} : {{ $tahfidz->verse_start }} - {{ $tahfidz->verse_end }}
                                        @else
                                        {{ $tahfidz->soorah_start }} : {{ $tahfidz->verse_start }} - {{ $tahfidz->soorah_end }} : {{ $tahfidz->verse_end }}</td>
                                        @endif
                                    <td>{{ $tahfidz->page == 0 ? '' : $tahfidz->page .' halaman' }} {{ $tahfidz->line .' baris'}}</td>
                                    <td>{{ $tahfidz->deposit_time == 's' ? 'Subuh' : 'Maghrib'}}</td>
                                    <td class="text-capitalize">{{ $tahfidz->type }}</td>
                                    @if($tahfidz->assessment == "kl")
                                    <td class="text-capitalize">Kurang Lancar</td>
                                    @elseif($tahfidz->assessment == "l")
                                    <td class="text-capitalize">Lancar</td>
                                    @elseif($tahfidz->assessment == "u")
                                    <td>Ulang</td>
                                    @else
                                    <td></td>
                                    @endif
                                    <td style="cursor:pointer" data-toggle="popover" title="Catatan" data-content="{{ $tahfidz->note }}">
                                        @if($tahfidz->absen == 'a')
                                            <span class="badge badge-danger">Alpha</span>
                                        @elseif($tahfidz->absen == 'i')
                                            <span class="badge badge-info text-light">Izin</span>
                                        @elseif($tahfidz->absen == 's')
                                            <span class="badge badge-warning">Sakit</span>
                                        @elseif($tahfidz->absen == 'h')
                                            <span class="badge badge-success">Hadir</span>
                                        @endif
                                    </td>
                                    <td class="hide">
                                        <div class="btn-action d-flex justify-content-around">
                                            <a class="mr-1" href="{{ route('tahfidz.edit', $tahfidz->id) }}" title="Edit" >
                                                <i data-feather="edit" class="text-primary" width="14"></i>
                                            </a>
                                            <a href="{{ route('tahfidz.destroy', $tahfidz->id) }}" title="Delete" id="deleteData" data-toggle="modal" data-data_name="{{ \Carbon\Carbon::parse($tahfidz->tanggal_setor)->formatLocalized('%A, %d %B %Y') }}" data-target="#delete_modal" class="text-danger mr-1" >
                                                <i data-feather="trash" color="red" width="14"></i>
                                            </a>
                                            <a data-toggle="popover" title="Catatan" data-content="{{ $tahfidz->note }}" class="text-info font-weight-bold" >
                                                <i data-feather="info" width="14"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Data kosong</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="table-footer">
                    <p>Menampilkan {{ $tahfidzs->startNo }} - {{ $tahfidzs->currentTotal }} dari {{ $tahfidzs->total() }} data</p>
                    {{ $tahfidzs->onEachSide(1)->links() }}
                </div>
                <form action="{{ route('tahfidz.print', $student->id_student) }}" method="POST">
                @csrf
                    <input type="hidden" id="image64" value="" name="imageurl">
                    <button type="submit" class="btn btn-mdb-color btn-sm mx-auto rounded-pill waves-effect waves-light col-6 col-md-1 d-flex justify-content-center" data-url="" id="btn-print"><i class="fas fa-print mr-2 fa-lg"></i> Print</button>
                </form>
            </div>
        </div>
        @include('layouts.form-delete-new')
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            $('[data-toggle="popover"]').popover({
                trigger:'hover',
                placement: 'top',
            })
        })
    </script>

    <script>
     $('#delete_modal').on('show.bs.modal', function (event) {
        const target = $(event.relatedTarget);
        let data_deleted = target.data('data_name');

        $('#data-deleted').text(data_deleted);
        $('#form-delete').closest('form').attr('action', target.attr('href'));

    });
    </script>
    <script>
        var canvas = document.getElementById('myChart');
        var ctx = canvas.getContext('2d');

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
                animation: {
                    onComplete: function() {
                        document.getElementById('image64').setAttribute('value', chart.toBase64Image());
                    }
                },
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
    @endsection