@extends('layouts.master')

@section('title.header')

    <h3>@section('title') Your Security Questions @show</h3>

    @if (!$finished)
        <p>
            <a class="btn btn-primary" href="{{ route('security-questions.setup.step') }}"><i class="fa fa-cogs"></i> Finish Setup</a>
        </p>
    @endif

@endsection

@section('content')

    {!! $questions !!}

@endsection
