<?php

namespace App\Http\Presenters\Service;

use App\Http\Presenters\Presenter;
use App\Models\Service;
use App\Models\ServiceRecord;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;

class ServiceRecordPresenter extends Presenter
{
    /**
     * Returns a new table of all service records.
     *
     * @param HasMany $records
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(HasMany $records)
    {
        return $this->table->of('services.records', function (TableGrid $table) use ($records) {
            $table->with($records)->paginate($this->perPage);

            $table->column('status_label')
                ->label('Status');

            $table->column('title');

            $table->column('created_at_human')
                ->label('Created');
        });
    }

    /**
     * Returns a new form for the specified record.
     *
     * @param Service       $service
     * @param ServiceRecord $record
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(Service $service, ServiceRecord $record)
    {
        return $this->form->of('services.records', function (FormGrid $form) use ($service, $record) {
            if ($record->exists) {
                $method = 'PATCH';
                $url = route('services.records.update', [$service->getKey(), $record->getKey()]);

                $form->submit = 'Save';
            } else {
                $method = 'POST';
                $url = route('services.records.store', [$service->getKey(), $record->getKey()]);

                $form->submit = 'Create';
            }

            $form->attributes(compact('method', 'url'));

            $form->with($record);

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset->control('select', 'status')
                    ->options([
                        ServiceRecord::STATUS_ONLINE   => 'Online',
                        ServiceRecord::STATUS_DEGRADED => 'Degraded',
                        ServiceRecord::STATUS_OFFLINE  => 'Offline',
                    ]);

                $fieldset->control('input:text', 'title')
                    ->attributes([
                        'placeholder' => 'Enter the status title.',
                    ]);

                $fieldset->control('input:textarea', 'description')
                    ->attributes([
                        'placeholder'  => 'Enter the current status description.',
                        'data-provide' => 'markdown',
                    ]);
            });
        });
    }

    /**
     * Returns a new navbar for the service record index.
     *
     * @param Service $service
     *
     * @return \Illuminate\Support\Fluent
     */
    public function navbar(Service $service)
    {
        return $this->fluent([
            'id'         => 'services-records',
            'title'      => 'Service Records',
            'url'        => route('services.records.index', [$service->getKey()]),
            'menu'       => view('pages.services.records._nav', compact('service')),
            'attributes' => [
                'class' => 'navbar-default',
            ],
        ]);
    }
}
