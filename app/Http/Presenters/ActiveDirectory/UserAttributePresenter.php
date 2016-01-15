<?php

namespace App\Http\Presenters\ActiveDirectory;

use Adldap\Models\User;
use App\Http\Presenters\Presenter;
use Orchestra\Contracts\Html\Form\Field;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Table\Column;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Support\Facades\HTML;

class UserAttributePresenter extends Presenter
{
    /**
     * Returns a new table of all attributes of the specified user.
     *
     * @param User $user
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(User $user)
    {
        $raw = $user->getAttributes();

        // We'll remove all numeric keys so we don't have any duplicate values.
        $keys = array_intersect_key($raw, array_flip(array_filter(array_keys($raw), 'is_numeric')));

        $attributes = [];

        foreach ($keys as $attribute) {
            $attributes[] = [$attribute => $user->getAttribute($attribute)];
        }

        return $this->table->of('active-directory.users.attributes', function (TableGrid $table) use ($user, $attributes) {
            $table->rows($attributes);

            $table->column('attribute_name', function (Column $column) use ($user) {
                $column->value = function (array $attributes) use ($user) {
                    $route = 'active-directory.users.attributes.edit';

                    $attribute = key($attributes);

                    $params = [$user->getAccountName(), $attribute];

                    return link_to_route($route, $attribute, $params);
                };
            });

            $table->column('value', function (Column $column) {
                $column->headers = ['class' => 'hidden-xs'];

                $column->value = function (array $attributes) {
                    $values = $attributes[key($attributes)];

                    return HTML::ul($values, ['class' => 'list-unstyled']);
                };

                $column->attributes = function () {
                    return ['class' => 'hidden-xs'];
                };
            });

            $table->column('delete', function (Column $column) use ($user) {
                $column->value = function (array $attributes) use ($user) {
                    $route = 'active-directory.users.attributes.destroy';

                    $attribute = key($attributes);

                    $params = [$user->getAccountName(), $attribute];

                    return link_to_route($route, 'Delete', $params, [
                        'class'         => 'btn btn-sm btn-danger',
                        'data-post'     => 'DELETE',
                        'data-title'    => 'Delete Attribute?',
                        'data-message'  => "Are you sure you want to delete the $attribute attribute?",
                    ]);
                };
            });
        });
    }

    /**
     * Returns a new form for the specified users attribute.
     *
     * @param User        $user
     * @param string|null $attribute
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(User $user, $attribute = null)
    {
        return $this->form->of('active-directory.users.attributes', function (FormGrid $form) use ($user, $attribute) {

            if (is_null($attribute)) {
                $form->submit = 'Create';

                $form->fieldset(function (Fieldset $fieldset) {
                    $fieldset->control('input:text', 'name')
                        ->attributes(['placeholder' => 'Enter the attribute name.']);
                });
            } else {
                $form->submit = 'Save';

                $values = $user->getAttribute($attribute);

                $form->fieldset(function (Fieldset $fieldset) use ($attribute, $values) {
                    foreach ($values as $key => $value) {
                        $fieldset->control('input:text', function (Field $field) use ($attribute, $key, $value) {
                            $field->label = $attribute;
                            $field->name = sprintf('%s[]', $attribute);
                            $field->value = $value;
                        });
                    }
                });
            }
        });
    }

    /**
     * Returns a new navbar for the specified user attribute index.
     *
     * @param User $user
     *
     * @return \Illuminate\Support\Fluent
     */
    public function navbar(User $user)
    {
        return $this->fluent([
            'id'         => 'active-directory-users-attributes',
            'title'      => 'User Attributes',
            'url'        => route('active-directory.users.attributes.index', [$user->getAccountName()]),
            'menu'       => view('pages.active-directory.users.attributes._nav', compact('user')),
            'attributes' => [
                'class' => 'navbar-default',
            ],
        ]);
    }
}
