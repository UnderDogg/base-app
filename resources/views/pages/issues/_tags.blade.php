@if($issue->users->count() > 0 || $issue->labels->count() > 0)

    <div class="panel panel-default">

        <div class="panel-body">

            <i class="fa fa-tags"></i>

            @foreach($issue->labels as $label)
                {!! $label->display_large !!}
            @endforeach

            @foreach($issue->users as $user)
                {!! $user->label_large !!}
            @endforeach

        </div>

    </div>

@endif
