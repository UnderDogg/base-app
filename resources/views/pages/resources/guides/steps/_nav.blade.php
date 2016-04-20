<ul class="nav navbar-left navbar-nav">

    <li class="{{ active()->route('resources.guides.steps.index') }}">
        <a href="{{ route('resources.guides.steps.index', [$guide->slug]) }}">
            All Steps
        </a>
    </li>

    <li>
        <a href="{{ route('resources.guides.steps.create', [$guide->slug]) }}">
            <i class="fa fa-plus"></i> New Step
        </a>
    </li>

</ul>
