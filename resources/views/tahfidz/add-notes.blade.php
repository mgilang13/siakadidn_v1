@extends('layouts.app')

@section('content')
<div class="content">
    <h1>Tahfidz / {{ $student->user->name }}</h1>
    <h6>Lembar Ziyadah / Murajaah</h6>
    <h5>Halaqah {{ $halaqah->name }}</h5>
    <form action="{{ route('tahfidz.store') }}" method="POST">
    @csrf
        <div class="content-header d-flex justify-content-end">
            <div class="header-btn">
                <a href="{{ route('tahfidz.show', $student->id_student) }}" class="btn btn-primary-outline"><i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow">
                <input type="hidden" value="{{ $student->id_student }}" name="id_student">
                <input type="hidden" value="{{ $halaqah->id_teacher }}" name="id_teacher">
                <input type="hidden" value="{{ $halaqah->id }}" name="id_halaqah">
                <div class="row mt-2 mt-md-4">
                    <div class="col">
                        <div class="row bg-primary rounded p-1">
                            <div class="form-group col-md-5">
                                <label for="tanggal_setor" class="col-for-label text-light">Tanggal Setor</label>
                                <input type="date" class="form-control" name="tanggal_setor" value="{{ $tanggal_sekarang }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="absen" class="col-for-label text-light font-weight">Absensi</label>
                                <select name="absen" id="absen" class="form-control">
                                    <option value="h" class="alert alert-success pt-2" selected>Hadir</option>
                                    <option value="a" class="alert alert-danger">Alpha</option>
                                    <option value="i" class="alert alert-warning" >Izin</option>
                                    <option value="s" class="alert alert-info">Sakit</option>
                                </select>
                            </div>
                        </div>
                        

                        <div class="form-group mt-2 mt-md-5 d-flex justify-content-between">
                            <div>
                                <div><label for="type" class="col-for-label">Tipe Hafalan :</label></div>
                                <div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons" id="type">
                                    <label class="btn btn-success active px-md-4 py-md-2">
                                        <input type="radio" name="type" value="sabaq" id="sabaq" autocomplete="off" checked> Sabaq
                                    </label>
                                    <label class="btn btn-success px-md-4 py-md-2">
                                        <input type="radio" name="type" value="manzil" id="manzil" autocomplete="off"> Manzil
                                    </label>
                                </div>
                            </div>
                            <div>
                                <div><label for="assessment" class="col-for-label">Penilaian :</label></div>
                                <div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons" id="assessment">
                                    <label class="btn btn-info px-md-4 py-md-2 active">
                                        <input type="radio" name="assessment" value="a" id="a" autocomplete="off" checked> A
                                    </label>
                                    <label class="btn btn-info px-md-4 py-md-2">
                                        <input type="radio" name="assessment" value="b" id="b" autocomplete="off"> B
                                    </label>
                                    <label class="btn btn-info px-md-4 py-md-2">
                                        <input type="radio" name="assessment" value="c" id="c" autocomplete="off"> C
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>   
            </div>
        </div>
        <div class="col-md-6">
                <div class="card shadow">
                    <div class="form-group mt-2 mt-md-4">
                        <label for="soorah_start" class="col-for-label">Mulai :</label>
                        <div class="row">
                            <select name="soorah_start" id="soorah_start" class="w-50 form-control mr-4">
                                <option value="">-- Pilih Surat --</option>
                                @include('layouts.option-soorahs.option-soorah', ['soorahs' => $soorahs])
                            </select>
                            <input name="verse_start" type="number" min="1" max="286" placeholder="Ayat Awal" class="col form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="soorah_end" class="col-for-label">Selesai :</label>
                        <div class="row">
                            <select name="soorah_end" id="soorah_end" class="w-50 form-control mr-4">
                                <option value="">-- Pilih Surat --</option>
                                @include('layouts.option-soorahs.option-soorah', ['soorahs' => $soorahs])
                            </select>
                            <input name="verse_end" type="number" min="1" max="286" placeholder="Ayat Akhir" class="col form-control">
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <div class="row">
                            <input type="number" max="25" name="page" class="mr-4 col form-control" placeholder="Halaman">
                            <select name="line" id="line" class="form-control w-50">
                                <option value="0">-- Jumlah Baris --</option>
                                @for ($i = 1; $i<=15; $i++)
                                    <option class="bg-secondary text-light" value="{{ $i }}">{{ $i }} baris</option>
                                @endfor
                            </select>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        $("select#absen").change(function () {
            var selectedAbsen = $(this).children("option:selected").val();
            console.log(selectedAbsen);
            if(selectedAbsen != "h") {
                $('form input[type="number"]').prop("disabled", true);
                $('form input[type="radio"]').removeAttr("checked");
                $('form label').removeClass("active");
                $('form input[type="radio"]').prop("disabled", true);
                $('form select#soorah_start').prop("disabled", true);
                $('form select#soorah_end').prop("disabled", true);
                $('form select#line').prop("disabled", true);
            } else {
                $('form input[type="number"]').prop("disabled", false);
                $('form select').prop('disabled', false);
                $('form input[type="radio"]').prop("disabled", false);
            }
        });
    });
</script>
@endsection