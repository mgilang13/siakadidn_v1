@extends('layouts.app')

@section('content')
<div class="content">
    <div class="content-header">
        <h2>Hak Akses</h2>
    </div>
    <div class="card">
        <div class="card-header">
            <h5>Akses Routes {{ $roles->name }}</h5>
            <a href="{{ route('core.roles') }}" class="btn btn-primary-outline"><i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali</a>
        </div>
        @include('layouts.notification')
        <form action={{ route('core.roles.routes.update.process', $roles->id) }} method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="25">No</th>
                            <th>Nama Route</th>
                            <th width="150">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="check-all">
                                    <label class="custom-control-label" for="check-all">Select All?</label>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rs_routes as $index => $routes)
                            <tr>
                                <td class="text-center">{{ $index+1 }}</td>
                                <td>{{ $routes['name'] }}</td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="hidden" name="name[{{ $index }}]" value="{{ $routes['name'] }}">
                                        <input type="checkbox" name="access[{{ $index }}]" class="custom-control-input check-all" value="yes" id="routes__{{ $index }}" {{ $routes['access'] ? 'checked' : '' }}>
                                        <label class="custom-control-label check-all-label" for="routes__{{ $index }}">{{ $routes['access'] ? 'Bisa' : 'Tidak Bisa' }}</label>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="3">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="text-right mt-4">
                <button type="submit" class="btn btn-primary d-inline">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('#check-all').change(function () {
            $('.check-all').prop('checked', $(this).prop('checked'));
            $('.check-all-label').html( $(this).prop('checked') ? 'Bisa' : 'Tidak Bisa');
        })
        // check-all-label
        $('.check-all').change(function () {
            $(this).siblings('label').html( $(this).prop('checked') ? 'Bisa' : 'Tidak Bisa');
        })
    });
</script>
@endsection