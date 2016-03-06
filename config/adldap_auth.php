<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Username Attribute
    |--------------------------------------------------------------------------
    |
    | The username attribute is an array of the html input name and the LDAP
    | attribute to discover the user by. The reason for this is to hide
    | the attribute that you're using to login users.
    |
    | For example, if your input name is `username` and you'd like users
    | to login by their `samaccountname` attribute, then keep the
    | configuration below. However, if you'd like to login users
    | by their emails, then change `samaccountname` to `mail`.
    | and `username` to `email`.
    |
    */

    'username_attribute' => ['email' => 'mail'],

     /*
     |--------------------------------------------------------------------------
     | Limitation Filter
     |--------------------------------------------------------------------------
     |
     | The limitation filter allows you to enter a raw filter to only allow
     | specific users / groups / ous to authenticate.
     |
     | This should be a standard LDAP filter.
     |
     */

    'limitation_filter' => env('ADLDAP_LIMITATION_FILTER'),

    /*
    |--------------------------------------------------------------------------
    | Login Fallback
    |--------------------------------------------------------------------------
    |
    | The login fallback option allows you to login as a user located on the
    | local database if active directory authentication fails.
    |
    | Set this to true if you would like to enable it.
    |
    */

    'login_fallback' => env('ADLDAP_LOGIN_FALLBACK', true),

    /*
    |--------------------------------------------------------------------------
    | Password Key
    |--------------------------------------------------------------------------
    |
    | The password key is the name of the input array key located inside
    | the user input array given to the auth driver.
    |
    | Change this if you change your password fields input name.
    |
    */

    'password_key' => 'password',

    /*
    |--------------------------------------------------------------------------
    | Login Attribute
    |--------------------------------------------------------------------------
    |
    | The login attribute is the name of the active directory user property
    | that you use to log users in. For example, if your company uses
    | email, then insert `mail`.
    |
    */

    'login_attribute' => env('ADLDAP_LOGIN_ATTRIBUTE', 'samaccountname'),

    /*
    |--------------------------------------------------------------------------
    | Windows Auth Attribute (SSO)
    |--------------------------------------------------------------------------
    |
    | The windows authentication attribute is the name of the server variable
    | that is filled when SSO authentication is performed.
    |
    | This is only used in conjunction with the Adldap\Laravel\Middleware\WindowsAuthenticate
    | middleware.
    |
    | If your using Windows authentication this attribute must be named `AUTH_USER`.
    |
    | If your using Apache, this attribute must be named `REMOTE_USER`.
    |
    | The key of the array is what the user will be discovered from in LDAP.
    |
    */

    'windows_auth_attribute' => ['samaccountname' => 'AUTH_USER'],

    /*
    |--------------------------------------------------------------------------
    | Bind User to Model
    |--------------------------------------------------------------------------
    |
    | The bind User to Model option allows you to access the Adldap user model
    | instance on your laravel database model to be able run operations
    | or retrieve extra attributes on the Adldap user model instance.
    |
    | If this option is true, you must insert the trait:
    |
    |   `Adldap\Laravel\Traits\AdldapUserModelTrait`
    |
    | Onto your User model configured in `config/auth.php`.
    |
    | Then use `Auth::user()->adldapUser` to access.
    |
    */

    'bind_user_to_model' => env('ADLDAP_BIND_USER_TO_MODEL', false),

    /*
    |--------------------------------------------------------------------------
    | Sync Attributes
    |--------------------------------------------------------------------------
    |
    | Attributes specified here will be added / replaced on the user model
    | upon login, automatically synchronizing and keeping the attributes
    | up to date.
    |
    | The array key represents the Laravel model key, and the value
    | represents the Active Directory attribute to set it to.
    |
    | The users email is already synchronized and does not need to be
    | added to this array.
    |
    */

    'sync_attributes' => [

        'name' => 'cn',

    ],

    /*
    |--------------------------------------------------------------------------
    | Select Attributes
    |--------------------------------------------------------------------------
    |
    | Attributes to select upon the user on authentication and binding.
    |
    | If no attributes are given inside the array, all attributes on the
    | user are selected.
    |
    | ** Note ** : Keep in mind you must include attributes that you would
    | like to synchronize, as well as your login attribute.
    |
    */

    'select_attributes' => [

        //

    ],

];
