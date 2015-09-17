<?php

// Welcome Page
$router->get('/', [
    'as' => 'welcome.index',
    'uses' => 'WelcomeController@index',
]);

// Auth Covered Routes
$router->group(['middleware' => ['auth']], function ($router)
{
    // Display all closed issues.
    $router->get('issues/closed', [
        'as' => 'issues.closed',
        'uses' => 'IssueController@closed',
    ]);

    // Close an Issue
    $router->post('issues/{issues}/close', [
        'as' => 'issues.close',
        'uses' => 'IssueController@close',
    ]);

    // Re-Open an Issue
    $router->post('issues/{issues}/open', [
        'as' => 'issues.open',
        'uses' => 'IssueController@open',
    ]);

    // The issue resource
    $router->resource('issues', 'IssueController');

    // The issue comments resource
    $router->resource('issues.comments', 'IssueCommentController', [
        'except' => [
            'index',
            'show',
        ],
    ]);

    // The issue labels resource
    $router->resource('issues.labels', 'IssueLabelController', [
        'only' => [
            'store',
        ],
    ]);
});

// Authentication Routes
$router->group(['prefix' => 'auth', 'as' => 'auth.'], function ($router)
{
    // Guest Auth Routes
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

    // Only Auth Routes
    $router->group(['middleware' => ['auth']], function($router)
    {
        $router->get('logout', [
            'as' => 'logout',
            'uses' => 'AuthController@getLogout',
        ]);
    });
});
