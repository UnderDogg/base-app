<?php

namespace App\Http\Presenters\Admin;

use App\Http\Presenters\Presenter;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Orchestra\Contracts\Html\Form\Field;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Column;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;

class PermissionPresenter extends Presenter
{
    /**
     * Returns a new form for the specified permission.
     *
     * @param Permission $permission
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(Permission $permission)
    {
        return $this->form->of('permissions', function (FormGrid $form) use ($permission) {
            if ($permission->exists) {
                $method = 'PATCH';
                $url = route('admin.permissions.update', [$permission->getKey()]);

                $form->submit = 'Save';
            } else {
                $method = 'POST';
                $url = route('admin.permissions.store');

                $form->submit = 'Create';
            }

            $form->attributes(compact('method', 'url'));

            $form->with($permission);

            $form->fieldset(function (Fieldset $fieldset) use ($permission) {
                $fieldset->control('input:text', 'name', function (Field $field) use ($permission) {
                    $attributes = [
                        'placeholder' => 'Enter the permissions name.',
                    ];

                    // We don't want to allow users to change the permission name since this
                    // could cause issues with authorization down the line.
                    if ($permission->exists) {
                        $attributes['disabled'] = true;
                    }

                    $field->attributes($attributes);
                });

                $fieldset
                    ->control('input:text', 'label')
                    ->attributes([
                        'placeholder' => 'Enter the permissions label.',
                    ]);
            });
        });
    }

    /**
     * Returns a new form for adding users to the specified permission.
     *
     * @param Permission $permission
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function formUsers(Permission $permission)
    {
        return $this->form->of('permissions.users', function (FormGrid $form) use ($permission) {
            $method = 'POST';
            $url = route('admin.permissions.users.store', [$permission->getKey()]);

            $form->attributes(compact('method', 'url'));

            $form->with($permission);

            $form->layout('admin.components.form-modal');

            $form->submit = 'Save';

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset
                    ->control('input:select', 'users[]')
                    ->label('Users')
                    ->options(function (Permission $permission) {
                        // We'll only allow users to select permissions that
                        // aren't apart of the current role.
                        return User::whereDoesntHave('permissions', function (Builder $builder) use ($permission) {
                            $builder->whereEmail($permission->name);
                        })->get()->pluck('name', 'id');
                    })
                    ->attributes([
                        'class'    => 'select-users',
                        'multiple' => true,
                    ]);
            });
        });
    }

    /**
     * Returns a new form for adding roles to the specified permission.
     *
     * @param Permission $permission
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function formRoles(Permission $permission)
    {
        return $this->form->of('permissions.roles', function (FormGrid $form) use ($permission) {
            $method = 'POST';
            $url = route('admin.permissions.roles.store', [$permission->getKey()]);

            $form->attributes(compact('method', 'url'));

            $form->with($permission);

            $form->layout('admin.components.form-modal');

            $form->submit = 'Save';

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset
                    ->control('input:select', 'roles[]')
                    ->label('Roles')
                    ->options(function (Permission $permission) {
                        // We'll only allow users to select permissions that
                        // aren't apart of the current role.
                        return Role::whereDoesntHave('permissions', function (Builder $builder) use ($permission) {
                            $builder->whereName($permission->name);
                        })->get()->pluck('label', 'id');
                    })
                    ->attributes([
                        'class'    => 'select-users',
                        'multiple' => true,
                    ]);
            });
        });
    }

    /**
     * Returns a new table of all permissions.
     *
     * @param Permission $permission
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(Permission $permission)
    {
        $permission = $permission->with('roles');

        return $this->table->of('permissions', function (TableGrid $table) use ($permission) {
            $table->with($permission)->paginate($this->perPage);

            $table->column('label', function (Column $column) {
                $column->value = function (Permission $permission) {
                    return link_to_route('admin.permissions.show', $permission->label, [$permission->getKey()]);
                };
            });

            $table->column('name', function (Column $column) {
                // We'll remove this column when
                // viewing on smaller screens.
                $column->headers = [
                    'class' => 'hidden-xs',
                ];

                $column->attributes(function () {
                    return [
                        'class' => 'hidden-xs',
                    ];
                });
            });

            $table->column('roles', function (Column $column) {
                $column->value = function (Permission $permission) {
                    $labels = '';

                    foreach ($permission->roles as $role) {
                        $labels .= $role->display_label.'<br>';
                    };

                    return $labels;
                };
            });

            $table->column('created_at_human', function (Column $column) {
                $column->label = 'Created';

                // We'll remove this column when
                // viewing on smaller screens.
                $column->headers = [
                    'class' => 'hidden-xs',
                ];

                $column->attributes(function () {
                    return [
                        'class' => 'hidden-xs',
                    ];
                });
            });
        });
    }

    /**
     * Returns a new table of all users that have the specified permission.
     *
     * @param Permission $permission
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function tableUsers(Permission $permission)
    {
        $users = $permission->users();

        return $this->table->of('permissions.users', function (TableGrid $table) use ($permission, $users) {
            $table->with($users)->paginate(10);

            $table->pageName = 'users';

            $table->column('name', function (Column $column) {
                $column->value = function (User $user) {
                    return link_to_route('admin.users.show', $user->name, [$user->getKey()]);
                };
            });

            $table->column('email', function (Column $column) {
                // We'll remove this column when
                // viewing on smaller screens.
                $column->headers = [
                    'class' => 'hidden-xs',
                ];

                $column->attributes(function () {
                    return [
                        'class' => 'hidden-xs',
                    ];
                });
            });

            $table->column('remove', function (Column $column) use ($permission) {
                $column->value = function (User $user) use ($permission) {
                    return link_to_route('admin.permissions.users.destroy', 'Remove', [$permission->getKey(), $user->getKey()], [
                        'class'        => 'btn btn-xs btn-danger',
                        'data-post'    => 'DELETE',
                        'data-title'   => 'Are you sure?',
                        'data-message' => 'Are you sure you want to remove this permission from this user?',
                    ]);
                };
            });
        });
    }

    /**
     * Returns a new table of all roles that have the specified permission.
     *
     * @param Permission $permission
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function tableRoles(Permission $permission)
    {
        $roles = $permission->roles()->with('users');

        return $this->table->of('permissions.roles', function (TableGrid $table) use ($permission, $roles) {
            $table->with($roles)->paginate(10);

            $table->column('label', function (Column $column) {
                $column->value = function (Role $role) {
                    return link_to_route('admin.roles.show', $role->label, [$role->getKey()]);
                };
            });

            $table->column('name', function (Column $column) {
                // We'll remove this column when
                // viewing on smaller screens.
                $column->headers = [
                    'class' => 'hidden-xs',
                ];

                $column->attributes(function () {
                    return [
                        'class' => 'hidden-xs',
                    ];
                });
            });

            $table->column('users', function (Column $column) {
                $column->value = function (Role $role) {
                    return $role->users->count();
                };
            });

            $table->column('remove', function (Column $column) use ($permission) {
                $column->value = function (Role $role) use ($permission) {
                    return link_to_route('admin.permissions.roles.destroy', 'Remove', [$permission->getKey(), $role->getKey()], [
                        'class'        => 'btn btn-xs btn-danger',
                        'data-post'    => 'DELETE',
                        'data-title'   => 'Are you sure?',
                        'data-message' => 'Are you sure you want to remove this permission from this role?',
                    ]);
                };
            });
        });
    }
}
