@extends('layouts.panel')

@section('title', 'Edit Password')

@section('title.header', ' ')

@section('panel.title')

    Edit Password

    <span class="pull-right text-muted">
        <i class="fa fa-lock"></i>
    </span>

@endsection

@section('panel.body')

    {!! $form !!}

@endsection

@section('scripts')

    <script>
        $('#password').val('{{ $password->password }}').attr('disabled', false);
    </script>

@endsection
