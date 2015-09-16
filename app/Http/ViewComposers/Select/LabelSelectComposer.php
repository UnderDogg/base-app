<?php

namespace App\Http\ViewComposers\Select;

use Illuminate\Contracts\View\View;
use App\Models\Label;
use App\Http\ViewComposers\Composer;

class LabelSelectComposer extends Composer
{
    /**
     * Constructor.
     *
     * @param Label $label
     */
    public function __construct(Label $label)
    {
        $this->label = $label;
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $labels = $this->label->all();

        $view->with('labels', $labels);
    }
}
