@extends('layouts.app')
@section('content')
    <div class="content">
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
                        <td>{{ $no++ }}</td>
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
                                <a href="#" title="Delete" id="deleteData" data-toggle="modal" data-target="#deleteModal" data-id="{{ $tahfidz->id }}" class="text-danger mr-1" data-action="{{ route('tahfidz.destroy', $tahfidz->id) }}" >
                                    <i data-feather="trash" color="red" width="14"></i>
                                </a>
                                <a data-toggle="popover" title="Catatan" data-content="{{ $tahfidz->note }}" class="text-info font-weight-bold" >
                                    <i data-feather="info" width="14"></i>
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
</div>
</div>
@endsection