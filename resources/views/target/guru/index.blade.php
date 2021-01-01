@extends('layouts.app')

@section('content')
<style>
    .ungu {
        background-color:#e8e8e8; !important;
    }

    tr.hide-table-padding td {
        padding: 0;
    }

    .expand-button {
        position: relative;
    }

    .accordion-toggle .expand-button:after
    {
        position: absolute;
        top: 40%;
        transform: translate(0, -50%);
        content: '-';
    }

    .accordion-toggle.collapsed .expand-button:after
    {
        content: '+';
    }
</style>
    <div class="content">
        <div class="card">
            <div class="card-body">
                @include('layouts.notification')
                <h3 class="card-title">Target Kelas yang diajar</h3>
                <div class="d-flex flex-wrap">
                    <div class="col-md-4">
                        <ul class="nav nav-tabs" id="teached-class" role="tablist">
                            @forelse($teachedClass as $index => $tc)
                            <li class="nav-item">
                                <a class="nav-link" data-id_level = "{{ $tc->idLevel }}" data-toggle="tab" href="#{{ $tc->id }}" role="tab" data-id = "{{ $tc->id }}" aria-controls="{{ $tc->id }}"
                                aria-selected="{{ $index == 0 ? 'true' : '' }}">{{ $tc->className }}</a>
                            </li>
                            @empty
                                Tidak ada kelas yang diajar
                            @endforelse
                        </ul>
                        <div class="tab-content" id="teached-class-content">
                            @forelse($teachedClass as $index => $tc)
                            <div class="tab-pane fade" id="{{ $tc->id }}" role="tabpanel" aria-labelledby="{{ $tc->id }}">
                                <p id="{{ $tc->id }}student"></p>
                            </div>
                            @empty
                                Tidak ada data!
                            @endforelse
                        </div>
                    </div>
                    <div class="col-md-8">
                        <form class="form-input-status" action="{{ route("target.update.status") }}" method="post">
                            @csrf
                            @method('PATCH')
                            <textarea class="d-none" id="statusAll" name="status_all"></textarea>
                            <div class="target-category d-none">
                                <div class="d-none target-detail d-flex justify-content-between">
                                    <div class="col-md-6">
                                        <h4 class="h4-responsive">Detail Target <span id="student-name"></span></h4>
                                        <h6>Nama Target : <span id="target-name"></span> <span class="d-none target-subcategory-name"></span></h6>
                                        <h6>Pencapaian/Total : <span id="target-pencapaian"></span>/<span id="target-amount"></span></h6>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center justify-content-end">
                                        <button type="submit" class="d-none submit-process btn btn-success font-weight-bold">Simpan ?</button>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs" id="target-category" role="tablist">
                                
                                </ul>
                                <div class="tab-content d-flex flex-wrap" id="target-subcategory">
                                    
                                </div>
                                <div class="content-detail">
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div> 
            </div>
        </div>
    </div>
@endsection
@if(Auth::user()->roles->first()->pivot->roles_id == 3)
@section('js')
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var status_all = new Array();
    // Ketika tombol kelas diklik
    $('.nav-link').on('click', function(event) {
        var id_student = 0;
        let id_level = $(event.target).data('id_level');
        let id_class = $(event.target).data('id');

        // Get data students
        let data_students = {!! $teachedStudents !!}
        let data_student = data_students.find(result => result.id_class == id_class);
        
        // Membuka dan menutup list student
        $('.tab-pane').removeClass('show active');
        $('.tab-pane').children().empty();
        $('#target-category').children().empty();
        
        // Get data student list
        student = data_student.mgt_class_detail;

        // Me-list student dengan looping
        student.map(function(result) {
            $('#'+id_class+'student')
                .append('<ul class="list-group">'+
                            '<a class="btn-detail list-group-item list-group-item-action d-flex flex-wrap justify-content-between" data-id="'+result.id_student+'" data-name="'+result.user_detail.name+'">'+result.user_detail.name+'</a>'+
                        '</ul>');
        });

        // Ketika tombol detail warna biru diklik, akan membuka side panel
        $('.btn-detail').on('click', function(event) {

            // Get data id student dari tombol detail yang diklik barusan 
            id_student = $(event.target).data('id');
        
            // Get data nama student untuk ditampilkan di sidepanel
            let name = $(event.target).data('name');
            $('#student-name').text(name);

            // Menampilkan tombol kategori, ex: "IDN Mengajar, IT, English Speak Up, dsb"
            $('.target-category').removeClass('d-none');

            // Menyembunyikan button sub-category apabila tombol sub-category yang lain di-click
            $('#target-subcategory').empty();
            $('.content-detail').empty();

            // Memberikan efek background abu-abu untuk student yang dipilih
            if(!$(this).closest('a').hasClass('ungu')) {
                $('a.ungu').removeClass('ungu');
                $(this).closest('a').addClass('ungu');
            }
        });

        // Menampilkan daftar student berdasarkan kelas
        $('#'+id_class).addClass('show active');

        // Menampilkan tab kategori (IDN Mengajar, IT, English, dsb)
        let target_categories = {!! $target_categories !!}
        target_categories.map(function(result) {
            $('#target-category').append('<li class="nav-item">'+
                            '<a data-id="'+result.id+'" data-toggle="tab" class="nav-link btn-category">'+result.name+'</a>'+
                        '</li>');
                        
        });
        
        // Ketika tab kategori diklik maka akan menampilkan content dari kategori tsb.
        $('.btn-category').on('click', function(event) {
            // Get data sub-kategori
            let target_sub_categories = {!! $target_sub_categories !!}
            
            // Get data id_category berdasarkan tab kategori yang sudah di-click
            let id_category = $(event.target).data('id');
            
            // Get data kategori untuk nantinya dicari jumlah / amount untuk setiap kategori tersebut
            let target_category = {!! json_encode($target_category) !!}

            // Toggle untuk swithc tab sub-kategori
            $('#target-subcategory').empty();
            $('.content-detail').empty();
            $('.target-subcategory-name').addClass('d-none');

            // Toggle untuk switch detail target, yang ada di bawahnya judul sidepanel ini.
            $('.target-detail').removeClass('d-none');
            $('#target-name').text($(this).text());
            
            // Get data sub-kategori berdasarkan id_category dan id_level (SMP / SMK)
            target_subcategories = target_sub_categories
                                        .filter(data => data.id_category == id_category)
                                        .filter(data => data.id_level == id_level);
            
            // Jika sub-kategori tidak ada, maka akan langsung menampilkan daftar target yang ada.
            if(target_subcategories.length === 0) {
                let target_all = {!! json_encode($target_all) !!}
                let target_content = target_all
                                        .filter(result => result.id_student == id_student)
                                        .filter(result => result.id_category == id_category);
                
                let target_category_amount = target_category.find(result => result.id == id_category).amount;
                
                $('#target-pencapaian').text(target_content.length);
                $('#target-amount').text(target_category_amount);

                if(target_content[0].target_category.name === "IDN Mengajar") {
                    $('.content-detail').append('<table class="table table-sm" id="idn-mengajar">'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<th scope="col">No.</th>' +
                                                '<th scope="col">Lokasi</th>' +
                                                '<th scope="col">Deskripsi dan Materi</th>' +
                                                '<th scope="col">Status</th>' +
                                            '</tr>'+
                                        '</thead>'+
                                        '<tbody>'+
                                            
                                        '</tbody>' +
                                    '</table>');
                    
                    var counter = 1;
                    target_content.map(function(result) {
                        $('#idn-mengajar > tbody')
                                .append('<tr>'+
                                            '<td>'+ counter +'</td>' +
                                            '<td>'+result.location+'</td>' +
                                            '<td>'+result.description+'</td>' +
                                            '<td>' +
                                                '<div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons">' +
                                                    '<label class="btn btn-success btn-sm px-md-2 py-md-1">' +
                                                        '<input type="radio" name="status['+result.id+']" value="y" id="mengajar'+result.id+'y" class="submit-status"> <i class="fas fa-check"></i>' +
                                                    '</label>' +
                                                    '<label class="btn btn-danger btn-sm px-md-2 py-md-1">' +
                                                        '<input type="radio" name="status['+result.id+']" value="n" id="mengajar'+result.id+'n" class="submit-status"> <i class="fas fa-times"></i>' +
                                                    '</label>' +
                                                '</div>' +
                                            '</td>' +
                                        '</tr>');
                            
                        if(result.status == 'y') {
                            $('#mengajar'+result.id+'y').prop("checked", true);
                            $('#mengajar'+result.id+'y').parent().addClass('active');
                        } else {
                            $('#mengajar'+result.id+'n').prop("checked", true);
                            $('#mengajar'+result.id+'n').parent().addClass('active');
                        }

                            
                        $('#mengajar'+result.id+'y').on('change', function(event) {
                            let value = $(this).val();
                            $('.submit-process').removeClass('d-none');
                            let id_target = result.id;
                            
                            status_all = status_all.filter(data => data.id !== id_target);

                            status_all.push({id: result.id, status:value});
                            
                            $('#statusAll').val(JSON.stringify(status_all));
                        });
                            
                        $('#mengajar'+result.id+'n').on('change', function(event) {
                            let value = $(this).val();
                            $('.submit-process').removeClass('d-none');
                            let id_target = result.id;

                            status_all = status_all.filter(data => data.id !== id_target);

                            status_all.push({id: result.id, status:value});
                            
                            $('#statusAll').val(JSON.stringify(status_all));
                        });
                        
                        counter++;
                    });
                } else if (target_content[0].target_category.name === "English Speak Up") {
                    $('.content-detail').append('<table class="table table-hover table-sm" id="english">'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<th>No.</th>' +
                                                '<th>Nama</th>' +
                                                '<th>Durasi</th>' +
                                                '<th>Link Video</th>' +
                                                '<th>Status</th>' +
                                            '</tr>'+
                                        '</thead>'+
                                        '<tbody>'+
                                            
                                        '</tbody>' +
                                    '</table>');
                    var counter = 1;
                    target_content.map(function(result) {
                        $('#english > tbody')
                                .append('<tr>'+
                                            '<td>'+ counter +'</td>' +
                                            '<td>'+result.name+'</td>' +
                                            '<td>'+result.duration+'</td>' +
                                            '<td><a href="'+result.youtube_link+'">Link Youtube</a></td>' +
                                            '<td>' +
                                                '<div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons">' +
                                                    '<label class="btn btn-success btn-sm px-md-2 py-md-1">' +
                                                        '<input type="radio" name="status['+result.id+']" value="y" id="english'+result.id+'y" class="submit-status"> <i class="fas fa-check"></i>' +
                                                    '</label>' +
                                                    '<label class="btn btn-danger btn-sm px-md-2 py-md-1">' +
                                                        '<input type="radio" name="status['+result.id+']" value="n" id="english'+result.id+'n" class="submit-status"> <i class="fas fa-times"></i>' +
                                                    '</label>' +
                                                '</div>' +
                                            '</td>' +
                                        '</tr>');
                            
                            if(result.status == 'y') {
                                $('#english'+result.id+'y').prop("checked", true);
                                $('#english'+result.id+'y').parent().addClass('active');
                            } else {
                                $('#english'+result.id+'n').prop("checked", true);
                                $('#english'+result.id+'n').parent().addClass('active');
                            }
                            
                            $('#english'+result.id+'y').on('change', function(event) {
                                let value = $(this).val();
                                $('.submit-process').removeClass('d-none');
                                let id_target = result.id;
                                
                                status_all = status_all.filter(data => data.id !== id_target);

                                status_all.push({id: result.id, status:value});
                                
                                $('#statusAll').val(JSON.stringify(status_all));
                            });
                                
                            $('#english'+result.id+'n').on('change', function(event) {
                                let value = $(this).val();
                                $('.submit-process').removeClass('d-none');
                                let id_target = result.id;

                                status_all = status_all.filter(data => data.id !== id_target);

                                status_all.push({id: result.id, status:value});
                                
                                $('#statusAll').val(JSON.stringify(status_all));
                            });
                            counter++;
                        });
                } else if (target_content[0].target_category.name === "Buku/Modul") {
                    $('.content-detail').append('<table class="table table-hover table-sm" id="buku">'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<th>No.</th>' +
                                                '<th>Judul Buku</th>' +
                                                '<th>Jumlah</th>' +
                                                '<th>Status</th>' +
                                            '</tr>'+
                                        '</thead>'+
                                        '<tbody>'+
                                            
                                        '</tbody>' +
                                    '</table>');

                    var counter = 1;
                    target_content.map(function(result) {
                        $('#buku > tbody')
                                .append('<tr>' +
                                            '<td>'+ counter +'</td>'+
                                            '<td>'+result.name+'</td>' +
                                            '<td>'+result.jumlah+'</td>' +
                                            '<td>' +
                                                '<div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons">' +
                                                    '<label class="btn btn-success btn-sm px-md-2 py-md-1">' +
                                                        '<input type="radio" name="status['+result.id+']" value="y" id="buku'+result.id+'y" class="submit-status"> <i class="fas fa-check"></i>' +
                                                    '</label>' +
                                                    '<label class="btn btn-danger btn-sm px-md-2 py-md-1">' +
                                                        '<input type="radio" name="status['+result.id+']" value="n" id="buku'+result.id+'n" class="submit-status"> <i class="fas fa-times"></i>' +
                                                    '</label>' +
                                                '</div>' +
                                            '</td>' +
                                        '</tr>');

                            if(result.status == 'y') {
                                $('#buku'+result.id+'y').prop("checked", true);
                                $('#buku'+result.id+'y').parent().addClass('active');
                            } else {
                                $('#buku'+result.id+'n').prop("checked", true);
                                $('#buku'+result.id+'n').parent().addClass('active');
                            }
                            
                            $('#buku'+result.id+'y').on('change', function(event) {
                                let value = $(this).val();
                                $('.submit-process').removeClass('d-none');
                                let id_target = result.id;
                                
                                status_all = status_all.filter(data => data.id !== id_target);

                                status_all.push({id: result.id, status:value});
                                
                                $('#statusAll').val(JSON.stringify(status_all));
                            });
                                
                            $('#buku'+result.id+'n').on('change', function(event) {
                                let value = $(this).val();
                                $('.submit-process').removeClass('d-none');
                                let id_target = result.id;

                                status_all = status_all.filter(data => data.id !== id_target);

                                status_all.push({id: result.id, status:value});
                                
                                $('#statusAll').val(JSON.stringify(status_all));
                            });

                            counter++;
                        });
                }
                
            } else {
                target_subcategories.map(function(result) {
                    $('#target-subcategory').append('<a class="btn btn-primary btn-sm btn-subcategory" data-id="'+result.id+'">'+result.name+'</a>');
                });

                $('.btn-subcategory').on('click', function(event) {
                    let id_subcategory = $(event.target).data('id');
                    
                    let target_all = {!! json_encode($target_all) !!}
                    let target_content = target_all
                                            .filter(result => result.id_student == id_student)
                                            .filter(result => result.id_category == id_category)
                                            .filter(result => result.id_subcategory == id_subcategory);

                    let target_subcategory = {!! json_encode($target_subcategory) !!}
                    let target_subcategory_amount = target_subcategory.find(result => result.id == id_subcategory).amount;
                    
                    let txt_sub_category = $(this).text();

                    $('.content-detail').empty();
                    $('.target-subcategory-name').removeClass('d-none');
                    $('.target-subcategory-name').text(txt_sub_category);

                    $('#target-pencapaian').text(target_content.length);
                    $('#target-amount').text(target_subcategory_amount);

                    if(target_content.length > 0 ) {
                        if(target_content[0].target_category.name === "IT") {
                            $('.content-detail')
                                .append('<div class="table-responsive">' +
                                            '<table class="table table-striped table-sm" id="it">'+
                                                '<thead>'+
                                                    '<tr>'+
                                                        '<th scope="col">#</th>' +
                                                        '<th scope="col">Nama Program</th>' +
                                                        '<th scope="col">Link Source</th>' +
                                                        '<th scope="col">Link Demo</th>' +
                                                        '<th scope="col">Status</th>' +
                                                    '</tr>'+
                                                '</thead>'+
                                                '<tbody>'+

                                                '</tbody>' +
                                            '</table>'+
                                        '</div>');

                            target_content.map(function(result) {

                                $('#it > tbody')
                                    .append('<tr class="accordion-toggle collapsed" id="'+result.id+'it-accord" data-toggle="collapse" data-parent="#'+result.id+'it-accord" href="#'+result.id+'it-detail">'+
                                                '<td class="expand-button"></td>' +
                                                '<td>'+result.name+'</td>' +
                                                '<td><a href="'+result.repo_link+'">'+result.repo_link+'</a></td>' +
                                                '<td><a href="'+result.demo_link+'">'+result.demo_link+'</a></td>' +
                                                '<td>' +
                                                    '<div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons">' +
                                                        '<label class="btn btn-success btn-sm px-md-2 py-md-1">' +
                                                            '<input type="radio" name="status['+result.id+']" value="y" id="'+result.id+'y" class="submit-status"> <i class="fas fa-check"></i>' +
                                                        '</label>' +
                                                        '<label class="btn btn-danger btn-sm px-md-2 py-md-1">' +
                                                            '<input type="radio" name="status['+result.id+']" value="n" id="'+result.id+'n" class="submit-status"> <i class="fas fa-times"></i>' +
                                                        '</label>' +
                                                    '</div>' +
                                                '</td>' +
                                            '</tr>' +
                                            '<tr class="hide-table-padding">' +
                                                '<td></td>' +
                                                '<td colspan="4">' +
                                                    '<div id="'+result.id+'it-detail" class="collapse in">' +
                                                        '<div class="mb-2">'+
                                                            '<h6 class="h6-responsive badge badge-info">Deskripsi :</h6>' +
                                                            '<p>'+result.description+'</p>' +
                                                        '</div>' +
                                                        '<div class="mb-2">'+
                                                            '<h6 class="h6-responsive badge badge-info">Gambar :</h6>' +
                                                            '<img class="w-100" src="{{ asset("storage/", "") }}'+"/"+result.image_link+'">' +
                                                        '</div>' +
                                                    '</div>' +
                                                '</td>' +
                                            '</tr>');

                                if(result.status == 'y') {
                                    $('#'+result.id+'y').prop("checked", true);
                                    $('#'+result.id+'y').parent().addClass('active');
                                } else {
                                    $('#'+result.id+'n').prop("checked", true);
                                    $('#'+result.id+'n').parent().addClass('active');
                                }

                                
                                $('#'+result.id+'y').on('change', function(event) {
                                    let value = $(this).val();
                                    $('.submit-process').removeClass('d-none');
                                    let id_target = result.id;
                                    
                                    status_all = status_all.filter(data => data.id !== id_target);

                                    status_all.push({id: result.id, status:value});
                                    
                                    $('#statusAll').val(JSON.stringify(status_all));
                                });
                                
                                $('#'+result.id+'n').on('change', function(event) {
                                    let value = $(this).val();
                                    $('.submit-process').removeClass('d-none');
                                    let id_target = result.id;

                                    status_all = status_all.filter(data => data.id !== id_target);

                                    status_all.push({id: result.id, status:value});
                                    
                                    $('#statusAll').val(JSON.stringify(status_all));
                                });
                            });
                           
                        } else if(target_content[0].target_category.name === "Diniyyah") {
                            $('.content-detail')
                                .append('<table class="table table-hover table-sm" id="diniyyah">'+
                                    '<thead>'+
                                        '<tr>'+
                                            '<th>No.</th>' +
                                            '<th>Nama</th>' +
                                            '<th>Durasi</th>' +
                                            '<th>Link Youtube</th>' +
                                            '<th>Status</th>' +
                                        '</tr>'+
                                    '</thead>'+
                                    '<tbody>'+
                                        
                                    '</tbody>' +
                                '</table>');
                            var counter = 1;
                            target_content.map(function(result) {
                            $('#diniyyah > tbody')
                                .append('<tr>'+
                                            '<td>'+ counter +'</td>'+
                                            '<td>'+result.name+'</td>' +
                                            '<td>'+result.duration+'</td>' +
                                            '<td><a href="'+result.youtube_link+'">Link Youtube</a></td>' +
                                            '<td>' +
                                                '<div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons">' +
                                                    '<label class="btn btn-success btn-sm px-md-2 py-md-1">' +
                                                        '<input type="radio" name="status['+result.id+']" value="y" id="diniyyah'+result.id+'y" class="submit-status"> <i class="fas fa-check"></i>' +
                                                    '</label>' +
                                                    '<label class="btn btn-danger btn-sm px-md-2 py-md-1">' +
                                                        '<input type="radio" name="status['+result.id+']" value="n" id="diniyyah'+result.id+'n" class="submit-status"> <i class="fas fa-times"></i>' +
                                                    '</label>' +
                                                '</div>' +
                                            '</td>' +
                                        '</tr>');

                                if(result.status == 'y') {
                                    $('#diniyyah'+result.id+'y').prop('checked', true);
                                    $('#diniyyah'+result.id+'y').parent().addClass('active');
                                } else {
                                    $('#diniyyah'+result.id+'n').prop('checked', true);
                                    $('#diniyyah'+result.id+'n').parent().addClass('active');
                                }

                                $('#diniyyah'+result.id+'y').on('change', function(event) {
                                    let value = $(this).val();
                                    $('.submit-process').removeClass('d-none');
                                    let id_target = result.id;
                                    
                                    status_all = status_all.filter(data => data.id !== id_target);

                                    status_all.push({id: result.id, status:value});
                                    
                                    $('#statusAll').val(JSON.stringify(status_all));
                                });
                                
                                $('#diniyyah'+result.id+'n').on('change', function(event) {
                                    let value = $(this).val();
                                    $('.submit-process').removeClass('d-none');
                                    let id_target = result.id;

                                    status_all = status_all.filter(data => data.id !== id_target);

                                    status_all.push({id: result.id, status:value});
                                    
                                    $('#statusAll').val(JSON.stringify(status_all));
                                });
                                counter++;
                            });
                        }
                    }
                });
            }
        });
    });

});
</script>
@endsection
@endif