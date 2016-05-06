<ul class="nav navbar-left navbar-nav">

    <li class="{{ active()->route('issues.index') }}">

        <a href="{{ route('issues.index') }}">
            <i class="fa fa-exclamation-circle"></i>

            Open

            <span class="badge">{{ $open }}</span>
        </a>

    </li>

    <li class="{{ active()->route('issues.closed') }}" >

        <a href="{{ route('issues.closed') }}">
            <i class="fa fa-check-circle"></i>

            Closed

            <span class="badge">{{ $closed }}</span>
        </a>

    </li>

    <li class="dropdown {{ active()->input('label') }}">

        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-tags"></i>
            Labels
            <i class="fa fa-caret-down"></i>
        </a>

        <ul class="dropdown-menu dropdown-menu-labels">
            @if(count($labels) > 0)

                @foreach($labels as $label)

                    <li class="{{ active()->input('label', $label->name) }}">

                        <a href="{{ route(request()->route()->getName(), array_merge(request()->all(), ['label' => $label->name])) }}">
                            {!! $label->display_large !!}
                        </a>

                    </li>

                @endforeach

            @else

                @can('manage.labels')

                    <li>
                        <a href="{{ route('labels.create') }}">
                            <i class="fa fa-plus-square"></i> Create a Label
                        </a>
                    </li>

                @elsecan

                    <li>
                        <a>
                            No Labels
                        </a>
                    </li>

                @endcan

            @endif
        </ul>

    </li>

    <li>
        <a href="{{ route('issues.create') }}">
            <i class="fa fa-plus-square"></i> New Ticket
        </a>
    </li>

</ul>

@include('components.search')
