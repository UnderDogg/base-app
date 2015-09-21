@inject('formbuilder', 'form')
@inject('htmlbuilder', 'html')

{!! $formbuilder->open(array_merge($form, ['class' => 'form-horizontal'])) !!}

@if ($token)
    {!! $formbuilder->token() !!}
@endif

@foreach ($hiddens as $hidden)
    {!! $hidden !!}
@endforeach

@include('components.fieldsets')

<fieldset>

    <div class="row">
        {{-- Fixed row issue on Bootstrap 3 --}}
    </div>

    <div class="row">

        <div class="pull-right">

            <button type="submit" class="btn btn-primary">
                {!! $submit !!}
            </button>

        </div>

    </div>

</fieldset>

{!! $formbuilder->close() !!}
