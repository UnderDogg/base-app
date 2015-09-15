<?php

namespace App\Http\Presenters;

use Illuminate\Support\Fluent;
use Orchestra\Html\Form\Factory as FormFactory;
use Orchestra\Html\Table\Factory as TableFactory;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Form\Presenter as PresenterContract;

abstract class Presenter implements PresenterContract
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

    /**
     * Handles the form action URL.
     *
     * @param string $url
     *
     * @return string
     */
    public function handles($url)
    {
        return $url;
    }

    /**
     * {@inheritdoc}
     */
    public function setupForm(FormGrid $form)
    {
        $form->layout('components.form');
    }

    /**
     * Sets up a table grid.
     *
     * @param TableGrid $table
     */
    public function setupTable(TableGrid $table)
    {
        $table->layout('components.table');
    }
}
