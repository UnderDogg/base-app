<?php

return [

    /*
    |----------------------------------------------------------------------
    | Default Error Message String
    |----------------------------------------------------------------------
    |
    | Set default error message string format for Orchestra\Form.
    |
    */

    'format' => '<span class="label label-danger">:message</span>',

    /*
    |----------------------------------------------------------------------
    | Default Submit Button String
    |----------------------------------------------------------------------
    |
    | Set default submit button string or language replacement key for
    | Orchestra\Form.
    |
    */

    'submit' => 'orchestra/foundation::label.submit',

    /*
    |----------------------------------------------------------------------
    | Default View Layout
    |----------------------------------------------------------------------
    |
    | Orchestra\Html\Form would require a View to parse the provided form
    | instance.
    |
    */

    'view' => 'components.form',

    /*
    |----------------------------------------------------------------------
    | Layout Configuration
    |----------------------------------------------------------------------
    |
    | Set default attributes for Orchestra\Html\Form.
    |
    */

    'templates' => [
        'input'      => ['class' => 'twelve columns input-with-feedback'],
        'password'   => ['class' => 'twelve columns input-with-feedback'],
        'select'     => ['class' => 'twelve columns input-with-feedback'],
        'textarea'   => ['class' => 'twelve columns input-with-feedback'],
        'checkboxes' => [],
    ],

    /*
    |----------------------------------------------------------------------
    | Presenter
    |----------------------------------------------------------------------
    |
    | Set default presenter class for Orchestra\Html\Form.
    |
    */

    'presenter' => 'Orchestra\Html\Form\BootstrapThreePresenter',

];
