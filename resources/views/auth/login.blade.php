@extends('layouts.login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm col-md-8 col-lg-5 mt-5">
            <img class="mx-auto d-block" src="{{ asset('images/main_logo.svg') }}" alt="">
            <p class="main-title mb-sm-3">SiAKAD SMP SMK IDN</p>
            <p class="sub-title">Sistem Informasi Akademik Siswa SMP SMK IDN Boarding School</p>
            <div class="card mt-2">
                <div class="card-body">
                @include('layouts.notification')
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col input-with-icon d-flex">
                                <img src="{{ asset('images/ic_user.svg') }}" class="align-self-center pl-2">
                                <input type="text" class="form-control" name="username" placeholder="Username">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col input-with-icon d-flex">
                                <img src="{{asset('images/ic_lock.svg') }}" class="align-self-center pl-2">
                                <input type="password" class="form-control" name="password" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group row mb-0 mt-5">
                            <div class="col">
                                <button type="submit" class="btn btn-primary col btn-lg">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
