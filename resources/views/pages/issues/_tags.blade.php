@if($issue->users->count() > 0 || $issue->labels->count() > 0)

    <div class="panel panel-default">

        <div class="panel-heading">

            <div class="panel-title">

                <span class="pull-right text-muted">

                    <i class="fa fa-tags"></i>

                </span>

                <div class="clearfix"></div>

            </div>

        </div>

        <div class="panel-body">

            @foreach($issue->labels as $label)
                {!! $label->display_large !!}
            @endforeach

            @foreach($issue->users as $user)
                {!! $user->present()->labelLarge() !!}
            @endforeach

        </div>

    </div>

@endif
