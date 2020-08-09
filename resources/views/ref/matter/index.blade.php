@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header bg-white">
                <h5>Daftar Materi Pelajaran</h5>
                <a href="{{ route('ref.matter.store') }}" class="btn btn-primary-outline" data-toggle="modal" data-target="#modal" data-type="add" data-title="Tambah Materi" data-method="post">
                    <i width="14" class="mr-2" data-feather="plus"></i>Tambah Materi
                </a>
            </div>
            <div class="card-body">
            @include('layouts.notification')
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Materi</th>
                                <th>Mata Pelajaran</th>
                                <th>Deskripsi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $no = 1; @endphp
                        @forelse ($matters as $matter)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $matter->name }}</td>
                                <td>{{ $matter->subjectName}}</td>
                                <td>{{ $matter->description }}</td>
                                <td>
                                    <div class="btn-action d-flex justify-content-around">
                                        <a href="{{ route('ref.matter.edit', $matter->id) }}" >
                                            <i width="14" color="#04396c" data-feather="edit"></i>
                                        </a>
                                        <a title="Delete" id="deleteData" data-toggle="modal" data-target="#deleteModal" data-id="{{ $matter->id }}" href="#" class="text-danger" data-action="{{ route('ref.matter.destroy', $matter->id) }}">
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
                            'showdata' => "ref.matter.show-json",
                            'title_menu' => 'matter'])

                        @empty
                            <tr><td colspan="4" class="text-center">Data Kosong</td></tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
{{-- modal --}}
@include('ref.matter.form')
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
                $('#matter').val(jsons.matter);
                $('#description').val(jsons.description);
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
            if (confirm(`Hapus Materi ${jsons.name}`)) {
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