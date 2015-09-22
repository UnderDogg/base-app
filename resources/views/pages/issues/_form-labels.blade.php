@can('addLabels', $issue)

<a class="btn btn-default" href="#" data-toggle="modal" data-target="#label-modal">
    <i class="fa fa-tag"></i>
    Labels
</a>

<div class="modal fade" id="label-modal" tabindex="-1" role="dialog" aria-labelledby="label-modal">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Labels</h4>

            </div>

            {!! $formLabels !!}

        </div>

    </div>

</div>
@endcan
