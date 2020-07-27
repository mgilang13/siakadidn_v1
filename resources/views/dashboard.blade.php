@extends('layouts.app')

@section('content')

<div class="content">
    <div class="content-header">
        <h2>Dashboard</h2>
    </div>
    <div class="card h-100">
        <div class="card-header">
            <h5>Dashboard</h5>
        </div>
        
        <div class="card-body">
            You are logged in
             
            <!-- Roles  -->
            {{ Auth::user()->roles->first()->pivot->roles_id }}
            {{ Auth::user()->id }}
        </div>
    </div>
</div>
@endsection
