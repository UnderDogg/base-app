@extends('layouts.app')

@section('content')

    <div class="panel panel-default">

        <div class="panel-heading">

            <div class="panel-title">
                Viewing Attachment

                <span class="pull-right text-muted">
                    <i class="fa fa-paperclip"></i>
                </span>
            </div>

        </div>

        <div class="panel-body">

            <div class="text-center">

                <h3>{{ $file->name }}</h3>

                <div class="fa-4">
                    {!! $file->icon !!}
                </div>

                <p></p>

                @yield('actions')

            </div>

        </div>

    </div>

@endsection
