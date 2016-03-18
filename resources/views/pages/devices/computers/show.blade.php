@extends('layouts.master')

@section('title', $computer->name)

@section('title.header')

@endsection

@section('content')

    <div class="col-md-12">

        {!!
            Decorator::render('navbar', (new \Illuminate\Support\Fluent([
                'id'         => "devices-{$computer->getKey()}",
                'title'      => $computer->name,
                'url'        => route('devices.computers.show', [$computer->getKey()]),
                'menu'       => view('pages.devices.computers._nav-show', compact('computer')),
                'attributes' => [
                    'class' => 'navbar-default',
                ],
            ])))
        !!}

    </div>

    <div class="clearfix"></div>

    <div class="col-md-12">

        <div class="panel panel-default">

            <div class="panel-heading">

                <div class="panel-title">
                    @yield('show.panel.title')
                </div>

            </div>

            <div class="panel-body">

                @yield('show.panel.body')

            </div>

            <div class="panel-footer">

                @yield('show.panel.footer')

            </div>

        </div>

    </div>

@endsection
