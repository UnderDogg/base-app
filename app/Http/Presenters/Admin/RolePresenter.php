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

class RolePresenter extends Presenter
{
    /**
     * Returns a new form for the specified role.
     *
     * @param Role $role
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(Role $role)
    {
        return $this->form->of('roles', function (FormGrid $form) use ($role) {
            if ($role->exists) {
                $method = 'PATCH';
                $url = route('admin.roles.update', [$role->getKey()]);

                $form->submit = 'Save';
            } else {
                $method = 'POST';
                $url = route('admin.roles.store', [$role->getKey()]);

                $form->submit = 'Create';
            }

            $form->attributes(compact('method', 'url'));

            $form->with($role);

            $form->fieldset(function (Fieldset $fieldset) use ($role) {
                $fieldset->control('input:text', 'name', function (Field $field) use ($role) {
                    $attributes = ['placeholder' => 'Enter the roles name.'];

                    if ($role->isAdministrator()) {
                        $attributes['disabled'] = true;
                    }

                    $field->attributes($attributes);
                });

                $fieldset
                    ->control('input:text', 'label')
                    ->attributes([
                        'placeholder' => 'Enter the roles display label.',
                    ]);
            });
        });
    }

    /**
     * Returns a new form for attaching users to the specified role.
     *
     * @param Role $role
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function formUsers(Role $role)
    {
        return $this->form->of('roles.users', function (FormGrid $form) use ($role) {
            $method = 'POST';
            $url = route('admin.roles.users.store', [$role->getKey()]);

            $form->attributes(compact('method', 'url'));

            $form->with($role);

            $form->layout('admin.components.form-modal');

            $form->submit = 'Save';

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset
                    ->control('input:select', 'users[]')
                    ->label('Users')
                    ->options(function (Role $role) {
                        // We'll only allow users to select users that
                        // aren't apart of the current role.
                        return User::whereDoesntHave('roles', function (Builder $builder) use ($role) {
                            $builder->whereName($role->name);
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
     * Returns a new form for attaching permissions to the specified role.
     *
     * @param Role $role
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function formPermissions(Role $role)
    {
        return $this->form->of('roles.permissions', function (FormGrid $form) use ($role) {
            $method = 'POST';
            $url = route('admin.roles.permissions.store', [$role->getKey()]);

            $form->attributes(compact('method', 'url'));

            $form->with($role);

            $form->layout('admin.components.form-modal');

            $form->submit = 'Save';

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset
                    ->control('input:select', 'permissions[]')
                    ->label('Permissions')
                    ->options(function (Role $role) {
                        // We'll only allow users to select permissions that
                        // aren't apart of the current role.
                        return Permission::whereDoesntHave('roles', function (Builder $builder) use ($role) {
                            $builder->whereName($role->name);
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
     * Returns a new table displaying all roles.
     *
     * @param Role $role
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(Role $role)
    {
        return $this->table->of('roles', function (TableGrid $table) use ($role) {
            $table->with($role)->paginate($this->perPage);

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
     * Returns a new table for the specified role users.
     *
     * @param Role $role
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function tableUsers(Role $role)
    {
        $users = $role->users()->orderBy('name');

        return $this->table->of('roles.users', function (TableGrid $table) use ($role, $users) {
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

            $table->column('remove', function (Column $column) use ($role) {
                $column->value = function (User $user) use ($role) {
                    return link_to_route('admin.roles.users.destroy', 'Remove', [$role->getKey(), $user->getKey()], [
                        'class'        => 'btn btn-xs btn-danger',
                        'data-post'    => 'DELETE',
                        'data-title'   => 'Are you sure?',
                        'data-message' => 'Are you sure you want to remove this user?',
                    ]);
                };
            });
        });
    }

    /**
     * Returns a new table for the specified role permissions.
     *
     * @param Role $role
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function tablePermissions(Role $role)
    {
        $permissions = $role->permissions()->orderBy('name');

        return $this->table->of('roles.permissions', function (TableGrid $table) use ($role, $permissions) {
            $table->with($permissions)->paginate(10);

            $table->pageName = 'permissions';

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

            $table->column('remove', function (Column $column) use ($role) {
                $column->value = function (Permission $permission) use ($role) {
                    return link_to_route('admin.roles.permissions.destroy', 'Remove', [$role->getKey(), $permission->getKey()], [
                        'class'        => 'btn btn-xs btn-danger',
                        'data-post'    => 'DELETE',
                        'data-title'   => 'Are you sure?',
                        'data-message' => 'Are you sure you want to remove this permission?',
                    ]);
                };
            });
        });
    }
}
