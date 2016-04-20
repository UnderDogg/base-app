<ul class="nav navbar-left navbar-nav">

    <li class="{{ active()->route('services.index') }}">
        <a href="{{ route('services.index') }}">
            <i class="fa fa-list"></i> All Services
        </a>
    </li>

    <li>
        <a href="{{ route('services.create') }}">
            <i class="fa fa-plus"></i> New Service
        </a>
    </li>

</ul>
