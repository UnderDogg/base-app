<?php

namespace App\Http\Presenters\ActiveDirectory;

use Orchestra\Support\Facades\HTML;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;
use Adldap\Models\User as AdUser;
use App\Models\User;
use App\Http\Presenters\Presenter;

class UserPresenter extends Presenter
{
    /**
     * Returns a new table of all active directory users.
     *
     * @param array $users
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(array $users = [])
    {
        return $this->table->of('active-directory.users', function(TableGrid $table) use ($users)
        {
            $table->attributes('class', 'table table-hover');

            $table->rows($users);

            $table->column('name', function ($column) {
                $column->label = 'Name';
                $column->value = function (AdUser $user) {
                    return $user->getName();
                };
            });

            $table->column('email', function ($column) {
                $column->label = 'Email';
                $column->value = function (AdUser $user) {
                    return $user->getEmail();
                };
            });

            $table->column('department', function ($column) {
                $column->label = 'Department';
                $column->value = function (AdUser $user) {
                    return $user->getDepartment();
                };
            });

            $table->column('add', function ($column) {
                $column->attributes(function () {
                    return ['class' => 'text-center'];
                });

                $column->label = 'Add';
                $column->value = function (AdUser $user) {
                    $exists = User::where('email', $user->getEmail())->first();

                    if($exists) {
                        return $this->formAdded();
                    } else {
                        return $this->formAdd($user);
                    }
                };
            });
        });
    }

    /**
     * Returns a form for adding an AD computer.
     *
     * @param AdUser $user
     *
     * @return object|\Orchestra\Contracts\Html\Builder
     */
    public function formAdd(AdUser $user)
    {
        $key = $user->getDn();

        return $this->form->of($key, function(FormGrid $form) use ($user) {
            $form->attributes([
                'url' => route('active-directory.users.store'),
                'method' => 'POST',
            ]);

            $form->hidden('dn', function($field) use ($user) {
                $field->value = $user->getDn();
            });

            $form->submit = 'Add';
        });
    }

    /**
     * Returns a button displaying that the user has already been added.
     *
     * @return string
     */
    public function formAdded()
    {
        return HTML::create('input', null, [
            'type' => 'submit',
            'class' => 'btn btn-primary',
            'value' => 'Added',
            'disabled' => true,
        ]);
    }

    /**
     * Returns a new navbar for the active directory users index.
     *
     * @return \Illuminate\Support\Fluent
     */
    public function navbar()
    {
        return $this->fluent([
            'id'    => 'ad-users',
            'title' => 'Users',
            'url'   => route('active-directory.users.index'),
            'menu'  => view('pages.active-directory.users._nav'),
            'attributes' => [
                'class' => 'navbar-default'
            ],
        ]);
    }
}
