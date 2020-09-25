@extends('layouts.app')

@section('content')
    @if(Auth::user()->roles->first()->pivot->roles_id == 3 and $teacher_subject == null)
        @include('dashboard.muhafidz')
    @elseif(Auth::user()->roles->first()->pivot->roles_id == 4)
        @include('dashboard.murid')
    @elseif(Auth::user()->id == 1)
        @include('dashboard.admin')
    @elseif(Auth::user()->roles->first()->pivot->roles_id == 8)
        @include('dashboard.foundationhead')
    @elseif(Auth::user()->roles->first()->pivot->roles_id == 3 and $teacher_subject != null)
        <div class="content">
            <h1 class="h1-responsive">Dashboard</h1>
            <div class="card">
                You're welcome
            </div>
        </div>
    @endif
@endsection