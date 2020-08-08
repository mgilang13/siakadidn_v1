@extends('layouts.app')

@section('content')
<div class="content">
    <div class="card">
        <div class="card-header">
            <h5>Daftar Kelas</h5>
            <a href="{{ route('ref.classroom.store') }}" class="btn btn-primary-outline" data-toggle="modal" data-target="#modal" data-type="add" data-title="Tambah Kelas" data-method="post">
                <i width="14" class="mr-2" data-feather="plus"></i>Tambah Kelas
            </a>
        </div>
        <div class="card-body">
            @include('layouts.notification')
            <div class="table-responsive">
                <table class="table table-sm" id="dtkelas">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Kelas</th>
                            <th>Wali Kelas</th>
                            <th>Institusi</th>
                            <th>Deskripsi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $no = 1; @endphp
                    @forelse ($classrooms as $classroom)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $classroom->className }}</td>
                            <td>{{ $classroom->teacherName }}</td>
                            <td><span class="text-uppercase">{{ $classroom->abbrevation }}</span> {{ $classroom->namaLevelDetail }}</td>
                            <td>{{ $classroom->description }}</td>
                            <td>
                                <div class="btn-action d-flex justify-content-around">
                                    <a href="{{ route('ref.classroom.edit', $classroom->id) }}">
                                        <i width="14" color="#04396c" data-feather="edit"></i>
                                    </a>
                                    <a title="Delete" id="deleteData" data-toggle="modal" data-target="#deleteModal" data-id="{{ $classroom->id }}" href="#" class="text-danger" data-action="{{ route('ref.classroom.destroy', $classroom->id) }}">
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
                        'showdata' => "ref.classroom.show-json",
                        'title_menu' => 'Class'])
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Data Kosong!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- modal --}}
@include('ref.classroom.form')
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('#dtkelas').DataTable({
            "paging":true,
        });
    });
</script>

<script>
    $(document).ready(function () {
        // modal 
        $('#modal').on('shown.bs.modal', function (event) {
            $('#name').trigger('focus');
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
    });
</script>
@endsection