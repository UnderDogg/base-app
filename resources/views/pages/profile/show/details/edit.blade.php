@extends('pages.profile.show')

@section('show.panel.title')

    Edit Profile Details

@endsection

@section('show.panel.body')

    @if($user->isFromAd())
        <script>
            $(function () {
                $('button[type="submit"]')
                        .attr('disabled', 'disabled')
                        .attr('class', 'hidden');
            });
        </script>

        <div class="alert alert-warning">
            <p>Your account is synchronized with Active Directory.</p>

            <p>Please contact your IT Department to modify your account details.</p>
        </div>
    @endif

    <div class="col-md-12">
        {!! $form !!}
    </div>

@endsection
