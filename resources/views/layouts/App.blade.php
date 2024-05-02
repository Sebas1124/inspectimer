<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    <link href="{{ asset('css/App.css') }}" rel="stylesheet">
    
    <!-- FavIcon -->
    <link rel="icon" href="{{ asset('imgs/logo.png') }}">

    <title>SIS- IT</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>

    <style>
        a{
            text-decoration: none;
        }
    </style>

    <div id="app">

        <header class="header p-2" id="header">
            <nav class="navbar container">
               <a href="{{ route('index') }}" id="HomeAppName" class="brand">SIS-IT</a>
               <div class="burger" id="burger">
                  <span class="burger-line"></span>
                  <span class="burger-line"></span>
                  <span class="burger-line"></span>
               </div>
               <div class="menu" id="menu">
                  <ul class="menu-inner">
                     <li class="menu-item">
                        <a href="{{ route('index') }}" class="menu-link">Inicio</a>
                    </li>
                    @if ( Auth::check() )
                        
                        <li class="menu-item">
                            <a href="{{ route('home') }}" class="menu-link">Dashboard</a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('logout') }}" class="menu-link">Cerrar sesión</a>
                        </li>

                    @else

                        <li class="menu-item">
                            <a href="{{ route('login') }}" class="menu-link">Login</a>
                        </li>
                            <li class="menu-item">
                            <a href="{{ route('register') }}" class="menu-link">Registro</a>
                        </li>
                        
                    @endif
                  </ul>
               </div>
               <button class="switch" id="switch">
                  <ion-icon name="sunny-outline" id="SunnyIcon" class="switch-light bx bx-sun"></ion-icon>
                  <ion-icon name="moon-outline" id="MoonIcon" class="switch-dark bx bx-moon"></ion-icon>
               </button>
            </nav>
        </header>

        <main class="py-4 d-flex justify-content-center align-center MainContent">
            @yield('content')
        </main>
    </div>
    
</body>

    <script src="{{ asset('App.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-xgFJLu9DcO0T5wytzDYPGJsh6vT/mF3BwVQQq48u8ieWtoA6Ot4DO/K4FS0bd2ij" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</html>
