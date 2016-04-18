@inject('formbuilder', 'form')

@extends('layouts.panel')

@section('title', $password->title)

@section('title.header', ' ')

@section('panel.title')

    Viewing Password

    <div class="btn-group btn-group-xs pull-right" role="group">

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

@endsection

@section('panel.body')

    <div class="clearfix"></div>

    {!! $form !!}

@endsection

@section('scripts')

    <script>
        $(document).on('ready pjax:success', function() {
            $('button[type="submit"]').attr('disabled', 'disabled');
            $('#password').val('{{ $password->password }}').attr('disabled', 'disabled');
        });
    </script>

@endsection
