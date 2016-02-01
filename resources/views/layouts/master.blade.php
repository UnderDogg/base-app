<!DOCTYPE html>

<html lang="en">

    <head>
        @include('layouts._header')
    </head>

    <body id="app">

        @include('layouts._navigation')

        @include('layouts._flash')

        @section('container')

            <section id="main" class="container main">

                <div class="col-md-12">
                    @yield('extra.top')
                </div>

                <div class="col-lg-12">
                    @section('title.header')

                        @unless(isset($title))
                            <h3>@yield('title')</h3>
                        @endunless

                    @show

                    @yield('content')
                </div>

                <div class="col-md-12">
                    @yield('extra.bottom')
                </div>

            </section>

        @show

        @section('footer')

            @include('layouts._footer')

        @show

    </body>

</html>
