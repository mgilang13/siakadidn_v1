@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h5>Daftar Guru</h5>
                <a href="{{ route('ref.teacher.create') }}" class="btn btn-primary-outline">
                    <i width="14" class="mr-2" data-feather="plus"></i>Tambah Guru
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Guru</th>
                                <th>Bidang</th>
                                <th>Materi Pelajaran</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection