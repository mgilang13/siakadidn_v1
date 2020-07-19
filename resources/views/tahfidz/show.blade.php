@extends('layouts.app')

@section('content')
    <div class="content">
        <h1>Tahfidz / {{ $student->user->name }}</h1>
        <h6>Lembar Mutaba'ah</h6>
        <div class="card mt-5 pt-2 ml-3 ml-md-0">
            <div class="card-header">
                <div class="w-100 d-flex justify-content-around">
                    <div class="col-md-3">
                        <h5>Hafalan Pra IDN</h5>
                        <h6>{{ $student->hafalan_pra_idn == null ? '0' : $student->hafalan_pra_idn }} Juz</h6>
                    </div>
                    <div class="col-md-3">
                        <h5>Target Hafalan Sabaq</h5>
                        <h6>{{ $student->target_hafalan == null ? '0' : $student->hafalan_pra_idn }} Juz</h6>
                    </div>
                    <div class="col-md-3">
                        <h5>Total Hafalan Sabaq</h5>
                        @forelse($tahfidz_total_sabaq as $th)
                        <h6>{{ $th->Total }}</h6>
                        @empty
                        <h6>Belum ada data</h6>
                        @endforelse
                    </div>
                    <div class="col-md-3">
                        <h5>Total Hafalan Manzil</h5>
                        @forelse($tahfidz_total_manzil as $th)
                        <h6>{{ $th->Total }}</h6>
                        @empty
                        <h6>Belum ada data</h6>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="card-body">
            <div class="row flex-wrap flex-md-nowrap d-flex justify-content-between align-items-end w-100 mb-5">
                <div class="col-md-9 mb-2">
                    <canvas id="myChart"></canvas>
                </div>
                <div class="d-flex flex-column col-md align-items-end" style="height:300px">
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
                    <table class="table">
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
                                    <td class="text-capitalize">{{ $tahfidz->assessment }}</td>
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
                                        <div class="btn-action">
                                            <a href="{{ route('tahfidz.edit', $tahfidz->id) }}" title="Edit" >
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
            </div>
        </div>
    </div>
    
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');

        var tgl_bln_sabaq = {!! json_encode($tgl_bln_sabaq) !!}
        var total_line_sabaq = {!! json_encode($total_line_sabaq) !!}
        
        var tgl_bln_manzil = {!! json_encode($tgl_bln_manzil) !!}
        var total_line_manzil = {!! json_encode($total_line_manzil) !!}

        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
                labels: tgl_bln_sabaq,
                datasets: [{
                    label: 'Hafalan Sabaq',
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1.0)',
                    data: total_line_sabaq,
                }, {
                    label: 'Hafalan Manzil',
                    backgroundColor:'rgba(142, 68, 173,0.5)',
                    borderColor:'rgba(142, 68, 173,1.0)',
                    data:total_line_manzil,
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
                    position:'top'
                }
            }
        });
    </script>
@endsection