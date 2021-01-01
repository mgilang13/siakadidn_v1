@extends('layouts.app')
@section('content')
<style>
#more  {display:  none;}
</style>
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
                            {{ $noSubMateri++ }}. {{ $jd->matter_detail_other ? $jd->matter_detail_other : $jd->matter_detail->name }}<br>
                        @endforeach
                        </td>
                        <td>
                            {{ \Illuminate\Support\Str::limit($journal->result, 100, '') }}
                            @if (strlen($journal->result) > 100)
                                <span id="dots">...</span>
                                <span id="more">{{ substr($journal->result, 100) }}</span>
                            <button onclick="myFunction()" id="myBtn" class="btn btn-info btn-sm px-1 py-1">Read more</button>
                            @endif
                        </td>
                        <td>{{ $journal->obstacle }}</td>
                        <td>{{ $journal->solution }}</td>
                        <td>
                        @php $noAbsensi = 1 @endphp
                        @forelse($journal->journal_attendance as $ja)
                            {{ $noAbsensi++ }}. {{ $ja->user->name }} - @switch($ja->status) @case("s") Sakit @break @case("i") Izin @break @default Alpha @endswitch<br>
                        @empty
                            Hadir Semua
                        @endforelse
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
                                <a href="{{ route('journal.edit', $journal->id) }}">
                                    <i width="14" data-feather="edit">Edit</i>
                                </a>
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
<script>
function myFunction() {
    var dots = document.getElementById("dots");
    var moreText = document.getElementById("more");
    var btnText = document.getElementById("myBtn");

    if (dots.style.display === "none") {
        dots.style.display = "inline";
        btnText.innerHTML = "Read more";
        moreText.style.display = "none";
    } else {
        dots.style.display = "none";
        btnText.innerHTML = "Read less";
        moreText.style.display = "inline";
    }
}
</script>
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