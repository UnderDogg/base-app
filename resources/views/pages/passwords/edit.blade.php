@extends('layouts.master')

@section('title', 'Edit Password')

@section('content')

    {!! $form !!}

    <script>
        $(function()
        {
            $('#password').val('{{ $password->password }}');
        });
    </script>

@endsection
