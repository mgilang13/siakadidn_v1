@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="card p-3">
            <div class="d-flex flex-wrap">
                <div class="col-md-12">
                    <h3>Kategori Target</h3>
                    <a href="{{ route('target.category.store') }}" type="button" data-toggle="modal" data-target="#modalAddCategory" class="btn btn-primary">Tambah Kategori</a>
                    @include('layouts.notification')
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Sub Kategori</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @forelse($target_categories as $tc)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $tc->name }}</td>
                                <td width="300px">
                                    <ol>
                                    @forelse($tc->target_sub_category as $tsc)
                                    <li>
                                        {{ $tsc->name }} 
                                        <a href="{{ route('target.subcategory.delete', $tsc->id) }}" title="Delete Sub-Kategori" class="delete-subcategory">
                                            <i data-feather="x" width="15" stroke-width="3" class="ml-2 text-danger"></i>
                                        </a>
                                        <textarea class="jsons d-none">{{ json_encode($tsc) }}</textarea>
                                    </li>
                                    @empty
                                    Belum ada data
                                    @endforelse
                                    </ol>
                                </td>
                                
                                <td width="300px">
                                    <a href="{{ route('target.category.delete', $tc->id) }}" title="Delete Kategori" class="delete text-danger mr-3" >
                                        <i data-feather="trash" color="red" width="14"></i>
                                    </a>
                                    <a href="{{ route('target.subcategory.store') }}" class="add-sub-category btn btn-info-outline btn-sm p-2 text-info" data-toggle="modal" data-id_category="{{ $tc->id }}" data-target="#modalAddCategory">
                                        <i data-feather="plus" width="14" class="mr-1"></i>Sub-Kategori
                                    </a>
                                    <textarea class="jsons d-none">{{ json_encode($tc) }}</textarea>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">No Data!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @include('target.category.form')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
$('#modalAddCategory').on('shown.bs.modal', function(event) {
    $('#name').trigger('focus');
});
$('#modalAddCategory').on('show.bs.modal', function (event) {
    const target = $(event.relatedTarget);

    let id_category = target.data('id_category');
    $('#id_category').val(id_category);
    $('#modalAddCategory').closest('form').attr('action', target.attr('href'));
});

$('.delete').click(function (event) {
    event.preventDefault();
    // get data
    var jsons = JSON.parse( $(this).closest('td').find('.jsons').val() );
    if (confirm(`Hapus Kategori Target ${jsons.name}`)) {
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

$('.delete-subcategory').click(function (event) {
    event.preventDefault();
    // get data
    var jsons = JSON.parse( $(this).closest('li').find('.jsons').val() );
    if (confirm(`Hapus Sub-Kategori Target ${jsons.name}`)) {
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
</script>
@endsection