@extends('pages.profile.show')

@section('show.panel.title')

    Change Your Password

    <span class="pull-right text-muted">
        <i class="fa fa-lock"></i>
    </span>

@endsection

@section('show.panel.body')

    @if(auth()->user()->from_ad)

        <div class="alert alert-warning text-center">

            <p>
                Your account is from Active Directory.
                <br>
                Use your computer to change your password.
            </p>

        </div>

    @else

        <div class="col-md-12">
            {!! $form !!}
        </div>

    @endif

@endsection
