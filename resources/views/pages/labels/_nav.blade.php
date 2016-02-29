<ul class="nav navbar-left navbar-nav">

    <li class="{{ active()->route('labels.index') }}">
        <a href="{{ route('labels.index') }}">
            <i class="fa fa-tag"></i> All Labels
        </a>
    </li>

    @if(\App\Policies\LabelPolicy::create(auth()->user()))
        <li><a href="{{ route('labels.create') }}"><i class="fa fa-plus"></i> New Label</a></li>
    @endif

</ul>

