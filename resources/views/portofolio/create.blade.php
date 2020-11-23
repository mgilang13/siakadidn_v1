@extends('layouts.app')
@section('content')
<style>
.preview {
  position: relative;
  width: 100%;
  max-width: 400px;
}

.preview img {
  width: 100%;
  height: auto;
}

.preview .btn {
    position: absolute;
  
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    background-color: #f4511e;
    color: white;
    padding: 6px 12px;
    border: none;
    cursor: pointer;
    border-radius: 24px;
    text-align: center;
    z-index:1
}

.preview .btn:hover {
    background-color: black;
}
.label-portofolio {
    color:#9ea0a5;
}
.card-title {
    padding: 24px;
    font-size: 16px;
    font-weight: 600;
    line-height: 1.5;
    letter-spacing: normal;
    color: #1f2a36;
    border-bottom: 1px solid #eaedf3;
}
</style>
    <div class="content">
        <div class="container">
            <a href="{{ route('portofolio.index') }}" style="color:#9e9e9e">
                <i data-feather="chevron-left" class="mr-2" width="14"></i>Kembali ke Portofolio Saya
            </a>
            <h3 class="mt-3">Tambah Portofolio</h2>
            <form action="{{ route('portofolio.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="card p-3 mt-4">
                    <div class="card-title">
                        <h5 class="font-weight-bold">Tipe Portofolio</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap">
                            @foreach($types as $type)
                            <div class="custom-control custom-radio col-3 mb-3">
                                <input type="radio" class="custom-control-input" id="{{ $type->id }}" name="id_type" value="{{ $type->id }}" {{ $type->id == 1 ? 'checked' : ''}}>
                                <label class="custom-control-label" for="{{ $type->id }}">{{ $type->name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card p-3 mt-4">
                    <div class="card-title">
                        <h5 class="font-weight-bold">Upload Gambar</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap">
                        @for($i = 1; $i <= 4; $i++)
                            <div class="col-3">
                                <h6 class="font-weight-bold mb-3">Gambar {{ $i }}</h6>
                                <input type="file" name="image[]" id="image{{ $i }}">
                                <div class="preview mt-2" >
                                    <img src="" id="image_preview_{{ $i }}" alt="" class="col-12">
                                    <button type="button" class="btn d-none" id="remove-image{{ $i }}"><i data-feather="x" width="14"></i></button>
                                </div>
                            </div>
                        @endfor
                        </div>
                    </div>
                </div>
                <div class="card p-3 mt-4">
                    <div class="card-title">
                        <h5 class="font-weight-bold">Informasi Portofolio</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-small label-portofolio">Nama Portofolio*</label>
                            <input class="form-control ml-0" type="text" placeholder="Masukkan nama portofolio" name="name">
                            <small class="text-danger font-italic">Nama Portofolio harus diisi</small>
                        </div>
                        <div class="form-group">
                            <label class="font-small label-portofolio">Deskripsi*</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="3" placeholder="Jelaskan tentang aplikasi ini"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="font-small label-portofolio">Aplikasi Pendukung*</label>
                            <select name="support_apps[]" id="supprt_apps" class="selectpicker form-control col" multiple>
                                @foreach($support_apps as $support_app)
                                <option value="{{ $support_app->id }}">{{ $support_app->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-small label-portofolio">Link Publikasi</label>
                            <input class="form-control ml-0" type="text" placeholder="Masukkan link publikasi" name="publication_link">
                        </div>
                        <div class="form-group">
                            <label class="font-small label-portofolio">Link Repository</label>
                            <input class="form-control ml-0" type="text" placeholder="Masukkan link repository" name="repo_link">
                        </div>
                        <button type="submit" class="btn btn-success">Simpan Portofolio</button>
                        <a href="{{ route('portofolio.index') }}" class="btn btn-warning">Batalkan</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $('#support_app').selectpicker();
    </script>

    <script>
    for(let i = 1; i<=4; i++) {
        $('#image'+i).change(function() {
            preview(this);
        });

        function preview(input) {
            if(input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    $('#image_preview_'+i).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);

                $('#remove-image'+i).removeClass('d-none');
            }
        }

        $('#remove-image'+i).on('click', function() {
            $('#image'+i).val('');
            $('#image_preview_'+i).attr('src', '');
            $('#remove-image'+i).addClass('d-none');
        })
    }
    
    </script>
@endsection