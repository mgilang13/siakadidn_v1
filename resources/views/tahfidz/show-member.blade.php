@extends('layouts.app')
@section('content')
    <div class="content">
    <h1 class="h1-responsive text-center text-md-left">Tahfidz</h1>
        <div class="card">
            <div class="card-header d-flex flex-wrap justify-content-center justify-content-lg-between">
                <div>
                <h5 class="text-center text-md-left">Nama Halaqah : {{ $halaqah->name }}</h5>
                <h6 class="text-center text-md-left">Pengampu : {{ $halaqah->user->name }}</h6>
                </div>
                <div class="header-btn">
                    @if( Auth::user()->roles->first()->pivot->roles_id == 3)
                        <a href="{{ route('tahfidz.index') }}" class="btn btn-outline-primary btn-sm"><i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali</a>
                    @else
                        <a href="{{ route('tahfidz.list-halaqah') }}" class="btn btn-outline-primary btn-sm"><i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali</a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Siswa</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $no = 1 @endphp
                        @forelse ($listed_members as $listed_member)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $listed_member->name }}</td>
                                <td>
                                    <a href="{{ route('tahfidz.show', $listed_member->id) }}" class="btn btn-mdb-color btn-sm">Lembar Mutaba'ah</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center">Data Kosong!</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div> 
            </div>
        </div>
    </div>
@endsection



