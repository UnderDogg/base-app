<ul class="nav navbar-left navbar-nav">

    @can('manage.guides')

        <li class="{{ active()->route('resources.guides.steps.index') }}">
            <a href="{{ route('resources.guides.steps.index', [$guide->slug]) }}">
                <i class="fa fa-list"></i>
                All Steps
            </a>
        </li>

        <li>
            <a href="{{ route('resources.guides.images', [$guide->slug]) }}">
                <i class="fa fa-plus-circle"></i>
                Add Steps by Images
            </a>
        </li>

        <li>
            <a href="{{ route('resources.guides.steps.create', [$guide->slug]) }}">
                <i class="fa fa-plus-circle"></i>
                New Step
            </a>
        </li>

        <li>
            <a href="{{ route('resources.guides.edit', [$guide->slug]) }}">
                <i class="fa fa-edit"></i>
                Edit
            </a>
        </li>

        <li>
            <a href="{{ route('resources.guides.destroy', [$guide->slug]) }}"
               data-post="DELETE"
               data-title="Delete Guide?"
               data-message="Are you sure you want to delete this guide? It cannot be recovered."
            >
                <i class="fa fa-trash"></i>
                Delete
            </a>
        </li>

    @endcan

    <li>
        <a href="{{ route('resources.guides.favorite', [$guide->slug]) }}">
            {!! $guide->getFavoriteIcon() !!}
            Favorite
        </a>
    </li>

</ul>
