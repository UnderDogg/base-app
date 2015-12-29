<?php

namespace App\Http\Presenters\Profile;

use Orchestra\Support\Facades\HTML;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use App\Models\User;
use App\Http\Presenters\Presenter;

class AvatarPresenter extends Presenter
{
    public function form(User $user)
    {
        return $this->form->of('profile.avatar', function (FormGrid $form) use ($user) {
            $form->with($user);

            $form->attributes([
                'url' => route('profile.avatar.change'),
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
                    ->label(($user->hasAvatar() ? 'Replace Image(s)' : 'Image'));

                $fieldset->control('input:checkbox', 'generate')
                    ->label('Generate me an Avatar')
                    ->attributes([
                        'class' => 'switch-mark'
                    ]);
            });
        });
    }
}
