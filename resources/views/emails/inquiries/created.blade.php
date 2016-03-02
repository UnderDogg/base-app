@extends('emails.layouts.master')

@section('content')

    <p>{{ $user->name }}, the following request needs your approval:</p>

    <p>
        {{ $inquiry->title }}
    </p>

@endsection
