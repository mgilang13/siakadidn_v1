@extends('layouts.app')

@section('content')
    <div class="content">
        <h1 class="text-center text-md-left h1-responsive" name="top">Tahfidz / {{ $student->user->name }}</h1>
        <h6 class="text-center text-md-left">Lembar Mutaba'ah</h6>
        <div class="card mt-5 pt-2 ml-3 ml-md-0">
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
                                <h6 class="mb-0 font-weight-bold">{{ $student->target_hafalan == null ? '0' : $student->hafalan_pra_idn }} Juz</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3 stretch-card">
                        <div class="card peach-gradient text-white text-center card-shadow-info px-0">
                            <div class="card-body">
                                <h6 class="font-weight-normal">Total Ziyadah</h6>
                                @foreach($tahfidz_total_ziyadah as $th)
                                    @if($th->Total != null)
                                    <h6 class="mb-0 font-weight-bold">{{ $th->Total }}</h6>
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
                                    @if($th->Total != null)
                                    <h6 class="mb-0 font-weight-bold">{{ $th->Total }}</h6>
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
                        <a href="{{ route('tahfidz.add-notes', $student->id_student) }}" class="btn btn-success btn-sm">
                            <i class="text-light" data-feather="plus" width="14"></i> Tambah Catatan
                        </a>
                    </div>
                </div>
            </div>
            @include('layouts.notification')
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal Setor</th>
                                <th>Surat</th>
                                <th>Jumlah Hafalan</th>
                                <th>Tipe Setoran</th>
                                <th>Penilaian</th>
                                <th>Absensi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $no = 1 @endphp
                            @forelse($tahfidzs as $tahfidz)
                                <tr>
                                    <td>{{ $tahfidzs->no++ }}</td>
                                    <td>{{ $tahfidz->tanggal_setor == '' ? $tahfidz->created_at : $tahfidz->tanggal_setor }}</td>
                                    <td>
                                        @if($tahfidz->soorah_start == $tahfidz->soorah_end)
                                        {{ $tahfidz->soorah_start }} : {{ $tahfidz->verse_start }} - {{ $tahfidz->verse_end }}
                                        @else
                                        {{ $tahfidz->soorah_start }} : {{ $tahfidz->verse_start }} - {{ $tahfidz->soorah_end }} : {{ $tahfidz->verse_end }}</td>
                                        @endif
                                    <td>{{ $tahfidz->page == 0 ? '' : $tahfidz->page .' halaman' }} {{ $tahfidz->line .' baris'}}</td>
                                    <td class="text-capitalize">{{ $tahfidz->type }}</td>
                                    @if($tahfidz->assessment == "kl")
                                    <td class="text-capitalize">Kurang Lancar</td>
                                    @elseif($tahfidz->assessment == "l")
                                    <td class="text-capitalize">Lancar</td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    <td>
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
                                    <td>
                                        <div class="btn-action row">
                                            <a class="mr-2" href="{{ route('tahfidz.edit', $tahfidz->id) }}" title="Edit" >
                                                <i data-feather="edit" class="text-primary" width="14"></i>
                                            </a>

                                            <a href="#" title="Delete" id="deleteData" data-toggle="modal" data-target="#deleteModal" data-id="{{ $tahfidz->id }}" class="text-danger" data-action="{{ route('tahfidz.destroy', $tahfidz->id) }}" >
                                                <i data-feather="trash" color="red" width="14"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @include('layouts.form-delete-tahfidz', [
                            'method' => 'POST',
                            'methodx' => 'DELETE',
                            'bgDanger' => 'bg-danger',
                            'boxConfirmHeader' => '',
                            'textWhite' => 'text-white',
                            'title_modal' => 'Delete Data Permanently',
                            'showdata' => "tahfidz.show-json",
                            'title_menu' => 'data tahfidz'])
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
                <a href="#top" class="btn btn-mdb-color btn-sm mx-auto rounded-pill waves-effect waves-light col-6 col-md-2 d-flex justify-content-center">Kembali Ke Atas</a>
            </div>
        </div>
    </div>
    
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');

        var tgl_bln_ziyadah = {!! json_encode($tgl_bln_ziyadah) !!}
        var total_line_ziyadah = {!! json_encode($total_line_ziyadah) !!}
        
        var tgl_bln_sabqy = {!! json_encode($tgl_bln_sabqy) !!}
        var total_line_sabqy = {!! json_encode($total_line_sabqy) !!}
        
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
                    label: 'Hafalan Sabqy',
                    backgroundColor: 'rgba(39, 174, 96, 0.5)',
                    borderColor: 'rgba(39, 174, 96, 1.0)',
                    data: total_line_sabqy,
                }, {
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
@endsection