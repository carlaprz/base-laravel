<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title or 'Admin' }} - BaseProject </title>

        <link href='http://fonts.googleapis.com/css?family=Open+Sans'
              rel='stylesheet' type='text/css'/>

        <link href="{{ admin_asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ admin_asset('css/font-awesome.css') }}" rel="stylesheet"/>
        <link href="{{ admin_asset('js/morris/morris-0.4.3.min.css') }}"
              rel="stylesheet"/>
        <link href="{{ admin_asset('js/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet" />
        <link href="{{ admin_asset('css/custom-styles.css') }}" rel="stylesheet"/>

        <link href="{{ admin_asset('css/styles.css') }}" rel="stylesheet">
    </head>
    <body class="login">

        <div id="wrapper">
            <nav class="navbar navbar-default top-navbar" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ route('admin.home') }}"> BaseProject </a>
                </div>
            </nav>
            @yield('content')

            <footer>
                <p>Desarrollado por: <a href="http://www.thatzad.com/" target="_blank">Thatzad</a></p>
            </footer>
        </div>

        <script src="{{ admin_asset('js/jquery-1.10.2.js') }}"></script>
        <script src="{{ admin_asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ admin_asset('js/jquery.metisMenu.js') }}"></script>
        <script src="{{ admin_asset('js/morris/raphael-2.1.0.min.js') }}"></script>
        <script src="{{ admin_asset('js/morris/morris.js') }}"></script>
        <script src="{{ admin_asset('js/dataTables/jquery.dataTables.js') }}"></script>
        <script src="{{ admin_asset('js/dataTables/dataTables.bootstrap.js') }}"></script>
        <script src="{{ admin_asset('js/custom-scripts.js') }}"></script>

        @yield('scripts')

    </body>
</html>
