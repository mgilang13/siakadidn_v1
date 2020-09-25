@extends('layouts.app')
@section('content')
<div class="content bg-white">
    <h1>Laporan Jurnal Per Jadwal</h1>
    <h2>Mapel {{ $schedule->name }}</h2>
    <h5>Hari {{ $schedule->dayName }}, Jam Pelajaran {{ $schedule->id_studytime_start == $schedule->id_studytime_end ? $schedule->id_studytime_start : $schedule->id_studytime_start.' - '.$schedule->id_studytime_end }}</h5>
    <div class="table-responsive">
        <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal Mengajar</th>
                        <th>Pengajar</th>
                        <th>Materi</th>
                        <th>Sub Materi</th>
                        <th>Hasil</th>
                        <th>Hambatan</th>
                        <th>Solusi</th>
                        <th>Absensi Siswa</th>
                        <th>Tingkat Kepahaman</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no=1 @endphp
                    @forelse($journals as $journal)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $journal->teaching_date }}</td>
                        <td>{{ $journal->teacher->name }}</td>
                        <td>{{ $journal->matter->name }}</td>
                        <td>
                        @php $noSubMateri=1 @endphp
                        @foreach($journal->journal_detail as $jd)
                            {{ $noSubMateri++ }}. {{ $jd->matter_detail->name }}<br>
                        @endforeach
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                        @php $noAbsensi = 1 @endphp
                        @foreach($journal->journal_attendance as $ja)
                            {{ $noAbsensi++ }}. {{ $ja->user->name }} - @switch($ja->status) @case("s") Sakit @break @case("i") Izin @break @default Alpha @endswitch<br>
                        @endforeach
                        </td>
                        <td>
                        @php $sudahPaham = 0; $belumPaham = 0; @endphp
                        @foreach($journal->journal_feedback as $jf)
                            @if ($jf->feedback_option == "y")
                                @php $sudahPaham++; @endphp
                            @else
                                @php $belumPaham++; @endphp
                            @endif
                        @endforeach
                        Paham: {{ $sudahPaham }} <br>
                        Belum Paham: {{ $belumPaham }}
                        </td>
                        <td>
                            <div class="justify-content-around align-items-center d-flex flex-wrap">
                                <a title="Hapus" id="deleteData" data-toggle="modal" data-target="#deleteModal" data-id="{{ $journal->id }}" href="#" class="text-danger" data-action="{{ route('journal.destroy', $journal->id) }}" class="text-danger"><i data-feather="trash" width="14"></i></a>
                            </div>
                        </td>
                        
                    </tr>
                    @empty
                    <tr>
                        <td>Tidak ada data!</td>
                    </tr>
                    @endforelse
                </tbody>
        </table>
    </div>
</div>
<!-- Form Delete Journal  -->
@include('layouts.form-delete', [
        'method' => 'POST',
        'methodx' => 'DELETE',
        'bgDanger' => 'bg-danger',
        'boxConfirmHeader' => '',
        'textWhite' => 'text-white',
        'title_modal' => 'Delete Data Permanently',
        'showdata' => "journal.show-json",
        'title_menu' => 'data journal'])
@endsection