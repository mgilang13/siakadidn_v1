@extends('layouts.app')

@section('content')
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<style>#more  {display:  none;}</style>
<div class="content">
    <h1 class="text-center text-md-left h1-responsive" name="top">Laporan Detail Jurnal</h1>
    <div class="mt-5">
    <a href="{{ route('journal.index') }}" class="btn btn-outline-primary mb-5">Kembali</a>
        <form class="form-inline col" action="{{ route('journal.report.detail') }}">
            <div class="form-group col-4">
                <label class="col-3" for="id_teacher">Pilih Guru</label>
                <select data-live-search="true" name="id_teacher" id="id_teacher" class="selectpicker form-control @error('id_teacher') is-invalid @enderror col">
                    <option value="">No Selecting</option>
                    @forelse($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ (old('id_teacher') ?? $teacher->id) == $qTeacher ? 'selected' : '' }}>{{ $teacher->name }}</option>
                    @empty
                    <option value="">No data!</option>
                    @endforelse
                </select>
            </div>
            <div class="form-group">
                <input type="date" name="start_date" class="form-control mr-2" value="{{ $start_date }}">
            </div>
            <div class="form-group">
                <input type="date" name="end_date" class="form-control mr-2" value="{{ $end_date }}">
            </div>
            <button type="submit" class="btn indigo btn-sm text-white"><i data-feather="search" class="mr-1" widthe="14"></i> Search</button>
            <button type="button" onclick="printJournal()" class="btn special-color btn-sm text-white"><i data-feather="printer" width="14" class="mr-1"></i>Print</button>
        </form>
        
    </div>
    <div class="table-responsive" style="overflow-x:scroll">
        <table class="table table-sm table-striped" style="width:1500px" id="journal-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal Mengajar</th>
                        <th>Kelas (Jam Pelajaran)</th>
                        <th>Pengajar</th>
                        <th>Materi</th>
                        <th>Sub Materi</th>
                        <th>Hasil</th>
                        <th>Hambatan</th>
                        <th>Solusi</th>
                        <th style="width:20%">Absensi Siswa</th>
                        <th>Tingkat Kepahaman</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no=1 @endphp
                    @php 
                        $no = 1;
                        setlocale(LC_TIME, 'id_ID'); 
                    @endphp
                    @forelse($journals as $journal)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ \Carbon\Carbon::parse($journal->teaching_date)->formatLocalized('%A, %d %B %Y') }}</td>
                        <td>{{ $journal->journal_schedule->class->name }} ({{ $journal->journal_schedule->id_studytime_start }} - {{ $journal->journal_schedule->id_studytime_end }})</td>
                        <td>{{ $journal->teacher->name }}</td>
                        <td>{{ $journal->matter->name }}</td>
                        <td>
                        @php $noSubMateri=1 @endphp
                        @foreach($journal->journal_detail as $jd)
                            {{ $noSubMateri++ }}. {{ $jd->id_matter_detail ? $jd->matter_detail->name : $jd->matter_detail_other }}<br>
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
function printJournal() {
    var date_now = Date.now();

    $("#journal-table").table2excel({
        exclude: ".excludeThisClass",
        name: "Laporan Jurnal Guru",
        filename: "jurnal"+date_now+".ods", // do include extension
        preserveColors: false // set to true if you want background colors and font colors preserved
    });
}
</script>
<script>
    $('#id_teacher').selectpicker();
</script>
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
@endsection