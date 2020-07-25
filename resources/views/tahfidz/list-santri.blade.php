@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h5>Daftar Santri</h5>
                <div class="header-btn">
                    <a href="{{ route('tahfidz.index') }}" class="btn btn-outline-primary btn-sm"><i width="14" class="mr-2" data-feather="arrow-left"></i>Kembali</a>
                </div>
            </div>
            <div class="card-body">
                @include('layouts.form-search', ['name' => 'Siswa', 'route' => 'tahfidz.list-santri'])
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Username</th>
                                <th>Nama Santri</th>
                                <th>Nama Halaqah</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $no = 1 @endphp
                           @forelse($user_students as $ush)
                           <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $ush->nis }}</td>
                                <td>{{ $ush->username }}</td>
                                <td>{{ $ush->santriName }}</td>
                                <td>{{ $ush->halaqahName }}</td>
                                <td>
                                    <a class="btn btn-info btn-sm" href="{{ route('tahfidz.show-member', $ush->id) }}" title="Lihat Mutaba'ah">
                                        <i width="14" data-feather="list" class="text-white mr-1"></i>
                                        Lihat Mutaba'ah
                                    </a>
                                </td>
                            </tr>
                           @empty
                           <tr><td colspan="4" class="text-center">Data Kosong</td></tr>
                           @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="table-footer">
                    <p>Menampilkan {{ $user_students->startNo }} - {{ $user_students->currentTotal }} dari {{ $user_students->total() }} data</p>
                    {{ $user_students->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection