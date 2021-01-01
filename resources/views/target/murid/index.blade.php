@extends('layouts.app')
@section('content')
<style>
    .img-carousel {
        object-fit:cover;
        width:300px;
        height:270px !important;
    }
    .show {
        transition: opacity 50ms;
    }
    .img-thumbnail {
        object-fit:cover;
        height:150px;
    }
    .card .round {
        width: 100px;
        height: 100px;
        padding: 30px;
        border-radius: 50%;
        background-color: #ebf7ed;
    }
    .round .icon {
        width: 40px;
        height: 40px;
        z-index: 99;
        color: #34aa44;
    }
    #support_app {
        display:inline-flex;
    }
</style>
    <div class="content">
        <h2>Target Saya</h2>
        <div class="card p-2">
            @include('layouts.notification')
            <div class="d-flex flex-wrap">
                <div class="col-4 mb-3">
                    <a href="{{ route('target.create') }}">
                        <div class="card text-center d-flex justify-content-center" style="height:264px">
                            <div class="round mx-auto">
                                <i width="14" data-feather="plus" class="icon text-center mx-auto"></i>
                            </div>
                            <p class="mt-3 font-weight-bold" style="color:#000000">Tambah Target</p>
                        </div>
                    </a>
                </div>

                @forelse($targets as $target)
                <div class="col-4 mb-3">
                    <div class="card">
                        <div class="card-title">
                            <h3>{{ $target->name ? $target->name : $target->target_category->name }}</h3>
                            <p>{{ $target->jumlah ? "Jumlah :".$target->jumlah :  '' }}</p>
                            <p>{{ $target->location ? "Lokasi :".$target->location :  '' }}</p>
                            <p>{{ $target->description ? "Deskripsi :".$target->description :  '' }}</p>
                            <p>{{ $target->duration ? "Durasi :".$target->duration :  '' }}</p>
                            <p>{!! $target->youtube_link ? "<a href='".$target->youtube_link."'>Link Video</a>" : '' !!}</p>
                            <p>{!! $target->repo_link ? "<a href='".$target->repo_link."'>Link Project Mentah</a>" : '' !!}</p>
                            <p>{!! $target->demo_link ? "<a href='".$target->demo_link."'>Link Project Jadi</a>" : '' !!}</p>
                            <p>{{ $target->total_hafalan ? "Total Hafalan :".$target->total_hafalan : '' }}</p>
                            {!! $target->image_link ? "<img class='w-100' src='".asset("storage/".$target->image_link)."'>" : '' !!}
                        </div>
                    </div>
                </div>
                @empty

                @endforelse
            </div>
        </div>
    </div>
    @include('portofolio.modal-show')

    <script>
        $(document).ready(function () {
            // modal 
            $('#show-portofolio').on('show.bs.modal', function (event) {
                const target = $(event.relatedTarget);
                var jsons = JSON.parse( target.closest('.card').find('.jsons').val() );
                var images = jsons.portofolio_image;
                var apps = jsons.portofolio_app;
                $('#name').text(jsons.name);
                $('#description').text(jsons.description);
                $('#publication_link').text(jsons.publication_link);
                $('#repo_link').text(jsons.repo_link);
                
                apps.map(function(result) {
                    let support_apps = result.support_app;
                    $('#support_app').append('<div class="mr-3 px-3 py-2" style="background-color:#efefef;border-radius:25px">'+
                                            support_apps.name+
                                            '</div>');
                });

                images.map(function(result) {
                    $('.carousel-inner').append('<div class="carousel-item ">'+
                                                '<img src="{{ asset("storage/portofolios/", "") }}'+"/"+result.image+'" class="d-block w-100 img-carousel" alt="...">'+
                                                '</div>');
                });

                $('.carousel-inner div:first').addClass('active');
            });
            $('#show-portofolio').on('hidden.bs.modal', function(event) {
                $('.carousel-inner').empty();
            });
        });
    </script>
@endsection