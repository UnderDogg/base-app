@extends('layouts.master')

@inject('formbuilder', 'form')

@section('title', $password->title)

@section('content')

    {!! $form !!}

    <script>
        $(function()
        {
            $('.password-show').attr('disabled', 'disabled');
            $('button[type="submit"]').attr('disabled', 'disabled');
            $('#password').val('{{ $password->password }}');
        });
    </script>

@stop
