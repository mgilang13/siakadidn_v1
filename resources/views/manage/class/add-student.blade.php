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
                <h1>Classless Students</h1>
            </div>
            <div class="card-body">
                <div class="table-responsive col-md-8">
                    <form action="{{ route('manage.class.add-student.process') }}" method="POST">
                    @csrf
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('manage.class.show', $id) }}" class="btn btn-outline-primary">Kembali</a>
                            <button type="submit" class="btn btn-primary rounded" id="btn-save" >Add Students</button>
                        </div>
                        <input type="hidden" value="{{ $id }}" name="id_mgt_class">
                        <input type="hidden" name="id_student_list" id="" value="">
                        <table class="table table-sm table-striped" id="dtsiswa">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No.</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse($students as $student)
                                <tr>
                                    <td> 
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="id_student[]" value="{{ $student->idUser }}" id="student{{ $student->idUser }}">
                                        </div>
                                    </td>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $student->nis }}</td>
                                    <td>{{ $student->name }}</td>
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
        var table = $('#dtsiswa').DataTable({
            "paging":true,
        });

        $('#btn-save').on('click', function() {
            var data = table.$('input[name="id_student[]"]:checked').map(function(){return $(this).val();}).get();
            $('input[name="id_student_list"]').val(data);
        })
    });
</script>
<script>
    $('input[name="id_student[]"]').on('change', function() {
        $(this).closest('tr').toggleClass('yellow', $(this).is(':checked'));
    });
</script>
@endsection