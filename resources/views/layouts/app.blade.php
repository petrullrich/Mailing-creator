<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="_token" content="{{csrf_token()}}" />
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>@yield('title') - Mailing creator</title>
</head>

<body class="bg-white">
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('index') }}">Mailing creator</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse ms-5" id="navbarNavAltMarkup">
                <div class="navbar-nav align-items-center">
                    <a class="nav-link" href="{{ route('index') }}">Home</a>
                    <a class="nav-link" href="{{ route("mailing.index") }}">Mailing</a>
                    <a class="nav-link" href="{{ route('manufacturer.index') }}">Výrobci</a>
                    <a class="nav-link" href="">Šablony</a>
                </div>
                <div class=" navbar-nav ms-auto">
                    @guest
                        <a class="btn btn-outline-primary me-3" href="{{ route('login') }}">Login</a>
                        <a class="btn btn-primary" href="{{ route('register') }}">Register</a>
                    @else
                        <div class="d-flex flex-row align-items-center">
                            <div class="me-3 fs-5">{{ Auth::user()->name }}</div>
                            {{-- <a class="nav-link btn btn-primary" href="{{ route('logout') }}">Logout</a> --}}
                            <form action="{{ route('logout') }}" id="logout-form" method="POST">
                              @csrf
                              <button class="btn btn-primary" href="{{ route('logout') }}">Logout</button>
                            </form>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
    <div class="container mx-auto px-4 py-5">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
