@extends('layouts.app')

@section('content')
    <div class="content">
        <h1>Form Input Target</h1>
        <div class="card mt-4 p-3">
            <form action="{{ route('target.store') }}" class="mt-4" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_student" value="{{ $id_student }}">
            <input type="hidden" name="id_class" value="{{ $id_class }}">
            <div class="d-flex flex-wrap justify-content-between">
                <div class="col-md-5 ">
                    <h3 class="mb-3">Detail Target</h3>
                    <div class="form-group" id="id_category_wrap">
                        <select class="form-control" name="id_category" id="id_category">
                            <option value="">Select Target</option>
                            @forelse($target_categories as $tc)
                            <option value="{{ $tc->id }}">{{ $tc->name }}</option>
                            @empty
                            <option value="">Belum ada data</option>
                            @endforelse
                        </select>
                        <textarea class="jsons d-none" name="" id="" cols="30" rows="10">{{ json_encode($target_categories) }}</textarea>
                    </div>

                    <div class="form-group">
                    <H6 class="mt-2">Sub-Kategori Target :</H6>
                        <div id="sub-category">
                    
                        </div>
                    </div>
                    
                    <div class="form-group form-content it buku d-none">
                        <input type="text" class="form-control" name="name" id="name" placeholder="">
                    </div>

                    <div class="form-group form-content buku d-none">
                        <input type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah">
                    </div>

                    <div class="form-group form-content idn-mengajar d-none">
                        <input type="text" class="form-control" name="location" id="location" placeholder="Lokasi">
                    </div>

                    <div class="form-group form-content idn-mengajar it d-none">
                        <textarea name="description" id="description" class="form-control" rows="3" placeholder="Deskripsi"></textarea>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-warning">Reset</button>
                    </div>
                </div>
                <div class="col-md-5 it english diniyyah d-none form-content">
                    <div>
                        <h3 class="mb-3 it d-none form-content">File Projects</h3>
                        <div class="form-group it d-none form-content">
                            <!-- <input type="text" placeholder="Project Mentah" class="form-control" name="repo_link"> -->
                            <label for="repo_file">File Mentah</label>
                            <input type="file" class="form-control-file" name="repo_file">
                        </div>
                        <div class="form-group it d-none form-content">
                            <!-- <input type="text" placeholder="Project Jadi" class="form-control" name="demo_link"> -->
                            <label for="demo_file">File Jadi</label>
                            <input type="file" class="form-control-file" name="demo_file">
                        </div>
                    </div>
                    <div class="mt-5">
                        <h3 class="mb-3">Dokumentasi</h3>
                        <div class="form-group diniyyah english d-none form-content">
                            <input type="text" class="form-control" name="youtube_link" placeholder="Video Link">
                        </div>
                        <div class="form-group it d-none form-content">
                            <label for="image_link">Gambar Project</label>
                            <input class="d-block form-control-file" type="file" name="image_link" id="image_link">
                        </div>
                        <div class="form-group it d-none form-content">
                            <label for="youtube_link">Link Youtube</label>
                            <input class="d-block form-control" type="text" name="youtube_link" id="youtube_link">
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script>
    $('#id_category').on('change', function() {
        $('#sub-category').empty();
        $('.form-content').addClass('d-none');
        let id_category = $('#id_category').val();
        let text_category = $('#id_category option:selected').text();
        
        if(text_category === "IDN Mengajar") {
            $('.content').find('.idn-mengajar').removeClass('d-none');
            $('.idn-mengajar').find('#description').attr('placeholder', 'Deskripsi dan Materi');
        } else if(text_category === "IT") {
            $('.content').find('.it').removeClass('d-none');
            $('.content').find('.it, #name').attr('placeholder', 'Nama Target');
            $('.idn-mengajar').find('#description').attr('placeholder', 'Deskripsi Target');
        } else if (text_category === "English Speak Up") {
            $('.content').find('.english').removeClass('d-none');
        } else if (text_category === "Buku/Modul") {
            $('.content').find('.buku').removeClass('d-none');
            $('.content').find('.buku, #name').attr('placeholder', 'Judul Buku');
        } else if (text_category === "Diniyyah") {
            $('.content').find('.diniyyah').removeClass('d-none');
        }

        
        var jsons_filtered = JSON.parse( $(this).closest('#id_category_wrap').find('.jsons').val() ).find(result => result.id == id_category);

        let data = jsons_filtered.target_sub_category;
        var html = "";
        data.map(function(result) {
            html = "<div class='form-check form-check-inline'>"+
                        "<input class='form-check-input' type='radio' name='id_subcategory' id='id_subcategory"+result.id+"' value='"+result.id+"'>"+
                        "<label class='form-check-label' for='id_subcategory"+result.id+"'>"+result.name+"</label>"+
                    "</div>";
            $('#sub-category').append(html);
        });
        
    });
</script>
@endsection