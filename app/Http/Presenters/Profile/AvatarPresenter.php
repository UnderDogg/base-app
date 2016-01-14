<?php

namespace App\Http\Presenters\Profile;

use App\Http\Presenters\Presenter;
use App\Models\User;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Support\Facades\HTML;

class AvatarPresenter extends Presenter
{
    /**
     * Creates a new form for changing the current users avatar.
     *
     * @param User $user
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(User $user)
    {
        return $this->form->of('profile.avatar', function (FormGrid $form) use ($user) {
            $form->with($user);

            $form->attributes([
                'url'   => route('profile.avatar.change'),
                'files' => true,
            ]);

            $form->submit = 'Save';

            $form->fieldset(function (Fieldset $fieldset) use ($user) {
                if ($user->hasAvatar()) {
                    $fieldset->control('input:text', 'remove', function ($control) {
                        $control->label = 'Your Current Avatar';

                        // Generate a field for removing images from the current step.
                        $control->field = function () {
                            // Generate the url of the image.
                            $url = route('profile.avatar.download');

                            // Generate the HTML image tag
                            $photo = HTML::image($url, null, ['class' => 'img-responsive']);

                            // Return the result as raw HTML.
                            return HTML::raw("<div class='col-xs-6 col-sm-4 col-md-2 text-center'>$photo</div>");
                        };
                    });
                }

                $fieldset->control('input:file', 'image')
                    ->label(($user->hasAvatar() ? 'Replace Image' : 'Image'))
                    ->help('Selecting an image will delete your current avatar!');

                $fieldset->control('input:checkbox', 'generate')
                    ->label('Generate me an Avatar')
                    ->help('The generated avatar will be a random color with your initials.')
                    ->attributes([
                        'class' => 'switch-mark',
                    ]);
            });
        });
    }
}
