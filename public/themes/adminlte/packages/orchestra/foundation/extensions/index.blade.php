@extends('orchestra/foundation::layouts.main')

@section('content')
    <div class="row">
        <div class="twelve columns">
            <div class="white rounded box">
                @include('orchestra/foundation::extensions._table')
            </div>
        </div>
    </div>
@stop
