<div class="form-group{{ $errors->first('mail', ' has-error') }}">
    <div>
        {!! Form::text('mail', null, ['class' => 'form-control', 'placeholder' => 'Enter your Email']) !!}

        <span class="label label-danger">{{ $errors->first('mail', ':message') }}</span>
    </div>
</div>

<div class="form-group{{ $errors->first('password', ' has-error') }}">
    <div>
        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter your Email']) !!}

        <span class="label label-danger">{{ $errors->first('password', ':message') }}</span>
    </div>
</div>

<div class="form-group">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</div>
