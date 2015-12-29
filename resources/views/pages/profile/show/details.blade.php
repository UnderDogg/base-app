@extends('pages.profile.show')

@section('show.panel.title')

    Details

    <span class="pull-right btn-group">
        {{-- Only allow users to edit their profile if they're not from Active Directory --}}
        @if(!$user->isFromAd())
            <a class="btn btn-xs btn-warning" href="{{ route('profile.edit') }}">
                Edit
            </a>
        @endif
        <a
                class="btn btn-xs btn-danger"
                data-post="DELETE"
                data-title="Deactivate Your Profile?"
                data-message="Are you sure you want to deactivate your profile?
                You'll be logged out and you'll need to log back in to reactivate."
                href="#"
        >
            Deactivate
        </a>
    </span>
@endsection

@section('show.panel.body')

    <div class="col-md-12">
        {!! $form !!}
    </div>

    <script>
        $(function () {
            $('button[type="submit"]')
                    .attr('disabled', 'disabled')
                    .attr('class', 'hidden');
        });
    </script>

@endsection
