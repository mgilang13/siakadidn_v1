@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                @if(Auth::user()->id == 1 or Auth::user()->roles->first()->pivot->roles_id == 2)
                <div class="row d-flex flex-wrap">
                    <div class="col-md-6">
                        <a href="{{ route('tahfidz.list-halaqah') }}" class="btn btn-secondary btn-lg w-100">
                            <i class="text-white mr-2 mb-1" data-feather="list" width="20"></i> Daftar Halaqah Santri IDN
                        </a>
                    </div>    
                    <div class="col-md-6">
                        <a href="{{ route('tahfidz.list-santri') }}" class="btn btn-primary btn-lg w-100">
                            <i class="text-white mr-2 mb-1" data-feather="list" width="20"></i>Daftar Semua Santri IDN
                        </a>
                    </div>
                @elseif( Auth::user()->roles->first()->pivot->roles_id == 3)
                    @if($halaqah != null)
                    <div class="col-md-6">
                            <a href="{{ route('tahfidz.halaqah', Auth::user()->id) }}" class="btn btn-primary btn-lg w-100">
                                <i class="text-white mr-2 mb-1" data-feather="list" width="20"></i>Halaqah Tahfidz
                            </a>
                    </div>
                    @else
                    <div class="card bg-warning py-4">
                        <div class="row">
                            <div class="col">
                                <h5 class="font-weight-bold">Afwan, Ustadz Belum Memiliki Grup Halaqah</h5>
                                <h6 class="font-italic">Silahkan buat grup halaqah melalui menu referensi di bawah ini</h6>
                            </div>
                            <div class="col-1 d-md-flex align-items-center d-none">
                                <i width="27" data-feather="alert-triangle" ></i>
                            </div>
                        </div>
                    </div>
                    @endif
                @elseif( Auth::user()->roles->first()->pivot->roles_id == 5)
                    <div class="col-md-6">
                        <a href="{{ route('tahfidz.report.parent', Auth::user()->id) }}" class="btn btn-primary btn-lg w-100">
                            <i class="text-white mr-2 mb-1" data-feather="list" width="20"></i>Laporan untuk Orang Tua
                        </a>
                    </div>
                @elseif( Auth::user()->roles->first()->pivot->roles_id == 4)
                    <div class="col-md-6">
                        <a href="{{ route('tahfidz.show', Auth::user()->id )}}" class="btn btn-info btn-lg w-100">
                            <i class="text-white mr-2 mb-1" data-feather="list" width="20"></i> Laporan dan Mutaba'ah Tahfidz
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection