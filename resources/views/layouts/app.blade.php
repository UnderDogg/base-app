<!DOCTYPE html>

<html lang="en">

    <head>

        <title>@yield('title') | {{ env('APP_NAME', 'Helpdesk') }} </title>

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="#2C3E50">
        <meta name="description" content="Helpdesk">
        <meta name="author" content="Steve Bauman">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ url(elixir('css/all.css')) }}">

        <!-- Scripts -->
        <script type="text/javascript" src="{{ url(elixir('js/all.js')) }}"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body id="app">

        @section('nav')

            <!-- Navigation -->
            @include('layouts._nav')

        @show

        @section('flash')

            <!-- Flash Notifications -->
            @if(session()->has('flash_message'))
                <script type="text/javascript">
                    swal({
                        title: "{!! session('flash_message.title') !!}",
                        text: "{!! session('flash_message.message') !!}",
                        type: "{!!session('flash_message.level') !!}",
                        animation:false,
                        @if(session('flash_message.timer')) timer: "{!! session('flash_message.timer') !!}" @endif
                    });
                </script>
            @endif

        @show

        @section('container')

            <div id="main" class="container main">

                <div class="col-md-12">
                    @yield('extra.top')
                </div>

                <div class="col-lg-12">
                    @section('title.header')

                        @unless(isset($title))
                            <h3>@yield('title')</h3>

                            <hr>
                        @endunless

                    @show

                    @yield('content')
                </div>

                <div class="col-md-12">
                    @yield('extra.bottom')
                </div>

            </div>

        @show

        @section('footer')

            <footer>

                <div class="container">
                    <hr>
                </div>

            </footer>

        @show

        @yield('scripts')

    </body>

</html>
