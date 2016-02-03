<?php

namespace App\Http\Presenters\Service;

use App\Models\Service;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Column;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;
use App\Http\Presenters\Presenter;
use Orchestra\Support\Facades\HTML;

class ServicePresenter extends Presenter
{
    /**
     * Returns a new table for all services.
     *
     * @param Service $service
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(Service $service)
    {
        return $this->table->of('services', function (TableGrid $table) use ($service) {
            $table->with($service)->paginate($this->perPage);

            $table->column('name');

            $table->column('description', function (Column $column) {
                $column->value = function (Service $service) {
                    if ($service->description) {
                        return $service->description;
                    }

                    return HTML::create('em', 'None');
                };
            });
        });
    }

    public function tableStatus(Service $service)
    {
        $service = $service->with('records');

        return $this->table->of('services.status', function (TableGrid $table) use ($service) {
            $table->with($service);

            $table->column('name');

            $table->column('status', function (Column $column) {
                $column->value = function (Service $service) {
                    return $service->last_record_status;
                };
            });
        });
    }

    /**
     * Returns a new form for the specified service.
     *
     * @param Service $service
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(Service $service)
    {
        return $this->form->of('services', function (FormGrid $form) use ($service) {
            if ($service->exists) {
                $method = 'PATCH';
                $url = route('services.update', [$service->getKey()]);
            } else {
                $method = 'POST';
                $url = route('services.store', [$service->getKey()]);
            }

            $form->attributes(compact('method', 'url'));

            $form->with($service);

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset->control('input:text', 'name')
                    ->attributes([
                        'placeholder' => 'Enter the Service name.',
                    ]);

                $fieldset->control('input:text', 'description')
                    ->attributes([
                        'placeholder' => 'Enter the Service description.',
                    ]);
            });
        });
    }

    /**
     * Returns a new navbar for the issue index.
     *
     * @return \Illuminate\Support\Fluent
     */
    public function navbar()
    {
        return $this->fluent([
            'id'         => 'services',
            'title'      => 'Services',
            'url'        => route('services.index'),
            'menu'       => view('pages.services._nav'),
            'attributes' => [
                'class' => 'navbar-default',
            ],
        ]);
    }
}
