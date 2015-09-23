@inject('formbuilder', 'form')
@inject('htmlbuilder', 'html')

{!! $formbuilder->open(array_merge($grid->attributes(), ['class' => 'form-horizontal'])) !!}

@if ($token)
    {!! $formbuilder->token() !!}
@endif

@foreach ($grid->hiddens() as $hidden)
    {!! $hidden !!}
@endforeach

<div class="col-md-3"></div>

<div class="col-md-6">
    @include('components.fieldsets')

    <button type="submit" class="btn btn-lg btn-block btn-primary">
        {!! $submit !!}
    </button>
</div>

<div class="col-md-3"></div>

<div class="clearfix"></div>

{!! $formbuilder->close() !!}
