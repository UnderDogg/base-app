@extends('layouts.master')

@section('title', $computer->name)

@section('title.header')

    <a href="{{ route('computers.index') }}" class="btn btn-primary">
        <i class="fa fa-caret-left"></i>
        Back To Computers
    </a>

    <hr>

@endsection

@section('content')

    {!!
        Decorator::render('navbar', (new \Illuminate\Support\Fluent([
            'id'         => "computers-{$computer->id}",
            'title'      => $computer->name,
            'url'        => route('computers.show', [$computer->id]),
            'menu'       => view('pages.computers._nav-show', compact('computer')),
            'attributes' => [
                'class' => 'navbar-default',
            ],
        ])))
    !!}

    <div class="clearfix"></div>

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

@endsection
