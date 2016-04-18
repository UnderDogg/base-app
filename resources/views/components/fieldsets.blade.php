@foreach ($grid->fieldsets() as $fieldset)

    <fieldset{!! $htmlbuilder->attributes($fieldset->attributes ?: []) !!}>

        @if ($fieldset->name)
            <legend>{!! $fieldset->name or '' !!}</legend>
        @endif

        @foreach ($fieldset->controls() as $control)

            <div class="form-group{!! $errors->has($control->id) ? ' has-error' : '' !!}">
                {!! $formbuilder->label($control->name, $control->label, ['class' => 'control-label']) !!}

                <div class="nine columns">

                    {!! $control->getField($grid->data(), $control, []) !!}

                    {!! $errors->first($control->id, $format) !!}

                </div>

            </div>

        @endforeach

    </fieldset>

@endforeach
