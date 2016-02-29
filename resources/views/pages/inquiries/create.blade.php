@extends('layouts.master')

@section('title', 'Create a Request')

@section('content')

    {!! $form !!}

    <script>
        $label = $('label[for="manager"]');
        $manager = $('#manager');
        $category = $('#category');

        $category.on('change', function () {
            var value = this.value;

            if (value) {
                $.get("categories/"+value+"/manager-required", function (data) {
                    if (data === 'true') {
                        showManager();
                    } else {
                        hideManager();
                    }
                });
            }

            hideManager();
        });

        $category.trigger('change');

        function hideManager()
        {
            $label.hide();
            $manager.hide();
        }

        function showManager()
        {
            $label.show();
            $manager.show();
        }
    </script>

@endsection
