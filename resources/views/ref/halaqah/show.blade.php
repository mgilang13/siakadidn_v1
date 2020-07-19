@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h5>Halaqah {{ $halaqah->name }}</h5>
                <h6>Pengampu : {{ $halaqah->user->name }}</h6>

                <div class="header-btn">
                    <a href="{{ route('ref.halaqah.index') }}" class="btn btn-primary">Kembali</a>
                    <a href="{{ route('ref.halaqah.show.add', $halaqah->id ) }}" class="btn btn-primary-outline">
                        <i width="14" class="mr-2" data-feather="plus"></i>Tambah Anggota Halaqah
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
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
                                    <a href="#" class="btn btn-primary btn-sm">Detail ></a>
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



