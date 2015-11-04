<ul class="nav nav-pills nav-stacked">
    @foreach($accounts as $account)
        <li role="presentation" class="#">
            <a title="Account" href="#">
                {{ $account->getName() }}

                @foreach ($account->getPermissions() as $permission)
                    <span class="label label-default">{{ $permission }}</span>
                @endforeach
            </a>
        </li>
    @endforeach
</ul>
