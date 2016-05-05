<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            Middleware\PjaxMiddleware::class,
            \Adldap\Laravel\Middleware\WindowsAuthenticate::class,
        ],

        'api' => [
            'throttle:60,1',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'              => Middleware\Authenticate::class,
        'auth.basic'        => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest'             => Middleware\RedirectIfAuthenticated::class,
        'throttle'          => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'passwords.locked'  => Middleware\PasswordFolderLocked::class,
        'passwords.setup'   => Middleware\PasswordFolderSetup::class,
        'passwords.gate'    => Middleware\PasswordGate::class,
        'admin.setup'       => \App\Http\Middleware\SetupMiddleware::class,
        'admin.auth'        => \App\Http\Middleware\AdminAuthMiddleware::class,
        'permission'        => \Larapacks\Authorization\Middleware\PermissionMiddleware::class,
        'role'              => \Larapacks\Authorization\Middleware\RoleMiddleware::class,
    ];
}
