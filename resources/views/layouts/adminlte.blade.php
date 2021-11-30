<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
        <!-- jQuery -->
        <script src="{{ asset('AdminLTE-3.1.0/plugins/jquery/jquery.min.js') }}"></script>

        <script type="application/javascript">
            $(function(){
                @php
                    $url = explode('/', url()->current());
                    $base_url = $url[0].'//'.$url[2].'/'.($url[3] ?? '').(isset($url[4]) ? '/'.$url[4] : '');
                @endphp
                var url = '{{ $base_url }}';
                // for sidebar menu but not for treeview submenu
                $('ul.nav-sidebar li a').filter(function() {
                    if(url == $(this).attr('href')){
                        $(this).addClass('active')
                    }
                })
                $('ul.nav-treeview li a').filter(function() {
                    if(url == $(this).attr('href')){
                        $(this).parent().parent().parent().addClass('menu-open')
                    }
                })
            })
        </script>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        {{-- <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/fontawesome-free/css/all.min.css') }}"> --}}
        <link rel="stylesheet" href="{{ asset('web fonts/fontawesome-pro-5.12.0-web/css/all.min.css') }}">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/dist/css/adminlte.min.css') }}">

        <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/sweetalert2/sweetalert2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        {{-- <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/chart.js/Chart.min.css') }}"> --}}

        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <style>
            .loader {
                height: 100%;
                position: fixed;
                width: 100%;
                z-index: 9999999;
                background-color: #ffffff5c;
                display:flex;
                align-items:center;
                justify-content:center;
            }
            .loader svg {
                -webkit-transform: translate(0, -50%);
                -ms-transform: translate(0, -50%);
                -o-transform: translate(0, -50%);
                transform: translate(0, -50%);
            }
        </style>
        @yield('style')
    </head>
    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        @include('partials.loader')
        <div class="wrapper">
            <!-- Preloader -->
            {{-- <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__wobble" src="{{ asset('images/logo.png') }}" alt="Logo" height="60" width="60">
            </div> --}}
            {{-- @auth --}}
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-dark">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                    {{-- <li class="nav-item d-none d-sm-inline-block">
                        <a href="index3.html" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="#" class="nav-link">Contact</a>
                    </li> --}}
                </ul>
                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            Account
                            <i class="fas fa-caret-down"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            {{-- @can('users.account_settings') --}}
                            <a href="{{ route('users.account_settings', Auth::user()->id) }}" class="dropdown-item">
                                <i class="fas fa-user-cog mr-2"></i> Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            {{-- @endcan --}}
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item">
                                <i class="fas fa-sign-out mr-2"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endauth
                </ul>
            </nav>
            {{-- @endauth --}}
            @include('partials.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
                <div id="modalAjax"></div>
                <div id="modalOpenData"></div>
                <div id="tableActionModal"></div>
                @auth
                    @include('partials.modal_action.delete')
                    @include('partials.modal_action.restore')
                @endauth
            </div>
            <!-- /.content-wrapper -->
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
            <!-- Main Footer -->
            <footer class="main-footer">
                <strong>Copyright &copy; {{ date('Y') }} <a href="/">{{ config('app.name') }}</a>.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                    <b>Version</b> 1.2.0
                </div>
            </footer>
        </div>
        <!-- ./wrapper -->

        <div class="d-none" id="oldInput">
            @forelse (old() as $input => $value)
                @if (is_array($value))
                    @foreach ($value as $arrayValue)
                        <input type="text" name="old_{{ $input }}[]" value="{{ $arrayValue }}">
                    @endforeach
                @else
                    <input type="text" name="old_{{ $input }}" value="{{ $value }}" data-error="{{ $errors->has($input) ? ' is-invalid' : '' }}" data-error-message="{{ $errors->first($input) }}">
                @endif
            @empty
            @endforelse
        </div>
        @if (count($errors) > 0)
            <div style="position: absolute; top: 0; right: 0; z-index: 1111">
                <div class="toast" data-autohide="false" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        {{-- <img src="..." class="rounded mr-2" alt="..."> --}}
                        <strong class="mr-auto text-danger">Whoops!</strong>
                        {{-- <small class="text-muted">11 mins ago</small> --}}
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                    </div>
                    <div class="toast-body">
                        {{-- There were some problems with your input. --}}
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @include('partials.scripts')
        @include('partials.modal_ajax_error')
        @yield('script')
    </body>
</html>