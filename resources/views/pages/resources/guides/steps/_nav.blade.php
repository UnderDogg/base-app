<ul class="nav navbar-left navbar-nav">
    <li class="{{ active()->route('resources.guides.steps.index') }}">
        <a href="{{ route('resources.guides.steps.index', [$guide->getSlug()]) }}">
            All Steps
        </a>
    </li>
    <li>
        <a href="{{ route('resources.guides.steps.create', [$guide->getSlug()]) }}">
            <i class="fa fa-plus"></i> New Step
        </a>
    </li>
</ul>
