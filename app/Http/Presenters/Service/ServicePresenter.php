<?php

namespace App\Http\Presenters\Service;

use App\Http\Presenters\Presenter;
use App\Models\Service;
use App\Models\ServiceRecord;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Column;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;
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
        $service = $service->with('records');

        return $this->table->of('services', function (TableGrid $table) use ($service) {
            $table->with($service)->paginate($this->perPage);

            $table->column('name', function (Column $column) {
                $column->value = function (Service $service) {
                    return link_to_route('services.records.index', $service->name, [$service->getKey()]);
                };
            });

            $table->column('last_record_status')
                ->label('Current Status');

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

    /**
     * Displays all services with their name and current status.
     *
     * @param Service $service
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function tableStatus(Service $service)
    {
        $service = $service->with('records');

        return $this->table->of('services.status', function (TableGrid $table) use ($service) {
            $table->with($service);

            $table->column('name', function (Column $column) {
                $column->value = function (Service $service) {
                    $last = $service->last_record;

                    if ($last instanceof ServiceRecord && policy($last)->show()) {
                        return link_to_route('services.records.show', $service->name, [$service->getKey(), $last->getKey()]);
                    }

                    return $service->name;
                };
            });

            $table->column('last_record_status')
                ->label('Current Status');
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
