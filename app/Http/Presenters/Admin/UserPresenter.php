<?php

namespace App\Http\Presenters\Admin;

use App\Http\Presenters\Presenter;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Column;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;

class UserPresenter extends Presenter
{
    /**
     * Returns a new form for the specified user.
     *
     * @param User $user
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(User $user)
    {
        return $this->form->of('users', function (FormGrid $form) use ($user) {
            if ($user->exists) {
                $method = 'PATCH';
                $url = route('admin.users.update', [$user->getKey()]);

                $form->submit = 'Save';
            } else {
                $method = 'POST';
                $url = route('admin.users.store');

                $form->submit = 'Create';
            }

            $form->attributes(compact('method', 'url'));

            $form->with($user);

            $form->fieldset(function (Fieldset $fieldset) use ($user) {
                $fieldset
                    ->control('input:text', 'name')
                    ->attributes([
                        'placeholder' => 'Enter the users name.',
                    ]);

                $fieldset
                    ->control('input:text', 'email')
                    ->attributes([
                        'placeholder' => 'Enter the users email address.',
                    ]);

                if ($user->exists) {
                    $fieldset
                        ->control('input:select', 'roles[]')
                        ->label('Roles')
                        ->options(function () {
                            return Role::all()->pluck('label', 'id');
                        })
                        ->value(function (User $user) {
                            return $user->roles->pluck('id');
                        })
                        ->attributes([
                            'class'    => 'select-roles',
                            'multiple' => true,
                        ]);
                }

                $fieldset
                    ->control('input:password', 'password')
                    ->attributes([
                        'placeholder' => 'Enter a password to change the users password.',
                    ]);

                $fieldset
                    ->control('input:password', 'password_confirmation')
                    ->attributes([
                        'placeholder' => 'Enter the users password again.',
                    ]);
            });
        });
    }

    /**
     * Returns a new form for adding permissions to the specified user.
     *
     * @param User $user
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function formPermissions(User $user)
    {
        return $this->form->of('users.permissions', function (FormGrid $form) use ($user) {
            $method = 'POST';
            $url = route('admin.users.permissions.store', [$user->getKey()]);

            $form->attributes(compact('method', 'url'));

            $form->with($user);

            $form->layout('admin.components.form-modal');

            $form->submit = 'Save';

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset
                    ->control('input:select', 'permissions[]')
                    ->label('Permissions')
                    ->options(function (User $user) {
                        // We'll only allow users to select permissions that
                        // aren't apart of the current role.
                        return Permission::whereDoesntHave('users', function (Builder $builder) use ($user) {
                            $builder->whereEmail($user->email);
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
     * Returns a new table for all users.
     *
     * @param User $user
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(User $user)
    {
        return $this->table->of('users', function (TableGrid $table) use ($user) {
            $table->with($user)->paginate($this->perPage);

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

            $table->column('roles', function (Column $column) {
                $column->value = function (User $user) {
                    $labels = '';

                    foreach ($user->roles as $role) {
                        $labels .= $role->display_label.'<br>';
                    }

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
     * Returns a new table for the specified role permissions.
     *
     * @param User $user
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function tablePermissions(User $user)
    {
        $permissions = $user->permissions()->orderBy('name');

        return $this->table->of('users.permissions', function (TableGrid $table) use ($user, $permissions) {
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

            $table->column('remove', function (Column $column) use ($user) {
                $column->value = function (Permission $permission) use ($user) {
                    return link_to_route('admin.users.permissions.destroy', 'Remove', [$user->getKey(), $permission->getKey()], [
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
