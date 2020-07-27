<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Akademik IDN') }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/main.css?v=11')}}">
    <link rel="stylesheet" href="{{ asset('css/mdb.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
</head>
<body>
    <div class="d-flex" id="wrapper">
        <div class="sidebar">
            <img class="img-fluid navbar-brand px-4 px-md-3" src="{{ asset('images/logo_idn.svg') }}" alt="" srcset=""/>
            {!! $APPS_MENU !!}
        </div>
        <div id="page-content-wrapper">
                <nav class="navbar fixed-top shadow p-0 justify-content-space-around justify-content-lg-end">
                
                <a id="sidebarCollapse" class="d-block d-lg-none p-3">
                    <i data-feather="menu" style="color:#349ce4"></i>
    </a>
                    <div class="col d-flex align-items-center justify-content-end">
                        <b class="mr-3">{{ Auth::user()->name }}</b>
                        
                        <img class="mr-3 img-responsive img-rounded img-fluid" src="{{ Auth::user()->image_small ? asset('storage/'.env('UPLOAD_USER').'/'.Auth::user()->id.'/'.Auth::user()->image_small) : asset('images/ic_profile.svg') }}" alt="profil">
                        <div class="dropdown">
                            <a type="button" id="dropdown" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="true" aria-haspopup="true"></a>
                            <div class="dropdown-menu dropdown-menu-right mt-3" aria-labelledby="dropdown">
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    {{ __('Ubah Profil') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                            </div>
                        </div>
                    </div>
                </nav>
            
                <div id="overlay" style="float:none; line-height:1.5; font-size:inherit">
                    @yield('content')
                </div>
        </div>
    </div>
    
    <script src="{{ asset('theme/js/feather.min.js') }}"></script>

    <script src="{{ asset('theme/js/popper.min.js') }}"></script>
    <script src="{{ asset('theme/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/js/axios.min.js') }}"></script>

    <script>
	    $(document).ready(function(){
            sidebarCollapseStatus = $('#sidebarCollapse').css('display');
           
           if(sidebarCollapseStatus === "block") {
               $('.sidebar').addClass('hide-300');
               $('.navbar').addClass('hide-0');
               $('.content').addClass('hide-0');
           }

			$('#sidebarCollapse').on('click',function(){
				$('.sidebar').toggleClass('hide-300');
                $('.navbar').toggleClass('hide-0');
                $('.content').toggleClass('hide-0');
                $('#overlay').toggleClass('close');
			});
           
		});  
	</script>
    <script>
        //axios
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        feather.replace()
    </script>
    @yield('js')
    <script src="{{ asset('js/mdb.min.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    
</body>
</html>
