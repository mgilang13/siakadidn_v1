<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tahfidz IDN</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>
<body>
    <div>
        <h2 class="text-center font-weight-normal">Laporan Tahfidz / {{ $student->name }}</h2>
        <h6 class="text-center font-weight-normal">Lembar Mutaba'ah</h6>
    </div>
    <br>
    
    <div style="font-size:12px">
        <p>
            <span class="font-weight-bold"> Hafalan Pra IDN </span>: {{ $student->hafalan_pra_idn == null ? '0' : $student->hafalan_pra_idn }} Juz <br>
            <span class="font-weight-bold">Target Hafalan Baru </span>: {{ $student->target_hafalan == null ? '0' : $student->target_hafalan }} Juz <br>
            <span class="font-weight-bold">Total Ziyadah </span>: 
                            @foreach($tahfidz_total_ziyadah as $th)
                                @if($th->total_ayat != null)
                                    {{ $th->total_ayat }}
                                @else
                                    Belum ada data
                                @endif
                            @endforeach
                            <br>
            <span class="font-weight-bold"> Total Muraja'ah </span>: 
                            @foreach($tahfidz_total_murajaah as $th)
                                @if($th->total_ayat != null)
                                    {{ $th->total_ayat }}
                                @else
                                    Belum ada data
                                @endif
                            @endforeach
        </p>
    </div>
    <br>

    <div class="badge badge-success py-2 mb-2">Hadir {{ $tahfidz_absensi->total_hadir }} kali</div>
    <div class="badge badge-danger py-2 mb-2">Alpha {{ $tahfidz_absensi->total_alpha }} kali</div> 
    <div class="badge badge-info py-2 mb-2">Izin {{ $tahfidz_absensi->total_izin }} kali</div> 
    <div class="badge badge-warning py-2">Sakit {{ $tahfidz_absensi->total_sakit }} kali</div> 
    
    <br>
    <img src="{{ $image64 }}" alt="">
    <div class="table-responsive">
        <table class="table table-sm table-striped" style="font-size:11px;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal Setor</th>
                    <th>Surat</th>
                    <th>Jumlah Hafalan</th>
                    <th>Tipe Setoran</th>
                    <th>Penilaian</th>
                    <th>Absensi</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $no = 1;
                    setlocale(LC_TIME, 'id_ID');  
                @endphp
                @forelse($tahfidzs as $tahfidz)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ \Carbon\Carbon::parse($tahfidz->tanggal_setor)->formatLocalized('%A, %d %B %Y') }}</td>
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
                    <td>{{ $tahfidz->note }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Data kosong</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
