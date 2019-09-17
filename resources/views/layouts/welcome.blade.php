<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Running Management Website</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link href="{{ asset('fontawesome-free/css/all.css') }}" rel="stylesheet">
        <script src="https://unpkg.com/scrollreveal"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHTB6sd-BWaA9dvXutGs2nJ1q8el4F-VI&libraries=places" ></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow fixed-top" >
          <div class="container">
            <a class="navbar-brand" href="/"> <img src="{{ asset('img/runlogo.png') }}" width="50px" >GoRun</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto">
                  <!-- Authentication Links -->
                  <li class="nav-item "><a  class="nav-link " href="/" >EventList</a><li>
                  

                  @guest
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                      </li>
                      @if (Route::has('register'))
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                          </li>
                      @endif
                  @else
                      <li class="nav-item dropdown">
                          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                              {{ Auth::user()->name }} <span class="caret"></span>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                              @if(Auth::user()->hasAnyRole(['user']))
                                <a class="dropdown-item" href="/userprofile"><i class="fas fa-user-alt"></i> Profile</a>
                            @endif
                            @if(Auth::user()->hasAnyRole(['admin']))
                              <a class="dropdown-item" href="/runner/admin/1"><i class="fas fa-user-alt"></i> Profile</a>
                            @endif
                              <a class="dropdown-item" href="{{ route('logout') }}"
                                 onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
                                  <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                              </a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                  @csrf
                              </form>
                          </div>
                      </li>

                  @endguest
              </ul>
            </div>
          </div>
        </nav>

          @yield('website_content')

          <footer class="text-center up-arrow">
          <br><br>
            <p>Copyright © 2019 - NoProblem Group</p>
          </footer>

    </body>
</html>
