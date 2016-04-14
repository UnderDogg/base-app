<?php

namespace App\Http\Presenters;

use Illuminate\Support\Fluent;
use Orchestra\Contracts\Html\Form\Factory as FormFactory;
use Orchestra\Contracts\Html\Table\Factory as TableFactory;

abstract class Presenter
{
    /**
     * Implementation of form contract.
     *
     * @var \Orchestra\Contracts\Html\Form\Factory
     */
    protected $form;

    /**
     * Implementation of table contract.
     *
     * @var \Orchestra\Contracts\Html\Table\Factory
     */
    protected $table;

    /**
     * The default amount of records to display per page.
     *
     * @var int
     */
    protected $perPage = 10;

    /**
     * Constructor.
     *
     * @param FormFactory  $form
     * @param TableFactory $table
     */
    public function __construct(FormFactory $form, TableFactory $table)
    {
        $this->form = $form;
        $this->table = $table;
    }

    /**
     * Returns a new Fluent instance.
     *
     * @param array $attributes
     *
     * @return Fluent
     */
    public function fluent(array $attributes = [])
    {
        return new Fluent($attributes);
    }
}
