@extends('layouts.app')

@section('content')
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<style>#more  {display:  none;}</style>
<div class="content">
    <h1 class="text-center text-md-left h1-responsive" name="top">Laporan Detail Absensi</h1>
    <div class="mt-5">
    <a href="{{ route('journal.index') }}" class="btn btn-outline-primary mb-5">Kembali</a>
        <form class="form-inline col" action="{{ route('journal.report.detail-absensi') }}">
            <div class="form-group col-4">
                <label class="col-3" for="id_class">Pilih Kelas</label>
                <select data-live-search="true" name="id_class" id="id_class" class="selectpicker form-control @error('id_class') is-invalid @enderror col">
                    @forelse($classrooms as $classroom)
                    <option value="{{ $classroom->id }}" {{ (old('id_class') ??$classroom->id) == $qClass ? 'selected' : '' }}>{{ $classroom->name }}</option>
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
    <div class="container">
        <div class="table-responsive">
            <table class="table table-sm table-striped" id="journal-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Siswa</th>
                            <th>Sakit</th>
                            <th>Izin</th>
                            <th>Alpha</th>
                            <th>Hadir</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1 @endphp
                        @forelse($students as $student)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $student->name }}</td>
                            <td>
                                @if ($student->sakit != 0)
                                    <div class="badge badge-warning p-2">{{ $student->sakit }}</div>
                                @else
                                    <div>{{ $student->sakit }}</div>
                                @endif
                            </td>
                            <td>
                                @if ($student->izin != 0)
                                    <div class="badge badge-info p-2">{{ $student->izin }}</div>
                                @else
                                    <div>{{ $student->izin }}</div>
                                @endif
                            </td>
                            <td>
                                @if ($student->alpha != 0)
                                    <div class="badge badge-danger p-2">{{ $student->alpha }}</div>
                                @else
                                    <div>{{ $student->alpha }}</div>
                                @endif
                            </td>                        
                            <td>{{ $student->hadir }}</td>
                            <td>
                                <a href="{{ route('journal.report.absensi-student', $student->id_student) }}" data-toggle="popover" data-content="Lihat Absensi {{ $student->name }}">
                                    <i class="fas fa-book ml-3 fa-lg" style="color:#00bfa5 "></i>
                                </a>
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
</div>
@endsection

@section('js')
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
<script>
    $(function () {
        $('[data-toggle="popover"]').popover({
            trigger:'hover',
            placement: 'top',
        })
    })
</script>
@endsection