<ul class="nav navbar-left navbar-nav">

    <li class="{{ active()->route('inquiries.index') }}">
        <a href="{{ route('inquiries.index') }}">
            <i class="fa fa-exclamation-circle"></i> Open
        </a>
    </li>

    <li class="{{ active()->route('inquiries.approved') }}" >
        <a href="{{ route('inquiries.approved') }}">
            <i class="fa fa-check-circle"></i> Approved
        </a>
    </li>

    <li class="{{ active()->route('inquiries.closed') }}" >
        <a href="{{ route('inquiries.closed') }}">
            <i class="fa fa-times-circle"></i> Closed
        </a>
    </li>

    <li>
        <a href="{{ route('inquiries.start') }}">
            <i class="fa fa-plus-square"></i> New
        </a>
    </li>

</ul>

@include('pages.inquiries._search')
