@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header">
                <div>
                    <h5>Daftar Santri</h5>
                    <h6 class="font-italic">*Daftar santri yang belum memiliki kelompok halaqah</h6>
                </div>
                <div>
                    <a href="{{ route('ref.halaqah.show', $halaqah->id ) }}" class="btn btn-primary-outline">
                        <i width="14" class="mr-2" data-feather="plus"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                @include('layouts.notification')
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>NIS</th>
                                <th>Nama Lengkap</th>
                                <th>Status Halaqah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1 @endphp
                            @forelse ($students as $student)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $student->nis }}</td>
                                <td>{{ $student->user->name }}</td>
                                <td>
                                    <form action="{{ route('ref.halaqah.show.add.process', $student->id_student) }}" method="POST">
                                        @method('PATCH')
                                        @csrf
                                        <input type="hidden" value="{{ $halaqah->id }}" name="id_halaqah">
                                        <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Data kosong!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection