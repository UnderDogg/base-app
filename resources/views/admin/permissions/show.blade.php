@extends('admin.layouts.master')

@section('title', "Permission: $permission->label")

@section('content')

    <div class="panel panel-primary">

        <div class="panel-heading">
            <i class="fa fa-list"></i>
            Profile <span class="hidden-xs">Details</span>

            <div class="btn-group pull-right">

                <a href="{{ route('admin.permissions.edit', [$permission->getKey()]) }}" class="btn btn-xs btn-warning">
                    <i class="fa fa-edit"></i>
                    Edit
                </a>

                <a
                        data-post="DELETE"
                        data-title="Delete Permission?"
                        data-message="Are you sure you want to delete this permission?"
                        href="{{ route('admin.permissions.destroy', [$permission->getKey()]) }}"
                        class="btn btn-xs btn-danger"
                >
                    <i class="fa fa-trash"></i>
                    Delete
                </a>

            </div>
        </div>

        <div class="panel-body">

            <table class="table table-striped">

                <tbody>

                <tr>
                    <th>Label</th>
                    <td>{{ $permission->label }}</td>
                </tr>

                <tr>
                    <th>Name</th>
                    <td>{{ $permission->name }}</td>
                </tr>

                </tbody>

            </table>

        </div>

    </div>

    <div class="panel panel-primary">

        <div class="panel-heading">
            <i class="fa fa-users"></i>
            Users <span class="hidden-xs">that specifically have this Permission</span>

            <a data-toggle="modal" data-target="#form-users" class="btn btn-xs btn-success pull-right">
                <i class="fa fa-plus-circle"></i>
                Add
            </a>
        </div>

        <div class="panel-body">

            <div class="modal fade" id="form-users" tabindex="-1" role="dialog">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                            <h4 class="modal-title">
                                <i class="fa fa-users"></i>
                                Add Users
                            </h4>

                        </div>

                        {!! $formUsers !!}

                    </div>

                </div>

            </div>

            {!! $users !!}

        </div>

    </div>

    <div class="panel panel-primary">

        <div class="panel-heading">
            <i class="fa fa-user-md"></i>
            Roles <span class="hidden-xs">that this Permission is apart of</span>

            <a data-toggle="modal" data-target="#form-roles" class="btn btn-xs btn-success pull-right">
                <i class="fa fa-plus-circle"></i>
                Add
            </a>
        </div>

        <div class="panel-body">

            <div class="modal fade" id="form-roles" tabindex="-1" role="dialog">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                            <h4 class="modal-title">
                                <i class="fa fa-user-md"></i>
                                Add Roles
                            </h4>

                        </div>

                        {!! $formRoles !!}

                    </div>

                </div>

            </div>

            {!! $roles !!}

        </div>

    </div>

@endsection
