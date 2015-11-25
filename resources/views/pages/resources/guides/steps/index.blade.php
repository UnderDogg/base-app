@extends('layouts.master')

@section('title', 'All Guides')

@section('content')

    {!! $steps !!}

    <script>
        var changePosition = function () {};

        $(document).ready(function()
        {
            var $sortableTable = $('.sortable');

            if ($sortableTable.length > 0) {
                $sortableTable.sortable({
                    handle: '.sortable-handle',
                    axis: 'y',
                    update: function(event, ui) {
                        var entityName = $(this).data('entityname');

                        var $sorted = ui.item;
                        var $previous = $sorted.prev();
                        var $next = $sorted.next();

                        var $row = $(this).children('tr');

                        $row.each(function() {
                            var position = $(this).index() + 1;

                            $(this).find('.position').html(position);
                        });

                        if ($previous.length > 0) {
                            changePosition({
                                parentId: $sorted.data('parentid'),
                                type: 'moveAfter',
                                entityName: entityName,
                                id: $sorted.data('itemid'),
                                positionEntityId: $previous.data('itemid')
                            });
                        } else if ($next.length > 0) {
                            changePosition({
                                parentId: $sorted.data('parentid'),
                                type: 'moveBefore',
                                entityName: entityName,
                                id: $sorted.data('itemid'),
                                positionEntityId: $next.data('itemid')
                            });
                        } else {
                            swal('Whoops...', 'Something went wrong!');
                        }
                    },
                    cursor: "move"
                });
            }
        });
    </script>

@stop
