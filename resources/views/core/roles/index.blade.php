@extends('layouts.app')

@section('content')
<div class="content">
    <div class="card">
        <div class="card-header ">
            <h5>Daftar Hak Akses</h5>
            <a href="{{ route('core.roles.add.process') }}" class="btn btn-primary-outline" data-toggle="modal" data-target="#modal" data-type="add" data-title="Tambah Akses" data-method="post"><i width="14" class="mr-2" data-feather="plus"></i>Tambah Akses</a>
        </div>
        @include('layouts.notification')
        <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th width="25">ID</th>
                    <th>Nama Akses</th>
                    <th width="400">Deskripsi</th>
                    <th width="200">Grup</th>
                    <th width="100">Akses</th>
                    <th width="100"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($all_role as $roles)
                    <tr>
                        <td class="text-center">{{ $roles->id }}</td>
                        <td>{{ $roles->name }}</td>
                        <td>{{ $roles->description }}</td>
                        <td>{{ $roles->group }}</td>
                        <td>
                            <a href="{{ route('core.roles.routes', $roles->id) }}" class="btn btn-info btn-sm btn-block">
                                Akses
                            </a>
                        </td>
                        <td>
                            <div class="btn-action">
                                <a href="{{ route('core.roles.edit.process', $roles->id) }}" data-toggle="modal" data-target="#modal" data-type="edit" data-title="Ubah Akses" data-method="put">
                                    <i width="14" data-feather="edit"></i>
                                </a>
                                <a href="{{ route('core.roles.delete.process', $roles->id) }}" class="text-danger delete">
                                    <i width="14" data-feather="trash"></i>
                                </a>
                                <textarea class="jsons d-none">{{ json_encode($roles) }}</textarea>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="5">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
{{-- modal --}}
@include('core.roles.form')
@endsection

@section('js')
<script>
    $(document).ready(function () {
        // modal 
        $('#modal').on('shown.bs.modal', function (event) {
            $('#name').trigger('focus');
        });
        $('#modal').on('show.bs.modal', function (event) {
            const target = $(event.relatedTarget);
            // cek tipe
            if (target.attr('data-type') == 'edit') {
                // set data
                var jsons = JSON.parse( target.closest('td').find('.jsons').val() );
                $('#name').val(jsons.name);
                $('#description').val(jsons.description);
                $('#group').val(jsons.group);
            }
            $('#modalLabel').html(target.attr('data-title'));
            $('#modal').closest('form').attr('action', target.attr('href'));
            $('#modal').closest('form').attr('method', target.attr('data-method'));
        });
        $('#modal').closest('form').submit(function (event) {
            event.preventDefault();
            // elem
            const elem = $(this);
            const submit = elem.find('[type="submit"]');
            submit.prop('disabled', true);
            console.log(elem.serialize());
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
        $('.delete').click(function (event) {
            event.preventDefault();
            // get data
            var jsons = JSON.parse( $(this).closest('td').find('.jsons').val() );
            if (confirm(`Hapus akses ${jsons.name}`)) {
                // ajax
                axios
                    .delete($(this).attr('href'))
                    .then(result => window.location.reload())
                    .catch(error => {
                        try {
                            alert(error.response.message)
                        } catch (error) {}
                    });
            }
        })
    });
</script>
@endsection