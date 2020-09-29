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
    <script src="{{ mix('/js/app.js') }}" ></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('/css/main-mix.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link href="{{ asset('/css/main-mix-print.css') }}" rel="stylesheet" media="print">
    <link rel="stylesheet" href="{{ asset('css/mdb.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.css') }}" />
    <script src="{{ asset('js/bootstrap-select.js') }}"></script>
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
                        <div class="dropdown">
                            <a type="button" id="drop-notification" class="mr-5" data-toggle="dropdown" class="dropdown-toggle">
                                <i width="18" data-feather="bell" color="indigo darken-4" style="position:relative"></i>
                                @if(Auth::user()->roles->first()->pivot->roles_id == 3)
                                    @if($notifMuhafidz != null)
                                    <span style="height:6px; width:6px; border-radius: 3px; position:absolute" class="red mr-2"></span>
                                    @endif
                                @endif
                            </a>
                            <div class="dropdown-menu mt-3 amber lighten-1" aria-labelledby="drop-notification">
                                <div class="dropdown-item bg-white">
                                @if(Auth::user()->roles->first()->pivot->roles_id == 3)
                                    <div class="toast amber lighten-3" data-autohide="false">
                                        <div class="toast-header">
                                        <strong class="mr-auto">Notifikasi Muhafidz </strong>
                                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                                        </div>
                                        <div class="toast-body d-flex flex-wrap">
                                        @if($notifMuhafidz != null)
                                        <h6 class="h6-responsive">Belum input data tahfidz pada: </h6>
                                            <ul>
                                                @foreach($notifMuhafidz as $nm)
                                                    <li><small class="font-weight-bold">{{ $nm->tanggal_setor }}</small></li>
                                                @endforeach
                                            </ul>
                                        @else
                                        <h6 class="h6-responsive">Data tahfidz terisi semua</h6>
                                        @endif
                                        </div>
                                    </div>
                                @else
                                    <span class="align-middle">Tidak ada notifikasi</span>
                                @endif
                                </div>
                            </div>
                        </div>
                        <b class="mr-3">{{ Auth::user()->name }}</b>
                        
                        <img class="mr-3 img-responsive img-rounded img-fluid img-profile" src="{{ Auth::user()->image_small ? asset('storage/'.Auth::user()->image_small) : asset('images/ic_profile.svg') }}" alt="profil">
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

    <script>
        let dropdown = $('.sidebar').children();
        let dropdownChild = $('.sidebar-child').children();
        let i;

        for(i = 0; i < dropdownChild.length; i++) {
            if(dropdownChild[i].classList.contains('active')) {
               dropdownChildContent = dropdownChild[i].parentElement;
               if(dropdownChildContent.style.display === "block") {
                   dropdownChildContent.style.display = "none";
               } else {
                   dropdownChildContent.style.display = "block";
               }
            }
        }
        for (i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function() {
                var dropdownContent = this.nextElementSibling;
                
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });
        }
    </script>
    <script src="{{ asset('theme/js/feather.min.js') }}"></script>

    <script src="{{ asset('theme/js/popper.min.js') }}"></script>
    <script src="{{ asset('theme/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/js/axios.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    
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
        $('.toast').toast('show');  
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
