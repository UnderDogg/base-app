<ul class="nav nav-pills nav-stacked">
    @foreach($accounts as $account => $permissions)
        <li role="presentation" class="#">
            <a title="Account" href="#">
                {{ $account }}

                @foreach ($permissions as $permission)
                    <br>
                    <span class="label label-default">{{ $permission }}</span>
                @endforeach
            </a>
        </li>
    @endforeach
</ul>
