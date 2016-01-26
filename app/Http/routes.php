<?php

use Illuminate\Routing\Router;

/* @var Router $router */
$router->group(['middleware' => ['web']], function (Router $router) {
    // Welcome Page.
    $router->get('/', [
        'as'   => 'welcome.index',
        'uses' => 'WelcomeController@index',
    ]);

    // The resources route group. Unprotected by auth, but by policies.
    $router->group(['namespace' => 'Resource', 'prefix' => 'resources'], function (Router $router) {
        // The resources group.
        $router->group(['as' => 'resources.'], function (Router $router) {
            // The guides group.
            $router->group(['prefix' => 'guides', 'as' => 'guides.'], function (Router $router) {
                // The guide favorites route (guarded by auth).
                $router->get('favorites', [
                    'as'         => 'favorites',
                    'uses'       => 'GuideController@favorites',
                    'middleware' => ['auth'],
                ]);

                // The specific guides group.
                $router->group(['prefix' => '{guides}'], function (Router $router) {
                    // The guide favorite route (guarded by auth).
                    $router->get('favorite', [
                        'as'         => 'favorite',
                        'uses'       => 'GuideController@favorite',
                        'middleware' => ['auth'],
                    ]);

                    // The guide step images route.
                    $router->get('images', [
                        'as'   => 'images',
                        'uses' => 'GuideStepController@images',
                    ]);

                    // The guide step images upload route.
                    $router->post('images/upload', [
                        'as'   => 'images.upload',
                        'uses' => 'GuideStepController@upload',
                    ]);

                    // The guide steps group.
                    $router->group(['prefix' => 'steps/{steps}', 'as' => 'steps.'], function (Router $router) {
                        // The guide step image download route.
                        $router->get('images/{images}', [
                            'as'   => 'images.download',
                            'uses' => 'GuideStepImageController@download',
                        ]);

                        // The guide step delete route.
                        $router->delete('images/{images}', [
                            'as'   => 'images.destroy',
                            'uses' => 'GuideStepImageController@destroy',
                        ]);

                        // The guide step move route.
                        $router->post('move', [
                            'as'   => 'move.position',
                            'uses' => 'GuideStepController@move',
                        ]);
                    });
                });
            });
        });

        // The guides resource.
        $router->resource('guides', 'GuideController');

        // The guide steps resource.
        $router->resource('guides.steps', 'GuideStepController');
    });

// Auth Covered Routes.
    $router->group(['middleware' => ['auth']], function (Router $router) {
        $router->group(['namespace' => 'Profile', 'prefix' => 'profile', 'as' => 'profile.'], function (Router $router) {
            // The user profile details route.
            $router->get('/', [
                'as'   => 'show',
                'uses' => 'ProfileController@show',
            ]);

            // The user update details route.
            $router->post('/', [
                'as'   => 'update',
                'uses' => 'ProfileController@update',
            ]);

            // The user profile edit details route.
            $router->get('edit', [
                'as'   => 'edit',
                'uses' => 'ProfileController@edit',
            ]);

            // The profile avatar route group.
            $router->group(['prefix' => 'avatar'], function (Router $router) {
                // The profile avatar route.
                $router->get('/', [
                    'as'    => 'avatar',
                    'uses'  => 'AvatarController@change',
                ]);

                // The profile avatar change route.
                $router->post('change', [
                    'as'    => 'avatar.change',
                    'uses'  => 'AvatarController@update',
                ]);

                // The profile avatar download route.
                $router->get('download', [
                    'as'    => 'avatar.download',
                    'uses'  => 'AvatarController@download',
                ]);
            });

            // The profile password route group.
            $router->group(['prefix' => 'password'], function (Router $router) {
                // The user profile password route.
                $router->get('/', [
                    'as'   => 'password',
                    'uses' => 'PasswordController@change',
                ]);

                // The user profile change password route.
                $router->post('change', [
                    'as'   => 'password.change',
                    'uses' => 'PasswordController@update',
                ]);
            });
        });

        // The Devices namespace group.
        $router->group(['namespace' => 'Device', 'prefix' => 'devices'], function (Router $router) {
            // The drives resource.
            $router->resource('drives', 'DriveController');

            // The computers resource.
            $router->resource('computers', 'ComputerController');

            // The Devices group.
            $router->group(['as' => 'devices.'], function (Router $router) {
                // The Computer Device group.
                $router->group(['prefix' => 'computers/{computers}', 'as' => 'computers.'], function (Router $router) {
                    // View Computer Hard Disks.
                    $router->get('disks', [
                        'as'   => 'disks.index',
                        'uses' => 'ComputerDiskController@index',
                    ]);

                    // Sync Computer Hard Disks.
                    $router->post('disks/synchronize', [
                        'as'   => 'disks.sync',
                        'uses' => 'ComputerDiskController@synchronize',
                    ]);

                    // View Computer CPU usage.
                    $router->get('cpu', [
                        'as'   => 'cpu.index',
                        'uses' => 'ComputerCpuController@index',
                    ]);

                    // View Computer CPU usage (JSON).
                    $router->get('cpu/json', [
                        'as'   => 'cpu.json',
                        'uses' => 'ComputerCpuController@json',
                    ]);

                    // Edit Computer Access.
                    $router->get('access', [
                        'as'   => 'access.edit',
                        'uses' => 'ComputerAccessController@edit',
                    ]);

                    // Update Computer Access.
                    $router->post('access', [
                        'as'   => 'access.update',
                        'uses' => 'ComputerAccessController@update',
                    ]);

                    // Computer Status Check.
                    $router->post('status/check', [
                        'as'   => 'status.check',
                        'uses' => 'ComputerStatusController@check',
                    ]);
                });

                // The Drive Device group.
                $router->group(['prefix' => 'drives/{drives}', 'as' => 'drives.'], function (Router $router) {
                    $router->get('{path}', [
                        'as'   => 'show',
                        'uses' => 'DriveController@show',
                    ]);
                });
            });
        });

        // The PasswordFolder namespace group.
        $router->group(['namespace' => 'PasswordFolder'], function (Router $router) {
            // The Passwords group
            $router->group(['prefix' => 'passwords', 'as' => 'passwords.'], function (Router $router) {
                $router->group(['middleware' => ['passwords.gate']], function (Router $router) {
                    // Password Gate
                    $router->get('gate', [
                        'as'   => 'gate',
                        'uses' => 'GateController@gate',
                    ]);

                    // Password Gate Unlock
                    $router->post('gate/unlock', [
                        'as'   => 'gate.unlock',
                        'uses' => 'GateController@unlock',
                    ]);

                    // Password Gate Lock
                    $router->post('gate/lock', [
                        'as'   => 'gate.lock',
                        'uses' => 'GateController@lock',
                    ]);
                });

                // Password Setup Routes
                $router->group(['prefix' => 'setup'], function (Router $router) {
                    // Passwords Already Setup - Invalid Page
                    $router->get('invalid', [
                        'as'   => 'setup.invalid',
                        'uses' => 'SetupController@invalid',
                    ]);

                    // Password Setup Covered Routes
                    $router->group(['middleware' => ['passwords.setup']], function (Router $router) {
                        // Password Setup
                        $router->get('/', [
                            'as'   => 'setup',
                            'uses' => 'SetupController@start',
                        ]);

                        // Finish Password Setup
                        $router->post('setup', [
                            'as'   => 'setup.finish',
                            'uses' => 'SetupController@finish',
                        ]);
                    });
                });
            });

            // The password locked middleware route group.
            $router->group(['middleware' => ['passwords.locked']], function (Router $router) {
                // Change Password Folder Pin.
                $router->get('passwords/change-pin', [
                    'as'   => 'passwords.pin.change',
                    'uses' => 'PinController@change',
                ]);

                // Update Password Folder Pin.
                $router->post('passwords/change-pin', [
                    'as'   => 'passwords.pin.update',
                    'uses' => 'PinController@update',
                ]);

                // User Password Resource.
                $router->resource('passwords', 'PasswordController');
            });
        });

        // The inquiry router group.
        $router->group(['namespace' => 'Inquiry'], function (Router $router) {
            // The child category creation route.
            $router->get('requests/categories/create/{categories?}', [
                'uses'  => 'InquiryCategoryController@create',
                'as'    => 'inquiries.categories.create'
            ]);

            // The category index route.
            $router->get('requests/categories/{categories?}', [
                'uses' => 'InquiryCategoryController@index',
                'as' => 'inquiries.categories.index',
            ]);

            // The child category store route.
            $router->post('requests/categories/{categories?}', [
                'uses'  => 'InquiryCategoryController@store',
                'as'    => 'inquiries.categories.store',
            ]);

            // The category move route.
            $router->post('requests/categories/{categories}/move', [
                'uses' => 'InquiryCategoryController@move',
                'as' => 'inquiries.categories.move',
            ]);

            // The category resource.
            $router->resource('requests/categories', 'InquiryCategoryController', [
                'except' => ['index', 'create', 'store'],
                'names' => [
                    'show'      => 'inquiries.categories.show',
                    'edit'      => 'inquiries.categories.edit',
                    'update'    => 'inquiries.categories.update',
                    'destroy'   => 'inquiries.categories.destroy',
                ],
            ]);

            // Display all closed inquiries.
            $router->get('requests/closed', [
                'as'   => 'inquiries.closed',
                'uses' => 'InquiryController@closed',
            ]);

            // The inquiry resource (aliased to requests for ambiguity).
            $router->resource('requests', 'InquiryController', [
                'names' => [
                    'index'     => 'inquiries.index',
                    'create'    => 'inquiries.create',
                    'store'     => 'inquiries.store',
                    'show'      => 'inquiries.show',
                    'edit'      => 'inquiries.edit',
                    'update'    => 'inquiries.update',
                    'destroy'   => 'inquiries.destroy',
                ],
            ]);
        });

        // The issue router group.
        $router->group(['namespace' => 'Issue'], function (Router $router) {
            // Display all closed issues.
            $router->get('issues/closed', [
                'as'   => 'issues.closed',
                'uses' => 'IssueController@closed',
            ]);

            // Close an Issue.
            $router->post('issues/{issues}/close', [
                'as'   => 'issues.close',
                'uses' => 'IssueController@close',
            ]);

            // Re-Open an Issue.
            $router->post('issues/{issues}/open', [
                'as'   => 'issues.open',
                'uses' => 'IssueController@open',
            ]);

            // The issue resource.
            $router->resource('tickets', 'IssueController', [
                'names' => [
                    'index'     => 'issues.index',
                    'create'    => 'issues.create',
                    'store'     => 'issues.store',
                    'show'      => 'issues.show',
                    'edit'      => 'issues.edit',
                    'update'    => 'issues.update',
                    'destroy'   => 'issues.destroy',
                ],
            ]);

            // The issue comments resource.
            $router->resource('tickets.comments', 'IssueCommentController', [
                'except' => ['index', 'show'],
                'names'  => [
                    'create'    => 'issues.comments.create',
                    'store'     => 'issues.comments.store',
                    'edit'      => 'issues.comments.edit',
                    'update'    => 'issues.comments.update',
                    'destroy'   => 'issues.comments.destroy',
                ],
            ]);

            // The issue labels resource.
            $router->resource('tickets.labels', 'IssueLabelController', [
                'only'  => ['store'],
                'names' => [
                    'store' => 'issues.labels.store',
                ],
            ]);

            // The issue users resource.
            $router->resource('tickets.users', 'IssueUserController', [
                'only'  => ['store'],
                'names' => [
                    'store' => 'issues.users.store',
                ],
            ]);
        });

        // The labels resource.
        $router->resource('labels', 'LabelController', [
            'except' => ['show'],
        ]);

        // The active directory route group.
        $router->group(['namespace' => 'ActiveDirectory', 'prefix' => 'active-directory'], function (Router $router) {
            // The computers resource.
            $router->resource('computers', 'ComputerController', [
                'only' => ['index', 'store'],
            ]);

            // The users resource.
            $router->resource('users', 'UserController');

            // The user attributes resource.
            $router->resource('users.attributes', 'UserAttributeController', [
                'except' => ['show'],
            ]);

            // The questions resource.
            $router->resource('questions', 'QuestionController', [
                'except' => ['show'],
            ]);

            // Active Directory Routes.
            $router->group(['as' => 'active-directory.'], function (Router $router) {
                // Active Directory User Routes
                $router->group(['as' => 'users.'], function (Router $router) {
                    // Import an AD user.
                    $router->post('users/import', [
                        'as'   => 'import',
                        'uses' => 'UserController@import',
                    ]);
                });

                // Active Directory Computer Routes.
                $router->group(['as' => 'computers.'], function (Router $router) {
                    // Add all computers.
                    $router->post('add-all', [
                        'as'   => 'store.all',
                        'uses' => 'ComputerController@storeAll',
                    ]);
                });
            });
        });

        $router->group(['namespace' => 'ActiveDirectory', 'prefix' => 'security-questions', 'as' => 'security-questions.'], function (Router $router) {
            // Displays all the users security questions.
            $router->get('/', [
                'as'         => 'index',
                'uses'       => 'SetupQuestionController@index',
                'middleware' => 'security-questions.setup.finish',
            ]);

            // Cover security question routes with setup middleware.
            $router->group(['middleware' => 'security-questions.setup'], function (Router $router) {
                // Displays the security question setup pages per step.
                $router->get('setup', [
                    'as'   => 'setup.step',
                    'uses' => 'SetupQuestionController@setup',
                ]);

                // Saves the current security question.
                $router->post('setup/save', [
                    'as'   => 'setup.save',
                    'uses' => 'SetupQuestionController@save',
                ]);
            });

            // Displays the form to edit a security question.
            $router->get('{question}', [
                'as'   => 'edit',
                'uses' => 'SetupQuestionController@edit',
            ]);

            // Updates the specified security question.
            $router->post('{question}', [
                'as'   => 'update',
                'uses' => 'SetupQuestionController@update',
            ]);
        });
    });

// Authentication Routes.
    $router->group(['prefix' => 'auth', 'as' => 'auth.'], function (Router $router) {
        // Guest Auth Routes.
        $router->group(['middleware' => ['guest']], function (Router $router) {
            // Displays login page.
            $router->get('login', [
                'as'   => 'login.index',
                'uses' => 'AuthController@getLogin',
            ]);

            // Processes login.
            $router->post('login', [
                'as'   => 'login.perform',
                'uses' => 'AuthController@postLogin',
            ]);

            // The forgot password group.
            $router->group(['namespace' => 'ActiveDirectory', 'prefix' => 'forgot-password', 'as' => 'forgot-password.'], function (Router $router) {
                // Displays forgot password page.
                $router->get('/', [
                    'as'   => 'discover',
                    'uses' => 'ForgotPasswordController@discover',
                ]);

                // Processes finding the submitted user.
                $router->post('/', [
                    'as'   => 'find',
                    'uses' => 'ForgotPasswordController@find',
                ]);

                // Displays the users questions to reset the account password.
                $router->get('{token}', [
                    'as'   => 'questions',
                    'uses' => 'ForgotPasswordController@questions',
                ]);

                // Processes the users answers for their security questions.
                $router->post('{token}/answer', [
                    'as'   => 'answer',
                    'uses' => 'ForgotPasswordController@answer',
                ]);

                // Displays the form to reset the users password.
                $router->get('{token}/reset', [
                    'as'   => 'reset',
                    'uses' => 'ForgotPasswordController@reset',
                ]);

                // Processes changing the users password.
                $router->post('{token}/reset', [
                    'as'   => 'change',
                    'uses' => 'ForgotPasswordController@change',
                ]);
            });
        });

        // Only Auth Routes.
        $router->group(['middleware' => ['auth']], function (Router $router) {
            $router->get('logout', [
                'as'   => 'logout',
                'uses' => 'AuthController@getLogout',
            ]);
        });
    });
});
