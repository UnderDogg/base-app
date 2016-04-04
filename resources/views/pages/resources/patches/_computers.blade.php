<div class="panel panel-default">

    <div class="panel-heading">

        <div class="panel-title">
            <i class='fa fa-desktop'></i>

            Computers Patched

            <div class="pull-right">

                <a href="#form-computers" data-toggle="modal" class="btn btn-xs btn-success">
                    <i class="fa fa-plus-circle"></i> Add
                </a>

            </div>
        </div>

    </div>

    <div class="panel-body">

        {!! $computers !!}

    </div>

</div>

<div class="modal fade" id="form-computers" tabindex="-1" role="dialog">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title">
                    <i class="fa fa-plus-circle"></i>
                    Add Computers
                </h4>

            </div>

            {!! $form !!}

        </div>

    </div>

</div>
