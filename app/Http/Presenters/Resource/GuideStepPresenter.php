<?php

namespace App\Http\Presenters\Resource;

use App\Models\Guide;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use App\Models\GuideStep;
use App\Http\Presenters\Presenter;

class GuideStepPresenter extends Presenter
{
    /**
     * Returns a new form of the guide step.
     *
     * @param Guide     $guide
     * @param GuideStep $step
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(Guide $guide, GuideStep $step)
    {
        return $this->form->of('resources.guides.steps', function (FormGrid $form) use ($guide, $step)
        {
            $attributes = [
                'files' => true
            ];

            if ($step->exists) {
                $route = route('resources.guides.steps.update', [$guide->slug, $step->getKey()]);
                $attributes['method'] = 'POST';

                $form->submit = 'Update Step';
            } else {
                $route = route('resources.guides.steps.store', [$guide->slug]);
                $attributes['method'] = 'PATCH';

                $form->submit = 'Add Step';
            }

            $form->setup($this, $route, $step, $attributes);

            $form->fieldset(function (Fieldset $fieldset)
            {
                $fieldset->control('input:text', 'title')
                    ->attributes([
                        'placeholder' => 'Enter the step title',
                    ]);

                $fieldset->control('input:textarea', 'description')
                    ->attributes([
                        'placeholder' => 'Enter the step description',
                    ]);
            });
        });
    }
}
