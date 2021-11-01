
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>De Orange Cafe</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="shortcut icon" href="{{ asset('logo') }}/favicon ver1 -- middle white.png">

        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/dist') }}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/dist') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/dist') }}/assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- Styles -->
        <link rel="{{ asset('assets/dist') }}/stylesheet" href="{{ asset('css/app.css') }}">

         <!-- datepicker -->
         <link href="{{ asset('assets/dist') }}/assets/libs/air-datepicker/css/datepicker.min.css" rel="stylesheet" type="text/css" />
         <link rel="stylesheet" href="{{ asset('js') }}/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css">
         <link rel="stylesheet" href="{{ asset('js') }}/bootstrap-datepicker-master/dist/css/bootstrap-datepicker.min.css">
         <style>
             body[data-topbar=colored] #page-topbar {
                background-color: #f57f30;
            }
             .page-title-box {
                background-color: #f57f30;
            }
            body.bg-body-white.bg-pattern{
                background: url('./assets/dist/assets/images/bg-pattern.png') !imporant;
                background-size: cover;
                background-position: center;
                background-color: #a2a6ab;
            }
            body[data-topbar=colored] .dropdown.show .header-item {
                background-color: #f57f30;
            }
         </style>
          <!-- App Css-->

        @livewireStyles

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>
    </head>
    @if (Request::is('/') || Request::is('/login'))
        <body class="bg-body-white bg-pattern">
    @else
        <body data-topbar="colored">
    @endif
            <!-- Page Content -->
            @if (Request::is('resto/*') && !Request::is('resto/pos'))
            <div id="layout-wrapper">
                <livewire:partials.header />

                <livewire:partials.sidebar />
                <div class="main-content">
                        {{ $slot }}
                    <livewire:partials.footer />
                </div>
            </div>
            <livewire:partials.sidebar-right />
            <div class="rightbar-overlay"></div>
            @endif
            @if (Request::is('resto/pos'))
                {{ $slot }}
            @endif


        @if (Request::is('/') || Request::is('/login'))
            {{ $slot }}
        @endif

        @stack('modals')

        @livewireScripts
        <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js" data-turbolinks-eval="false"></script>
        <script src="{{ asset('js/app.js') }}"></script>
          <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/dist') }}/assets/libs/jquery/jquery.min.js"></script>
        <script src="{{ asset('assets/dist') }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('assets/dist') }}/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="{{ asset('assets/dist') }}/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="{{ asset('assets/dist') }}/assets/libs/node-waves/waves.min.js"></script>

        <script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>

        <script src="{{ asset('assets/dist') }}/assets/js/app.js"></script>

  
        <!-- datepicker -->
        <script src="{{ asset('assets/dist') }}/assets/libs/air-datepicker/js/datepicker.min.js"></script>
        <script src="{{ asset('assets/dist') }}/assets/libs/air-datepicker/js/i18n/datepicker.en.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
        <script src="{{ asset('js') }}/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>
        <script src="{{ asset('js') }}/jQuery-Plugin-To-Print-Any-Part-Of-Your-Page-Print/dist/jQuery.print.min.js"></script>
        <script src="{{ asset('js') }}/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        @stack('script')

    </body>
</html>

