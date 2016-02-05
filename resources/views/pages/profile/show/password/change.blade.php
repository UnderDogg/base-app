@extends('pages.profile.show')

@section('show.panel.title')
    Change Your Password
@endsection

@section('show.panel.body')

    @if(auth()->user()->from_ad)
        <div class="panel panel-warning">
            <div class="panel-heading">
                Changing Your Password
            </div>
            <div class="panel-body">
                <p>
                    Your account is from Active Directory.
                    <br><br>
                    Changing your password can take up to one to two hours to complete.
                </p>
            </div>
        </div>
    @endif

    <div class="col-md-12">
        {!! $form !!}
    </div>

@endsection
