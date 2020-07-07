@extends('layouts.app')

@section('content')
<div class="content">
    <div class="card">
        <div class="card-header">
            <h5>Daftar Menu</h5>
            <a href="{{ route('core.menu.add.process') }}" class="btn btn-primary-outline" data-toggle="modal" data-target="#modal" data-type="add" data-method="post" data-title="Tambah Menu"><i width="14" class="mr-2" data-feather="plus"></i>Tambah Menu</a>
        </div>
        @include('layouts.notification')
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="25">No</th>
                        <th width="25">Icon</th>
                        <th>Nama Menu</th>
                        <th width="400">Route</th>
                        <th width="100">Urutan</th>
                        <th width="100"></th>
                    </tr>
                </thead>
                <tbody>
                    {!! $rs_table !!}
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- modal --}}
@include('core.menu.form')
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('#modal').on('shown.bs.modal', function (event) {
            $('#title').trigger('focus');
        });
        $('#modal').on('show.bs.modal', function (event) {
            const target = $(event.relatedTarget);
            // cek tipe
            if (target.attr('data-type') == 'edit') {
                // set data
                var jsons = JSON.parse( target.closest('td').find('.jsons').val() );
                $('#parent').val(jsons.parent);
                $('#title').val(jsons.title);
                $('#name').val(jsons.name);
                $('#icon').val(jsons.icon);
                $('#order').val(jsons.order);
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
            if (confirm(`Hapus menu ${jsons.title}`)) {
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
        });
        $('.icon').click(function (event) {
            event.preventDefault();
            $(this).closest('.form-group').find('[name="icon"]').val($(this).attr('data-icon'));
        })
        $('.dropdown-toggle').on('click', function() {
            $('.dropdown-icon').toggleClass('show');
        })
    });
</script>
@endsection