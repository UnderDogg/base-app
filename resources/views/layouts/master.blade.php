<!DOCTYPE html>

<html lang="en">

    <head>
        @include('layouts._header')
    </head>

    <body id="app">

        @section('nav')

            <!-- Navigation -->
            @include('layouts._nav')

        @show

        @section('flash')

            <!-- Flash Notifications -->
            @include('layouts._flash')

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

            @include('layouts._footer')

        @show

        @yield('scripts')

    </body>

</html>
