@extends('layouts.master')

@section('extra.top')
    <a class="btn btn-primary" href="{{ route('resources.guides.show', [$guide->slug]) }}">
        <i class="fa fa-chevron-left"></i>
        Back to Guide
    </a>
@endsection

@section('title.header')
    <h2>
        @section('title') All Steps @show

        <span class="text-muted">for {{ $guide->title }}</span>
    </h2>
@endsection

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $steps !!}

    <script type="text/javascript">
        var changePosition = function (url, request) {
            $.ajax({
                'url': url,
                'type': 'POST',
                'data': request
            });
        };

        var updatePosition = function(event, ui) {
            var $current = ui.item;

            var $steps = $(this).children('tr');

            $steps.each(function() {
                var position = $(this).index() + 1;

                $(this).find('.position').html(position);
            });

            var step = $current.find('.sortable-handle').data('id');

            var url = 'steps/' + step + '/move';

            changePosition(url, {
                _token: $('meta[name="csrf-token"]').attr('content'),
                position: $current.index() + 1,
                method: 'POST'
            });
        };

        $(document).ready(function()
        {
            var $sortableTable = $('.sortable');

            if ($sortableTable.length > 0) {
                $sortableTable.sortable({
                    handle: '.sortable-handle',
                    axis: 'y',
                    update: updatePosition,
                    cursor: "move"
                });
            }
        });
    </script>

@endsection
