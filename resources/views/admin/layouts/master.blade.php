<!DOCTYPE html>

<html lang="en">

<head>
    @include('admin.layouts._header')
</head>

<body id="app">

@include('admin.layouts._navigation')

@include('admin.layouts._flash')

@section('container')

    <section id="main" class="container main">

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

    </section>

@show

@section('footer')

    @include('admin.layouts._footer')

@show

</body>

</html>
