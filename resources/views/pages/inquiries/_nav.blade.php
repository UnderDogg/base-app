<ul class="nav navbar-left navbar-nav">

    <li class="{{ active()->route('inquiries.index') }}">
        <a href="{{ route('inquiries.index') }}">
            <i class="fa fa-exclamation-circle"></i> Open Requests
        </a>
    </li>

    <li class="{{ active()->route('inquiries.closed') }}" >
        <a href="{{ route('inquiries.closed') }}">
            <i class="fa fa-check-circle"></i> Closed Requests
        </a>
    </li>

    <li>
        <a href="{{ route('inquiries.create') }}">
            <i class="fa fa-plus-square"></i> New Request
        </a>
    </li>

</ul>

@include('pages.inquiries._search')
