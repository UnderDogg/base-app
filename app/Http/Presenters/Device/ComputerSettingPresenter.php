<?php

namespace App\Http\Presenters\Device;

use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use App\Models\Computer;
use App\Http\Presenters\Presenter;

class ComputerSettingPresenter extends Presenter
{
    public function form(Computer $computer)
    {
        return $this->form->of('computers.settings', function (FormGrid $form) use ($computer)
        {
            $form->setup($this, route('devices.computers.settings.update', [$computer->getKey()]), $computer);

            $form->submit = 'Save';

            $form->fieldset(function (Fieldset $fieldset) use ($computer)
            {
                if ($computer->access) {
                    $ad = $computer->access->active_directory;
                    $wmi = $computer->access->wmi;
                } else {
                    $ad = false;
                    $wmi = false;
                }

                $fieldset->control('input:checkbox', 'Exists in Active Directory?')
                    ->attributes([
                        'class'     => 'switch-mark',
                        ($ad ? 'checked' : null)
                    ])
                    ->name('active_directory')
                    ->value(1);

                $fieldset->control('input:checkbox', 'Can be accessed through WMI?')
                    ->attributes([
                        'class'     => 'switch-mark',
                        ($wmi ? 'checked' : null)
                    ])
                    ->name('wmi')
                    ->value(1);
            });
        });
    }
}
