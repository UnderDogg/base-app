@can('addUsers', $issue)

<a class="btn btn-default" href="#" data-toggle="modal" data-target="#users-modal">
    <i class="fa fa-users"></i>
    Users
</a>

<div class="modal fade" id="users-modal" tabindex="-1" role="dialog" aria-labelledby="users-modal">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Users Who Are Affected</h4>

            </div>

            {!! $formUsers !!}

        </div>

    </div>

</div>
@endcan
