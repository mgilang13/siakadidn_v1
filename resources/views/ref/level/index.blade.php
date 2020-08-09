@extends('layouts.app')

@section('content')
    <div class="content">
    
        <div class="card">
            <div class="card-header bg-white">
                <h2>Jenjang dan Detail Pendidikan</h5>
            </div>
            
            @include('layouts.notification')
            <div class="card-body d-flex flex-wrap justify-content-md-between">
                <div class="table-responsive col-md-5 shadow">
                    <div class="mx-3 d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <h5 class="h5-responsive">Jenjang Pendidikan</h5>
                        </div>
                        <a href="{{ route('ref.level.store') }}" class="btn indigo btn-sm" data-toggle="modal" data-target="#modal" data-type="add" data-title="Tambah Jenjang Pendidikan" data-method="post">
                            <i width="15" class="text-white" data-feather="plus"></i>
                        </a>
                    </div>
                    
                    <table class="table table-sm table-hover" id="dtlevel">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenjang</th>
                                <th>Singkatan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $no = 1; @endphp
                        @forelse ($levels as $level)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $level->name }}</td>
                                <td class="text-uppercase">{{ $level->abbr}}</td>
                                <td>
                                    <div class="btn-action d-flex justify-content-around">
                                        <a href="{{ route('ref.level.edit', $level->id) }}" >
                                            <i width="14" color="#04396c" data-feather="edit"></i>
                                        </a>
                                        <a title="Delete" id="deleteData" data-toggle="modal" data-target="#deleteModal" data-id="{{ $level->id }}" href="#" class="text-danger" data-action="{{ route('ref.level.destroy', $level->id) }}">
                                            <i width="14" color="red" data-feather="trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                             <!-- Delete Data Materi -->
                        @include('layouts.form-delete', [
                            'method' => 'POST',
                            'methodx' => 'DELETE',
                            'bgDanger' => '',
                            'boxConfirmHeader' => 'box-confirm-header',
                            'textWhite' => '',
                            'title_modal' => 'Delete Data',
                            'showdata' => "ref.level.show-json",
                            'title_menu' => 'level'])
                        @empty
                            <tr><td colspan="4" class="text-center">Data Kosong</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
              
                <div class="table-responsive col-md-5 shadow">
                    <div class="mx-3 d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <h5 class="h5-responsive">Detail Jenjang</h5>
                        </div>
                        <a href="{{ route('ref.level.detail.store') }}" class="btn indigo btn-sm" data-toggle="modal" data-target="#modalDetail" data-type="add" data-title="Tambah Detail Jenjang" data-method="post">
                            <i width="15" class="text-white" data-feather="plus"></i>
                        </a>
                    </div>

                    <table class="table table-sm table-hover" id="dtleveldetail">
                        <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Detail Jenjang</th>
                                    <th>Alamat</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php $no = 1; @endphp
                            @forelse ($level_details as $level_detail)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $level_detail->name }}</td>
                                    <td class="text-capitalize">{{ $level_detail->address }}</td>
                                    <td>
                                        <div class="btn-action d-flex justify-content-around">
                                            <a href="{{ route('ref.level.detail.edit', $level_detail->id) }}" >
                                                <i width="14" color="#04396c" data-feather="edit"></i>
                                            </a>
                                            <a title="Delete" id="deleteDataDetail" data-toggle="modal" data-target="#deleteModalDetail" data-id="{{ $level_detail->id }}" href="#" class="text-danger" data-action="{{ route('ref.level.detail.destroy', $level_detail->id) }}">
                                                <i width="14" color="red" data-feather="trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            
                            <!-- Delete Data Materi -->
                            @include('ref.level.detail.form-delete', [
                                'method' => 'POST',
                                'methodx' => 'DELETE',
                                'bgDanger' => '',
                                'boxConfirmHeader' => 'box-confirm-header',
                                'textWhite' => '',
                                'title_modal' => 'Delete Data',
                                'showdata' => "ref.level.detail.show-json",
                                'title_menu' => 'level detail'])
                                
                            @empty
                                <tr><td colspan="4" class="text-center">Data Kosong</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </table>
                </div>
            </div>
            {{-- modal --}}
            @include('ref.level.detail.form')
        </div>
    </div>
    {{-- modal --}}
    @include('ref.level.form')
@endsection

@section('js')
                    
<script>
    $(document).ready(function () {
        // modal 
        $('#modal').on('shown.bs.modal', function (event) {
            $('#name').trigger('focus');
        });
        
        // modal 
        $('#modalDetail').on('shown.bs.modal', function (event) {
            $('#name').trigger('focus');
        });

        $('#modalDetail').on('show.bs.modal', function (event) {
            const target = $(event.relatedTarget);
            $('#modalLabelDetail').html(target.attr('data-title'));
            $('#modalDetail').closest('form').attr('action', target.attr('href'));
            $('#modalDetail').closest('form').attr('method', target.attr('data-method'));
        });

        $('#modal').on('show.bs.modal', function (event) {
            const target = $(event.relatedTarget);
            $('#modalLabel').html(target.attr('data-title'));
            $('#modal').closest('form').attr('action', target.attr('href'));
            $('#modal').closest('form').attr('method', target.attr('data-method'));
        });

        
        $('#modal').closest('form').submit(function (event) {
            event.preventDefault();
            // elem
            const elem = $(this);
            const submit = elem.find('#submit-level');
            submit.prop('disabled', true);
            // ajax
            axios({
                method: elem.attr('method'),
                url: elem.attr('action'),
                data: elem.serialize()
            })
                .then(result => window.location.reload())
                .catch(error => {
                    try {
                        const errors = error.response.data.errors;
                        Object.keys(errors).forEach(key => {
                            const elem = $(`#${key}`)
                            const err = errors[key][0] || 'Error';
                            elem.addClass('is-invalid')
                            $(`#${key}-message`).html(err);
                        })
                    } catch (error) {}
                })
                .finally(() => submit.prop('disabled', false));
        });

        $('#modalDetail').closest('form').submit(function (event) {
            event.preventDefault();
            // elem
            const elem = $(this);
            const submit = elem.find('#submit-detail');
            submit.prop('disabled', true);
            // ajax
            axios({
                method: elem.attr('method'),
                url: elem.attr('action'),
                data: elem.serialize()
            })
                .then(result => window.location.reload())
                .catch(error => {
                    try {
                        const errors = error.response.data.errors;
                        Object.keys(errors).forEach(key => {
                            const elem = $(`#${key}`)
                            const err = errors[key][0] || 'Error';
                            elem.addClass('is-invalid')
                            $(`#${key}-message`).html(err);
                        })
                    } catch (error) {}
                })
                .finally(() => submit.prop('disabled', false));
        });
    });
</script>
@endsection