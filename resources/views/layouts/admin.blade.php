<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title or 'Admin' }} - BaseProject </title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>
        <link href="{{ admin_asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ admin_asset('css/font-awesome.css') }}" rel="stylesheet"/>
        <link href="{{ admin_asset('js/morris/morris-0.4.3.min.css') }}" rel="stylesheet"/>
        <link href="{{ admin_asset('js/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet" />
        <link href="{{ admin_asset('css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" >
        <link href="{{ admin_asset('css/summernote.css') }}" rel="stylesheet">
        <link href="{{ admin_asset('css/cropper.css') }}" rel="stylesheet">
        <link href="{{ admin_asset('css/custom-styles.css') }}" rel="stylesheet"/>
    </head>
    <body>

        <div id="wrapper">
            <nav class="navbar navbar-default top-navbar" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ route('admin.home') }}"> BaseProject </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"
                           aria-expanded="false">
                            <i class="fa fa-user fa-fw"></i> <i
                                class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>

            @include('admin.partials.menu')

            <div id="page-wrapper">
                <div id="page-inner">

                    @yield('content')

                    <footer>
                        <p>Desarrollado por: <a href="http://www.thatzad.com/" target="_blank">Thatzad</a></p>
                    </footer>
                </div>
            </div>
        </div>

        <script src="{{ admin_asset('js/jquery-1.10.2.js') }}"></script>
        <script src="{{ admin_asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ admin_asset('js/jquery.metisMenu.js') }}"></script>
        <script src="{{ admin_asset('js/morris/raphael-2.1.0.min.js') }}"></script>
        <script src="{{ admin_asset('js/morris/morris.js') }}"></script>
        <script src="{{ admin_asset('js/dataTables/jquery.dataTables.js') }}"></script>
        <script src="{{ admin_asset('js/dataTables/dataTables.bootstrap.js') }}"></script>
        <script src="{{ admin_asset('js/summernote.min.js') }}"></script>
        <script src="{{ admin_asset('js/cropper.js') }}"></script>
        <script src="{{ admin_asset('js/moment.js') }}"></script>
        <script src="{{ admin_asset('js/bootstrap-datetimepicker.min.js') }}"></script>
        <script src="{{ admin_asset('js/jquery-sortable.js') }}"></script>

        <script src="{{ admin_asset('js/custom-scripts.js') }}"></script>
        @yield('scripts')

    </body>
</html>
