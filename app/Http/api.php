<?php

use Illuminate\Routing\Router;

/* @var Router $router */
$router->group(['middleware' => ['web'], 'prefix' => 'api/v1', 'as' => 'api.v1.'], function (Router $router) {

    // The Auth middleware group (Temporary Web middleware).
    $router->group(['middleware' => ['auth']], function (Router $router) {

        // Issues route group.
        $router->group(['namespace' => 'Issue'], function (Router $router) {
            // Issue Comments API resource.
            $router->resource('tickets.comments', 'IssueCommentController', [
                'names' => [
                    'index'     => 'issues.comments.index',
                    'create'    => 'issues.comments.create',
                    'store'     => 'issues.comments.store',
                    'show'      => 'issues.comments.show',
                    'edit'      => 'issues.comments.edit',
                    'update'    => 'issues.comments.update',
                    'destroy'   => 'issues.comments.destroy',
                ],
            ]);
        });

    });

});
