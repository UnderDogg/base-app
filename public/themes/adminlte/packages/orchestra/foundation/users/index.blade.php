@extends('orchestra/foundation::layouts.main')

@set_meta('header::add-button', true)

@section('content')
    <div class="row">
        <div class="twelve columns">
            @include('orchestra/foundation::users._search')
            <div class="white rounded box">
                {!! $table !!}
            </div>
        </div>
    </div>
@stop
