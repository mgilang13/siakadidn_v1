@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h5>Daftar Halaqah</h5>
                <a href="{{ route('ref.halaqah.store') }}" class="btn btn-primary-outline" data-toggle="modal" data-target="#modal" data-type="add" data-title="Tambah Halaqah" data-method="post">
                    <i width="14" class="mr-2" data-feather="plus"></i>Tambah Halaqah
                </a>
            </div>
            <div class="card-body">
            @include('layouts.notification')
            @include('layouts.form-search', ['name' => 'Halaqah', 'route' => 'ref.halaqah.index'])
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Halaqah</th>
                                <th>Pengampu</th>
                                <th>Deskripsi</th>
                                <th>Kelas</th>
                                <th>Institusi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $no = 1; @endphp
                        @forelse ($halaqah_teacher as $halaqah)
                            <tr>
                                <td>{{ $halaqah_teacher->no++ }}</td>
                                <td>{{ $halaqah->halaqahName }}</td>
                                <td>{{ $halaqah->teacherName }}</td>
                                <td>{{ $halaqah->description }}</td>
                                <td>{{ $halaqah->namaKelas }}</td>
                                <td><span class="text-uppercase">{{ $halaqah->abbrevation }}</span> {{ $halaqah->namaLevelDetail }}</td>
                                <td>
                                    <div class="btn-action d-flex justify-content-around">
                                        <a href="{{ route('ref.halaqah.show', $halaqah->id) }}" title="Tambah Anggota">
                                            <i width="14" class="text-secondary font-weight-bold" data-feather="plus"></i>
                                        </a>
                                        <a href="{{ route('ref.halaqah.edit', $halaqah->id) }}">
                                            <i width="14" color="#04396c" data-feather="edit"></i>
                                        </a>
                                        <a title="Delete" id="deleteData" data-toggle="modal" data-target="#deleteModal" data-id="{{ $halaqah->id }}" href="#" class="text-danger" data-action="{{ route('ref.halaqah.destroy', $halaqah->id) }}">
                                            <i width="14" color="red" data-feather="trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @include('layouts.form-delete', [
                            'method' => 'POST',
                            'methodx' => 'DELETE',
                            'bgDanger' => '',
                            'boxConfirmHeader' => 'box-confirm-header',
                            'textWhite' => '',
                            'title_modal' => 'Delete Data',
                            'showdata' => "ref.halaqah.show-json",
                            'title_menu' => 'halaqah'])
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Data Kosong</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="table-footer">
                    <p>Menampilkan {{ $halaqah_teacher->startNo }} - {{ $halaqah_teacher->currentTotal }} dari {{ $halaqah_teacher->total() }} data</p>
                    {{ $halaqah_teacher->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>

{{-- modal --}}
@include('ref.halaqah.form')
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
            if (confirm(`Hapus Halaqah ${jsons.name}`)) {
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
<script>
    $(document).ready(function() {
        $('.js-example-responsive').select2({
            width: 'style'
        });
    });
</script>
@endsection