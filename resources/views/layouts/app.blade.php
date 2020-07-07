<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Akademik IDN') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>
    <div class="d-flex" id="wrapper">
        <div class="sidebar">
            <img class="img-fluid navbar-brand px-4 px-md-3" src="{{ asset('images/logo_idn.svg') }}" alt="" srcset=""/>
            {!! $APPS_MENU !!}
        </div>
        <div id="page-content-wrapper">
            <nav class="navbar shadow-sm p-0 justify-content-space-around justify-content-lg-end">
            <a id="sidebarCollapse" class="d-block d-lg-none p-3">
                <i data-feather="menu" style="color:#349ce4"></i>
</a>
                <div class="col-5 d-flex align-items-center justify-content-end">
                    <b class="mr-3">{{ Auth::user()->name }}</b>
                    <img class="mr-3 img-fluid" src="{{ Auth::user()->image ? asset('storage/'.Auth::user()->image) : asset('images/ic_profile.svg') }}" alt="profil">
                    <div class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle"></a>
                        <div class="dropdown-menu dropdown-menu-right mt-3">
                            <a class="dropdown-item" href="{{ route('profile') }}">
                                {{ __('Ubah Profil') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                        </div>
                    </div>
                </div>
            </nav>
            @yield('content')  
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
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
			});
           
		});  
	</script>
    <script>
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    </script>
    @yield('js')
</body>
</html>
