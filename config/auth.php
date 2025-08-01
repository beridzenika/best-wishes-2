<?php

return [

    'throttle' => [
        /*
        |--------------------------------------------------------------------------
        | Enable throttling of Backend authentication attempts
        |--------------------------------------------------------------------------
        |
        | If set to true, users will be given a limited number of attempts to sign
        | in to the Backend before being blocked for a specified number of minutes.
        |
         */
        'enabled' => true,

        /*
        |--------------------------------------------------------------------------
        | Failed Authentication Attempt Limit
        |--------------------------------------------------------------------------
        |
        | Number of failed attempts allowed while trying to authenticate a user.
        |
         */
        'attemptLimit' => 5,

        /*
        |--------------------------------------------------------------------------
        | Suspension Time
        |--------------------------------------------------------------------------
        |
        | The number of minutes to suspend further attempts on authentication once
        | the attempt limit is reached.
        |
         */
        'suspensionTime' => 15,
    ],

    'defaults' => [
        'guard' => env('AUTH_DEFAULT_GUARD', 'web'),
        'passwords' => env('AUTH_DEFAULT_PASSWORDS', 'users'),
    ],
    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */
    'guards' => [
        'web' => [
            'driver' => env('AUTH_GUARDS_WEB_DRIVER', 'session'),
            'provider' => env('AUTH_GUARDS_WEB_PROVIDER', 'users'),
        ],
        'api' => [
            'driver' => env('AUTH_GUARDS_API_DRIVER', 'token'),
            'provider' => env('AUTH_GUARDS_API_PROVIDER', 'users'),
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */
    'providers' => [
        'users' => [
            'driver' => env('AUTH_PROVIDERS_USERS_DRIVER', 'eloquent'),
            'model' => env('AUTH_PROVIDERS_USERS_MODEL', '\RainLab\User\Models\User'),
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Here you may set the options for resetting passwords including the view
    | that is your password reset e-mail. You may also set the name of the
    | table that maintains all of the reset tokens for your application.
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */
    'passwords' => [
        'users' => [
            'provider' => env('AUTH_PASSWORDS_USERS_PROVIDER', 'users'),
            'email' => env('AUTH_PASSWORDS_USERS_EMAIL', 'auth.emails.password'),
            'table' => env('AUTH_PASSWORDS_USERS_TABLE', 'password_resets'),
            'expire' => env('AUTH_PASSWORDS_USERS_EXPIRE', 60),
        ],
    ],

    'UserID'    => null,
    'UserType'  => null,
    'Token'     => null

];
