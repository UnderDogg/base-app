<?php

namespace App\Http\Presenters\ActiveDirectory;

use Adldap\Models\User;
use App\Http\Presenters\Presenter;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;
use Orchestra\Contracts\Html\Table\Column;
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
                $column->value = function (array $attributes) {
                    $values = $attributes[key($attributes)];

                    return HTML::ul($values, ['class' => 'list-unstyled']);
                };
            });
        });
    }
}
