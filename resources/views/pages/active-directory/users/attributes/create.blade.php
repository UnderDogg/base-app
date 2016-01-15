@extends('layouts.master')

@section('title')

    Creating Attribute on {{ $user->getName() }}

@endsection

@section('content')

    {!! $form !!}

@endsection
