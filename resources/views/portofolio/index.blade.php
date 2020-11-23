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
        <h2>Portofolio Saya</h2>
        <div class="card p-2">
            @include('layouts.notification')
            <div class="d-flex flex-wrap">
                <div class="col-4 mb-3">
                    <a href="{{ route('portofolio.create') }}">
                        <div class="card text-center d-flex justify-content-center" style="height:264px">
                            <div class="round mx-auto">
                                <i width="14" data-feather="plus" class="icon text-center mx-auto"></i>
                            </div>
                            <p class="mt-3 font-weight-bold" style="color:#000000">Tambah Portofolio</p>
                        </div>
                    </a>
                </div>
                @forelse($portofolios as $portofolio)
                <div class="col-4 mb-3">
                    <div class="card-deck">
                        <div class="card px-0" data-toggle="modal" data-target="#show-portofolio">
                            <div class="view overlay">
                                @forelse($portofolio->portofolio_image as $index => $portofolio_image)
                                    @if($index == 0)
                                    <img class="card-img-top img-thumbnail" src="{{ asset('storage/portofolios/'.$portofolio_image->image) }}">
                                    <a href="#!">
                                        <div class="mask rgba-white-slight"></div>
                                    </a>
                                    @endif
                                @empty
                                Tidak ada gambar!
                                @endforelse
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">{{ $portofolio->name }}</h4>
                                <p class="card-text">{{ $portofolio->description }}</p>
                                <textarea class="jsons d-none" style="height:500px">{{ json_encode($portofolio) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <p>No Data!</p>
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