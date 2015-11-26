@inject('formbuilder', 'form')
@inject('htmlbuilder', 'html')

{!! $formbuilder->open(array_merge($grid->attributes(), ['class' => 'form-horizontal'])) !!}

@if ($token)
    {!! $formbuilder->token() !!}
@endif

@foreach ($grid->hiddens() as $hidden)
    {!! $hidden !!}
@endforeach

@include('components.fieldsets')

<fieldset>

    <div class="row">
        {{-- Fixed row issue on Bootstrap 3 --}}
    </div>

    <div class="row">

        <div>

            <button type="submit" name="action" value="single" class="btn btn-primary">
                {!! $submit !!}
            </button>

            <button type="submit" name="action" value="multiple" class="btn btn-primary">
                Save & Add Another
            </button>

        </div>

    </div>

</fieldset>

{!! $formbuilder->close() !!}
