@extends('layouts.master')

@section('content')

    <div class="panel panel-default">

        <div class="panel-body">
            <div class="text-center">

                <h1>{{ $file->name }}</h1>

                <div class="fa-6">
                    {!! $file->icon !!}
                </div>

                <p></p>

                @yield('actions')

            </div>

        </div>

    </div>

@endsection
