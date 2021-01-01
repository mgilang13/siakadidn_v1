@extends('layouts.app')

@section('content')
    <div class="content">
    @if(Auth::user()->roles->first()->pivot->roles_id == 4)
        @include('target.murid.index', ['targets' => $targets])
    @elseif(Auth::user()->roles->first()->pivot->roles_id == 11)
        @include('target.kaprodi.index', ['target_all' => $target_all])
    @elseif(Auth::user()->roles->first()->pivot->roles_id == 3)
        @include('target.guru.index')
    @elseif(Auth::user()->id = 1)
        @include('target.admin.index')
    @endif
    </div>
@endsection