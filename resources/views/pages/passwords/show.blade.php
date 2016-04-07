@extends('layouts.master')

@inject('formbuilder', 'form')

@section('title', $password->title)

@section('content')

    <div class="btn-group pull-right" role="group">
        <a href="{{ route('passwords.edit', [$password->id]) }}" class="btn btn-warning">
            Edit
        </a>
        <a href="{{ route('passwords.destroy', [$password->id]) }}"
           class="btn btn-danger"
           data-post="DELETE"
           data-title="Delete Password?"
           data-message="Are you sure you want to delete this password? It cannot be recovered."
                >
            Delete
        </a>
    </div>

    <div class="clearfix"></div>

    {!! $form !!}

    <script>
        $(function()
        {
            $('.password-show').attr('disabled', 'disabled');
            $('button[type="submit"]').attr('disabled', 'disabled');
            $('#password').val('{{ $password->password }}');
        });
    </script>

@endsection
