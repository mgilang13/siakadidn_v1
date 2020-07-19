@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                @if(Auth::user()->id == 1)
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