<?php

namespace App\Http\Presenters\Resource;

use App\Http\Presenters\Presenter;
use App\Models\Guide;
use App\Models\GuideStep;
use Orchestra\Contracts\Html\Form\Field;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;
use Orchestra\Support\Facades\HTML;

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
        return $this->form->of('resources.guides.steps', function (FormGrid $form) use ($guide, $step) {
            if ($step->exists) {
                $method = 'patch';
                $url = route('resources.guides.steps.update', [$guide->slug, $step->getPosition()]);

                $form->submit = 'Save';
            } else {
                $method = 'post';
                $url = route('resources.guides.steps.store', [$guide->slug]);

                $form->submit = 'Create';
            }

            $files = true;

            $form->attributes(compact('method', 'url', 'files'));

            $form->with($step);

            $form->layout('pages.resources.guides.steps._form');

            $form->fieldset(function (Fieldset $fieldset) use ($guide, $step) {
                $hasImage = (count($step->images) > 0);

                foreach ($step->images as $image) {
                    $fieldset->control('input:text', 'remove', function ($control) use ($guide, $step, $image) {
                        $control->label = 'Image(s)';

                        // Generate a field for removing images from the current step.
                        $control->field = function () use ($guide, $step, $image) {
                            // Generate the url of the image.
                            $url = route('resources.guides.steps.images.download', [$guide->slug, $step->id, $image->uuid]);

                            // Generate the HTML image tag
                            $photo = HTML::image($url, null, ['class' => 'img-responsive']);

                            // Generate the button for deleting the current image.
                            $button = HTML::link(route('resources.guides.steps.images.destroy', [$guide->slug, $step->id, $image->uuid]), 'Delete', [
                                'class'        => 'btn btn-danger',
                                'data-post'    => 'DELETE',
                                'data-title'   => 'Delete Image?',
                                'data-message' => 'Are you sure you want to delete this image?',
                            ]);

                            // Return the result as raw HTML.
                            return HTML::raw("<div class='col-md-6 text-center'>$photo <br> $button</div>");
                        };
                    });
                }

                $fieldset->control('input:file', 'image')
                    ->label(($hasImage ? 'Replace Image(s)' : 'Image'));

                $fieldset
                    ->control('input:text', 'title')
                    ->attributes([
                        'placeholder' => 'Enter the step title',
                    ]);

                $fieldset
                    ->control('input:textarea', 'description')
                    ->attributes([
                        'placeholder' => 'Enter the step description',
                    ]);
            });
        });
    }

    /**
     * Returns a new form to upload multiple images to the specified guide.
     *
     * @param Guide $guide
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function formImages($guide)
    {
        return $this->form->of('resources.guides.images', function (FormGrid $form) use ($guide) {
            $attributes = [
                'files'  => true,
                'method' => 'POST',
                'url'    => route('resources.guides.images.upload', [$guide->slug]),
            ];

            $form->attributes($attributes);

            $form->submit = 'Upload';

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset->control('input:file', 'images[]', function (Field $field) {
                    $field->label = 'Images';

                    $field->attributes([
                        'id'       => 'images',
                        'multiple' => true,
                    ]);
                });
            });
        });
    }

    /**
     * Returns a new table of the guide steps.
     *
     * @param Guide $guide
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(Guide $guide)
    {
        $steps = $guide->steps()->orderBy('position');

        return $this->table->of('resources.guides', function (TableGrid $table) use ($guide, $steps) {
            $table->with($steps);

            $table->layout('pages.resources.guides.steps._table');

            $table->column('move')
                ->attributes(function (GuideStep $step) {
                    return [
                        'class'   => 'sortable-handle',
                        'data-id' => $step->id,
                    ];
                })
                ->value(function () {
                    return '<i class="fa fa-sort"></i>';
                });

            $table->column('Step', 'position')
                ->attributes(function () {
                    return ['class' => 'position'];
                });

            $table
                ->column('title')
                ->value(function (GuideStep $step) use ($guide) {
                    return link_to_route('resources.guides.steps.edit', $step->title, [$guide->slug, $step->getPosition()]);
                });

            $table
                ->column('description')
                ->value(function (GuideStep $step) {
                    return $step->description ? str_limit($step->description, 25) : '<em>None</em>';
                });

            $table->column('delete')
                ->value(function (GuideStep $step) use ($guide) {
                    $attribues = [
                        'class'        => 'btn btn-sm btn-danger',
                        'data-title'   => 'Delete Step?',
                        'data-message' => 'Are you sure you want to delete this step?',
                        'data-post'    => 'DELETE',
                    ];

                    return link_to_route('resources.guides.steps.destroy', 'Delete', [$guide->slug, $step->getPosition()], $attribues);
                });
        });
    }

    /**
     * Returns a new navbar for the guide step index.
     *
     * @param Guide $guide
     *
     * @return \Illuminate\Support\Fluent
     */
    public function navbar(Guide $guide)
    {
        return $this->fluent([
            'id'         => 'guide-steps',
            'title'      => 'Guide Steps',
            'url'        => route('resources.guides.steps.index', [$guide->slug]),
            'menu'       => view('pages.resources.guides.steps._nav', compact('guide')),
            'attributes' => [
                'class' => 'navbar-default',
            ],
        ]);
    }
}
