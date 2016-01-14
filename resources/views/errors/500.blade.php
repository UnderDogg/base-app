@extends('layouts.error')

@section('title', '500 - Internal Server Error.')

@section('content')
    <h1>{{ $exception->getMessage() }}</h1>
@endsection
