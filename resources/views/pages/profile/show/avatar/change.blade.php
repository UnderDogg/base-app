@extends('pages.profile.show')

@section('show.panel.title')

    Change Avatar

    <span class="pull-right text-muted">
        <i class="fa fa-user"></i>
    </span>

@endsection

@section('show.panel.body')

    <div class="col-md-12">
        {!! $form !!}
    </div>

    <script type="text/javascript">

        var $generate = $('#generate');
        var $image = $('#image');

        $generate.change(function () {
            if (this.checked) {
                $image.attr('disabled', true);
            } else {
                $image.attr('disabled', false);
            }
        });

    </script>

@endsection
