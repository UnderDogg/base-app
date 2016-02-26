<?php

/*
|--------------------------------------------------------------------------
| Administration Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the administration routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['prefix' => 'admin', 'middleware' => ['web']], function () {
    Route::get('/', [
        'as'         => 'admin.welcome.index',
        'uses'       => 'WelcomeController@index',
        'middleware' => ['admin.auth'],
    ]);

    // The administration setup group.
    Route::group(['prefix' => 'setup', 'as' => 'admin.setup.', 'middleware' => ['admin.setup']], function () {
        // The administration begin setup route.
        Route::get('/', [
            'as'    => 'welcome',
            'uses'  => 'SetupController@welcome',
        ]);

        Route::get('begin', [
            'as'   => 'begin',
            'uses' => 'SetupController@begin',
        ]);

        // The administration finish setup route.
        Route::post('finish', [
            'as'    => 'finish',
            'uses'  => 'SetupController@finish',
        ]);
    });

    Route::group(['middleware' => ['admin.auth']], function () {
        // The users resource.
        Route::resource('users', 'UserController');

        // The user permissions resource.
        Route::resource('users.permissions', 'UserPermissionController', [
            'only' => ['store', 'destroy'],
        ]);

        // The roles resource.
        Route::resource('roles', 'RoleController');

        // The role users resource.
        Route::resource('roles.users', 'RoleUserController', [
            'only' => ['store', 'destroy'],
        ]);

        // The role permissions resource.
        Route::resource('roles.permissions', 'RolePermissionController', [
            'only' => ['store', 'destroy'],
        ]);

        // The permissions resource.
        Route::resource('permissions', 'PermissionController');

        // The permission roles resource.
        Route::resource('permissions.roles', 'PermissionRoleController', [
            'only' => ['store', 'destroy'],
        ]);

        // The permission users resource.
        Route::resource('permissions.users', 'PermissionUserController', [
            'only' => ['store', 'destroy'],
        ]);
    });

    // The 'admin' route prefixed group.
    Route::group(['as' => 'admin.'], function () {
        // Guest Middleware group for login routes.
        Route::group(['middleware' => ['guest']], function () {
            // Administration login view.
            Route::get('auth/login', [
                'as'    => 'auth.login',
                'uses'  => 'AuthController@getLogin',
            ]);

            // Administration post login view.
            Route::post('auth/login', [
                'as'    => 'auth.login',
                'uses'  => 'AuthController@postLogin',
            ]);
        });

        // Administration logout.
        Route::get('auth/logout', [
            'as'            => 'auth.logout',
            'uses'          => 'AuthController@getLogout',
            'middleware'    => ['admin.auth'],
        ]);
    });

});
