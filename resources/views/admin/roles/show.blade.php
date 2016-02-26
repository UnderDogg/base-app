@extends('admin.layouts.master')

@section('title', "Role: $role->label")

@section('content')

    <div class="panel panel-primary">

        <div class="panel-heading">
            <i class="fa fa-list"></i>
            Profile <span class="hidden-xs">Details</span>

            <div class="btn-group pull-right">

                <a href="{{ route('admin.roles.edit', [$role->getKey()]) }}" class="btn btn-xs btn-warning">
                    <i class="fa fa-edit"></i>
                    Edit
                </a>

                {{-- Prevent user from deleting role that they are apart of. --}}
                @if (!request()->user()->hasRole($role->name))

                    <a
                            data-post="DELETE"
                            data-title="Delete Role?"
                            data-message="Are you sure you want to delete this role?"
                            href="{{ route('admin.roles.destroy', [$role->getKey()]) }}"
                            class="btn btn-xs btn-danger"
                    >
                        <i class="fa fa-trash"></i>
                        Delete
                    </a>

                @endif

            </div>
        </div>

        <div class="panel-body">

            <table class="table table-striped">

                <tbody>

                <tr>
                    <th>Label</th>
                    <td>{{ $role->label }}</td>
                </tr>

                <tr>
                    <th>Name</th>
                    <td>{{ $role->name }}</td>
                </tr>

                </tbody>

            </table>

        </div>

    </div>

    <div class="panel panel-primary">

        <div class="panel-heading">
            <i class="fa fa-users"></i>
            Users <span class="hidden-xs">Assigned to this Role</span>

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
            <i class="fa fa-check-circle-o"></i>
            Permissions <span class="hidden-xs">in this Role</span>

            <a data-toggle="modal" data-target="#form-permissions" class="btn btn-xs btn-success pull-right">
                <i class="fa fa-plus-circle"></i>
                Add
            </a>
        </div>

        <div class="panel-body">

            <div class="modal fade" id="form-permissions" tabindex="-1" role="dialog">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                            <h4 class="modal-title">
                                <i class="fa fa-check-circle-o"></i>
                                Add Permissions
                            </h4>

                        </div>

                        {!! $formPermissions !!}

                    </div>

                </div>

            </div>

            {!! $permissions !!}

        </div>

    </div>

@endsection
