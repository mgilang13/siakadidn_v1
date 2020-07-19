@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h5>Daftar Kelompok Tahfidz</h5>
                <div class="header-btn">
                    <a href="{{ route('tahfidz.index') }}" class="btn btn-outline-primary"><i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Halaqah</th>
                                <th>Pengampu</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $no = 1 @endphp
                           @forelse($halaqahs as $halaqah)
                           <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $halaqah->halaqahName }}</td>
                                <td>{{ $halaqah->teacherName }}</td>
                                <td>
                                    <a class="btn btn-info btn-sm" href="{{ route('tahfidz.show-member', $halaqah->id) }}" title="Daftar Anggota Halaqah">
                                        <i width="14" data-feather="list" class="text-white mr-1"></i>
                                        Daftar Anggota
                                    </a>
                                </td>
                            </tr>
                           @empty
                           <tr><td colspan="4" class="text-center">Data Kosong</td></tr>
                           @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection