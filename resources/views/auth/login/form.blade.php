<div class="form-group{{ $errors->first('mail', ' has-error') }}">
    <div>
        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter your Email']) !!}

        <span class="label label-danger">{{ $errors->first('email', ':message') }}</span>
    </div>
</div>

<div class="form-group{{ $errors->first('password', ' has-error') }}">
    <div>
        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter your Password']) !!}

        <span class="label label-danger">{{ $errors->first('password', ':message') }}</span>
    </div>
</div>

<div class="form-group">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</div>
