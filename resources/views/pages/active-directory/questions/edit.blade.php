@extends('layouts.master')

@section('title', 'Edit Security Question')

@section('content')

    {!! $form !!}

    <hr>

    <div class="col-md-12 text-center">

        <a
                class="btn btn-danger"
                data-post="DELETE"
                data-title="Delete Question?"
                data-message="Are you sure you want to delete this question? Users using this question will need to re-add another question after deletion."
                href="{{ route('active-directory.questions.destroy', [$question->getKey()]) }}">
            Delete

            <i class="fa fa-times"></i>
        </a>

    </div>

@stop
