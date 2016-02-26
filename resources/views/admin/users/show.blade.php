@extends('admin.layouts.master')

@section('title', "User: $user->name")

@section('content')

    <div class="panel panel-primary">

        <div class="panel-heading">
            <i class="fa fa-list"></i>
            Profile <span class="hidden-xs">Details</span>

            <div class="btn-group pull-right">

                <a href="{{ route('admin.users.edit', [$user->getKey()]) }}" class="btn btn-xs btn-warning">
                    <i class="fa fa-edit"></i>
                    Edit
                </a>

                {{-- Prevent user from deleting self. --}}
                @if (request()->user()->getKey() != $user->getKey())

                    <a
                            data-post="DELETE"
                            data-title="Delete User?"
                            data-message="Are you sure you want to delete this user?"
                            href="{{ route('admin.users.destroy', [$user->getKey()]) }}"
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
                    <th>Name</th>
                    <td>{{ $user->name }}</td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>

                <tr>
                    <th>Created</th>
                    <td>{{ $user->created_at_human }}</td>
                </tr>

                <tr>
                    <th>Last Updated</th>
                    <td>{{ $user->updated_at_human }}</td>
                </tr>

                <tr>
                    <th>Roles</th>
                    <td>
                        @if($user->roles->count() > 0)
                            @foreach($user->roles as $role)
                                {!! $role->display_label !!} <br>
                            @endforeach
                        @else

                            <em>No Roles</em>

                        @endif
                    </td>
                </tr>

                </tbody>

            </table>

        </div>

    </div>

    <div class="panel panel-primary">

        <div class="panel-heading">
            <i class="fa fa-check-circle-o"></i>
            <span class="hidden-xs">User Specific</span> Permissions

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
