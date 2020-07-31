@extends('layouts.app')

@section('content')
    @if(Auth::user()->roles->first()->pivot->roles_id == 3)
        @include('dashboard.muhafidz')
    @elseif(Auth::user()->roles->first()->pivot->roles_id == 4)
        @include('dashboard.murid')
    @else
        <div class="content">
            <h1 class="h1-responsive">Dashboard</h1>
            <div class="card">
                You're welcome
            </div>
        </div>
    @endif
@endsection