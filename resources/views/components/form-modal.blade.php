@inject('formbuilder', 'form')
@inject('htmlbuilder', 'html')

{!! $formbuilder->open($grid->attributes()) !!}

<div class="modal-body">

    @if ($token)
        {!! $formbuilder->token() !!}
    @endif

    @foreach ($grid->hiddens() as $hidden)
        {!! $hidden !!}
    @endforeach

    @include('components.fieldsets')

</div>

<div class="modal-footer">

    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

    <button type="submit" class="btn btn-primary">
        {!! $submit !!}
    </button>

</div>

{!! $formbuilder->close() !!}
