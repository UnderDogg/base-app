<?php

namespace App\Http\Presenters;

use App\Models\Comment;
use Closure;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;

class CommentPresenter extends Presenter
{
    /**
     * Returns a new form for the specified comment.
     *
     * @param Comment      $comment
     * @param Closure|null $closure
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(Comment $comment, Closure $closure = null)
    {
        return $this->form->of('comment', function (FormGrid $form) use ($comment, $closure) {
            $form->with($comment);

            $form->fieldset(function (Fieldset $fieldset) {
                $fieldset->control('input:textarea', 'content')
                    ->label('Comment')
                    ->attributes([
                        'placeholder'  => 'Leave a comment',
                        'data-provide' => 'markdown',
                        'id'           => 'comment',
                    ]);
            });

            if ($closure instanceof Closure) {
                call_user_func($closure, $form, $comment);
            }
        });
    }
}
