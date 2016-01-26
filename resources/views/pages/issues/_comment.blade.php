<div class="panel panel-{{ $comment->isResolution() ? 'success': 'default' }}" id="comment-{{ $comment->getKey() }}">

    <div class="panel-heading">

        <h3 class="panel-title">

            @if($comment->isResolution())
                <i class="fa fa-check-square"></i>
            @endif

            <span class="h5">
                {!! $comment->getCreatedAtTagLine() !!}
            </span>

            <div class="clearfix"></div>

        </h3>

    </div>

    <div class="panel-body">
        {!! $comment->getContentFromMarkdown() !!}
    </div>

</div>
