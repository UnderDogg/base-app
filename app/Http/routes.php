<?php

// Welcome Page
$router->get('/', [
    'as' => 'welcome.index',
    'uses' => 'WelcomeController@index',
]);

// Auth Covered Routes.
$router->group(['middleware' => ['auth']], function ($router)
{
    // The Devices namespace group.
    $router->group(['namespace' => 'Device', 'prefix' => 'devices'], function ($router)
    {
        $router->resource('computers', 'ComputerController');

        // The devices group.
        $router->group(['as' => 'devices.'], function ($router)
        {

        });
    });

    // The PasswordFolder namespace group.
    $router->group(['namespace' => 'PasswordFolder'], function ($router)
    {
        // The Passwords group
        $router->group(['prefix' => 'passwords', 'as' => 'passwords.'], function ($router)
        {
            $router->group(['middleware' => ['passwords.gate']], function ($router)
            {
                // Password Gate
                $router->get('gate', [
                    'as' => 'gate',
                    'uses' => 'GateController@gate',
                ]);

                // Password Gate Unlock
                $router->post('gate/unlock', [
                    'as' => 'gate.unlock',
                    'uses' => 'GateController@unlock',
                ]);

                // Password Gate Lock
                $router->post('gate/lock', [
                    'as' => 'gate.lock',
                    'uses' => 'GateController@lock',
                ]);
            });

            // Password Setup Routes
            $router->group(['prefix' => 'setup'], function ($router)
            {
                // Passwords Already Setup - Invalid Page
                $router->get('invalid', [
                    'as' => 'setup.invalid',
                    'uses' => 'SetupController@invalid',
                ]);

                // Password Setup Covered Routes
                $router->group(['middleware' => ['passwords.setup']], function ($router)
                {
                    // Password Setup
                    $router->get('/', [
                        'as' => 'setup',
                        'uses' => 'SetupController@start',
                    ]);

                    // Finish Password Setup
                    $router->post('setup', [
                        'as' => 'setup.finish',
                        'uses' => 'SetupController@finish',
                    ]);
                });
            });
        });

        $router->group(['middleware' => ['passwords.locked']], function ($router)
        {
            // User Password Resource
            $router->resource('passwords', 'PasswordController');
        });
    });

    // Display all closed issues.
    $router->get('issues/closed', [
        'as' => 'issues.closed',
        'uses' => 'IssueController@closed',
    ]);

    // Close an Issue.
    $router->post('issues/{issues}/close', [
        'as' => 'issues.close',
        'uses' => 'IssueController@close',
    ]);

    // Re-Open an Issue.
    $router->post('issues/{issues}/open', [
        'as' => 'issues.open',
        'uses' => 'IssueController@open',
    ]);

    // The issue resource.
    $router->resource('issues', 'IssueController');

    // The issue comments resource.
    $router->resource('issues.comments', 'IssueCommentController', [
        'except' => ['index', 'show'],
    ]);

    // The issue labels resource.
    $router->resource('issues.labels', 'IssueLabelController', [
        'only' => ['store'],
    ]);

    // The issue users resource.
    $router->resource('issues.users', 'IssueUserController', [
        'only' => ['store'],
    ]);

    // The labels resource.
    $router->resource('labels', 'LabelController', [
        'except' => ['show']
    ]);

    // The active directory route group.
    $router->group(['prefix' => 'active-directory', 'namespace' => 'ActiveDirectory'], function ($router)
    {
        // The computers resource.
        $router->resource('computers', 'ComputerController', [
            'only' => ['index', 'store']
        ]);

        // The users resource.
        $router->resource('users', 'UserController', [
            'only' => ['index', 'store']
        ]);

        // Active Directory Routes
        $router->group(['as' => 'active-directory.'], function ($router)
        {
            // Active Directory Computer Routes
            $router->group(['as' => 'computers.'], function ($router)
            {
                // Add all computers.
                $router->post('add-all', [
                    'as' => 'store.all',
                    'uses' => 'ComputerController@storeAll',
                ]);
            });
        });
    });
});

// Authentication Routes.
$router->group(['prefix' => 'auth', 'as' => 'auth.'], function ($router)
{
    // Guest Auth Routes.
    $router->group(['middleware' => ['guest']], function ($router)
    {
        $router->get('login', [
            'as' => 'login.index',
            'uses' => 'AuthController@getLogin',
        ]);

        $router->post('login', [
            'as' => 'login.perform',
            'uses' => 'AuthController@postLogin',
        ]);
    });

    // Only Auth Routes.
    $router->group(['middleware' => ['auth']], function($router)
    {
        $router->get('logout', [
            'as' => 'logout',
            'uses' => 'AuthController@getLogout',
        ]);
    });
});
