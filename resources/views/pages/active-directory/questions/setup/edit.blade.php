@extends('layouts.master')

@section('title', 'Edit Security Question')

@section('content')

    {!! $form !!}

    <script>
        $(function()
        {
            $('#answer').val('{{ $answer }}');
        });
    </script>

@endsection
