@extends('layouts.app')

@section('content')
<style>
.yellow {
  background-color: yellow !important;
}
</style>
    <div class="content">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h4>Daftar Kelas yang akan diajar</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive col-md-8">
                    <form action="{{ route('manage.teacher.add-class.process') }}" method="POST">
                    @csrf
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('manage.teacher.show', $id) }}" class="btn btn-outline-primary">Kembali</a>
                            <button type="submit" class="btn btn-primary rounded" >Tambah Kelas</button>
                        </div>
                        <input type="hidden" value="{{ $id }}" name="id_mgt_teacher">
                        <table class="table table-sm table-striped" id="dtkelas">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No.</th>
                                    <th>Kelas</th>
                                    <th>Instansi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse($classrooms as $c)
                                <tr>
                                    <td> 
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="id_class[]" value="{{ $c->idClass }}" id="c{{ $c->idClass }}">
                                        </div>
                                    </td>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $c->className }}</td>
                                    <td><span class="text-uppercase">{{ $c->levelAbbr }}</span> {{ $c->levelDetailName}}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function () {
        $('#dtkelas').DataTable({
            "paging":true,
        });
    });
</script>
<script>
    $('input[name="id_class[]"]').on('change', function() {
        $(this).closest('tr').toggleClass('yellow', $(this).is(':checked'));
    });
</script>
@endsection