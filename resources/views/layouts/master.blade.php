<!DOCTYPE html>

<html lang="en">
    <head>
        @include('layouts._header')
    </head>

    <body>

        @include('layouts._navigation')

        @include('layouts._flash')

        <section class="container main">

            <div class="col-lg-12">
                @section('title.header')
                    @unless(isset($title))
                        <h3>@yield('title')</h3>
                    @endunless
                @show

                @yield('content')
            </div>

        </section>

        @include('layouts._footer')

    </body>
</html>
