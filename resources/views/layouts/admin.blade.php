<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>{{ env('APP_TITLE') }}</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  {{-- <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" /> --}}
  <link href="{{ mix('css/app.css') }}" rel="stylesheet" />
</head>

<body class="dark-edition">
  <div class="wrapper">


    <div class="sidebar" data-color="purple" data-background-color="black" data-image="{{ asset('img/sidebar-2.jpg') }}">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
      -->
      <div class="logo"><a href="http://www.creative-tim.com" class="simple-text logo-normal">{{ config('app.name') }}</a></div>

      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item {{ Request::is('dashboard') ? 'active' :  '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
              <i class="material-icons">dashboard</i>
              <p>Панель управления</p>
            </a>
          </li>
          <li class="nav-item {{ Request::is('phonebooks'.'*') ? 'active' :  '' }}">
            <a class="nav-link" href="{{ route('phonebooks.index') }}">
              <i class="material-icons">library_books</i>
              <p>Справочники</p>
            </a>
          </li>
          <li class="nav-item {{ Request::is('customers'.'*') ? 'active' :  '' }}">
            <a class="nav-link" href="{{ route('customers.index') }}">
              <i class="material-icons">person</i>
              <p>Заказчики</p>
            </a>
          </li>
          <li class="nav-item {{ Request::is('users'.'*') ? 'active' :  '' }}">
            <a class="nav-link" href="{{ route('users.index') }}">
              <i class="material-icons">person</i>
              <p>Пользователи</p>
            </a>
          </li>
          {{-- <li class="nav-item ">
            <a class="nav-link" href="./tables.html">
              <i class="material-icons">content_paste</i>
              <p>Table List</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./icons.html">
              <i class="material-icons">bubble_chart</i>
              <p>Icons</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./map.html">
              <i class="material-icons">location_ons</i>
              <p>Maps</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./notifications.html">
              <i class="material-icons">notifications</i>
              <p>Notifications</p>
            </a>
          </li> --}}
        </ul>
      </div>
    </div>


        <div class="main-panel">
          <!-- Navbar -->
          <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top " id="navigation-example">
            <div class="container-fluid">
              <div class="navbar-wrapper">
                <a class="navbar-brand" href="{{ route('dashboard') }}">Dashboard</a>
              </div>
              <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation" data-target="#navigation-example">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
              </button>
              <div class="collapse navbar-collapse justify-content-end">
                {{-- <form class="navbar-form">
                  <div class="input-group no-border">
                    <input type="text" value="" class="form-control" placeholder="Search...">
                    <button type="submit" class="btn btn-default btn-round btn-just-icon">
                      <i class="material-icons">search</i>
                      <div class="ripple-container"></div>
                    </button>
                  </div>
                </form> --}}
                <ul class="navbar-nav">
                  {{-- <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0)">
                      <i class="material-icons">dashboard</i>
                      <p class="d-lg-none d-md-block">
                        Stats
                      </p>
                    </a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link" href="javscript:void(0)" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="material-icons">notifications</i>
                      <span class="notification">5</span>
                      <p class="d-lg-none d-md-block">
                        Some Actions
                      </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                      <a class="dropdown-item" href="javascript:void(0)">Mike John responded to your email</a>
                      <a class="dropdown-item" href="javascript:void(0)">You have 5 new tasks</a>
                      <a class="dropdown-item" href="javascript:void(0)">You're now friend with Andrew</a>
                      <a class="dropdown-item" href="javascript:void(0)">Another Notification</a>
                      <a class="dropdown-item" href="javascript:void(0)">Another One</a>
                    </div>
                  </li> --}}


                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                      <span>{{Auth::user()->name}} </span>
                      <i class="material-icons">logout</i>
                      <p class="d-lg-none d-md-block">Logout</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
          <!-- End Navbar -->
          <div class="content">
            
            <div id="app">
              @yield('content')
            </div>
            
            <footer class="footer">
              <div class="container-fluid">
                <nav class="float-left">
                  <ul>
                    {{-- <li>
                      <a href="https://www.creative-tim.com">
                        Creative Tim
                      </a>
                    </li>
                    <li>
                      <a href="https://creative-tim.com/presentation">
                        About Us
                      </a>
                    </li>
                    <li>
                      <a href="http://blog.creative-tim.com">
                        Blog
                      </a>
                    </li>
                    <li>
                      <a href="https://www.creative-tim.com/license">
                        Licenses
                      </a>
                    </li> --}}
                  </ul>
                </nav>
                <div class="copyright float-right" id="date">
                  2020, made with <i class="material-icons">favorite</i> by
                  <a href="https://github.com/maksakoviliya/phonebook.git" target="_blank">Maksak_il</a>
                </div>
              </div>
            </footer>
          </div>
        </div>
        <!--   Core JS Files   -->
        <script src="{{ mix('/js/scripts.js') }}"></script>
        <script src="{{ mix('/js/app.js') }}"></script>
        {{-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> --}}

      </body>

      </html>