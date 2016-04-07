@extends('layouts.attachment')

@section('title', 'Viewing Attachment')

@section('actions')

    <div class="btn-group" role="group">
        <a class="btn btn-primary btn-lg" href="{{ route('issues.comments.attachments.download', [$issue->id, $comment->id, $file->uuid]) }}">
            <i class="fa fa-download"></i>
            Download
        </a>

        <div class="btn-group" role="group">

            <button type="button" class="btn btn-lg btn-default dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">

                <i class="fa fa-cog"></i>

                <span class="caret"></span>

            </button>

            <ul class="dropdown-menu">

                <li>

                    <a href="{{ route('issues.comments.attachments.edit', [$issue->id, $comment->id, $file->uuid]) }}">
                        <i class="fa fa-edit"></i>
                        Edit
                    </a>
                </li>

                <li>

                    <a
                            data-title="Delete Attachment?"
                            data-message="Are you sure you want to delete this attachment?"
                            data-post="DELETE"
                            href="{{ route('issues.comments.attachments.destroy', [$issue->id, $comment->id, $file->uuid]) }}"
                    >
                        <i class="fa fa-trash"></i>
                        Delete
                    </a>

                </li>

            </ul>

        </div>

    </div>

    @if($file->is_image)

        <hr>

        <div class="col-md-12">

            <h4>

                <i class="fa fa-link"></i>

                Markdown Link

            </h4>

            <div class="well">

                ![Image]({{ route('issues.comments.attachments.download', [$issue->id, $comment->id, $file->uuid]) }})

            </div>

            <p></p>

        </div>

    @endif

@endsection
