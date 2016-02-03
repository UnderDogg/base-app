<?php

namespace App\Http\Presenters\Service;

use App\Models\ServiceRecord;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Http\Presenters\Presenter;

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

            $table->column('title');
            $table->column('description');
        });
    }

    /**
     * Returns a new form for the specified record.
     *
     * @param ServiceRecord $record
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(ServiceRecord $record)
    {
        return $this->form->of('services.records', function (FormGrid $form) use ($record) {
            $form->with($record);

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset->control('select', 'status')
                    ->options([
                        ServiceRecord::STATUS_ONLINE => 'Online',
                        ServiceRecord::STATUS_DEGRADED => 'Degraded',
                        ServiceRecord::STATUS_OFFLINE => 'Offline',
                    ]);

                $fieldset->control('input:text', 'title');

                $fieldset->control('input:textarea', 'description')
                    ->attributes([
                        'placeholder' => 'Enter the current status description.',
                        'data-provide' => 'markdown',
                    ]);
            });
        });
    }
}
