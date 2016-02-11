<?php

namespace App\Http;

use Orchestra\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            Middleware\VerifyCsrfToken::class,
            Middleware\WindowsAuthenticate::class,
        ],

        'orchestra' => [
            'web',
            \Orchestra\Foundation\Http\Middleware\LoginAs::class,
            \Orchestra\Foundation\Http\Middleware\UseBackendTheme::class,
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
        'auth'                            => Middleware\Authenticate::class,
        'auth.basic'                      => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'backend'                         => \Orchestra\Foundation\Http\Middleware\UseBackendTheme::class,
        'can'                             => \Orchestra\Foundation\Http\Middleware\Can::class,
        'guest'                           => Middleware\RedirectIfAuthenticated::class,
        'throttle'                        => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'passwords.locked'                => Middleware\PasswordFolderLocked::class,
        'passwords.setup'                 => Middleware\PasswordFolderSetup::class,
        'passwords.gate'                  => Middleware\PasswordGate::class,
        'security-questions.setup'        => Middleware\ActiveDirectory\Questions\AlreadySetupMiddleware::class,
        'security-questions.setup.finish' => Middleware\ActiveDirectory\Questions\MustSetupMiddleware::class,
    ];
}
