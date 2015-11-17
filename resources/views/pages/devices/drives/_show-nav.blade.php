<ul class="nav nav-pills nav-stacked">
    @foreach($accounts as $account => $permissions)

        <li role="presentation" class="#">
            <a title="Account" href="#">
                {{ $account }}

                @each('pages.devices.drives._permission', $permissions, 'permission')
            </a>
        </li>

    @endforeach
</ul>
