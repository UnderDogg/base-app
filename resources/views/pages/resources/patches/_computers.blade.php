@if($patch->computers->count() > 0)

    <div class="panel panel-default">

        <div class="panel-body">

            <i class="fa fa-tags"></i>

            @foreach($patch->computers as $computer)
                {{ $computer->name }}
            @endforeach

        </div>

    </div>

@endif
