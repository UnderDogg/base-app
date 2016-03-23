@extends('layouts.master')

@section('title', 'Create Device')

@section('content')

    {!! $form !!}

    <script type="text/javascript">
        $(function()
        {
            var fieldOs = $('#os');
            var fieldType = $('#type');
            var fieldModel = $('#model');
            var fieldDescription = $('#description');

            var fieldActiveDirectory = $('#active_directory');

            fieldActiveDirectory.on('switchChange.bootstrapSwitch', function (event, state)
            {
               if (state) {
                   fieldOs.prop('disabled', true);
                   fieldType.prop('disabled', true);
                   fieldModel.prop('disabled', true);
                   fieldDescription.prop('disabled', true);
               } else {
                   fieldOs.prop('disabled', false);
                   fieldType.prop('disabled', false);
                   fieldModel.prop('disabled', false);
                   fieldDescription.prop('disabled', false);
               }
            });
        });
    </script>

@endsection
