@inject('formbuilder', 'form')
@inject('request', 'request')

<form class="navbar-form navbar-right" role="search">
    <div class="input-group">
        {!! $formbuilder->text('q', rawurldecode($request->input('q', '')), ['placeholder' => 'Search', 'class' => 'form-control', 'role' => 'keyword']) !!}
        <span class="input-group-btn">
            {!! $formbuilder->submit('Search', ['class' => 'btn btn-default']) !!}
        </span>
    </div>
</form>
