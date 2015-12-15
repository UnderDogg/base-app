<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authorization Policies
    |--------------------------------------------------------------------------
    |
    | Here you can register your authorization policies.
    |
    | The key represents the model and the value represents the policy.
    |
    */

    'policies' => [

        \App\Models\Issue::class            => \App\Policies\IssuePolicy::class,
        \App\Models\Comment::class          => \App\Policies\CommentPolicy::class,
        \App\Models\Label::class            => \App\Policies\LabelPolicy::class,
        \App\Models\Computer::class         => \App\Policies\Device\ComputerPolicy::class,
        \App\Models\Guide::class            => \App\Policies\Resource\GuidePolicy::class,
        \App\Models\GuideStep::class        => \App\Policies\Resource\GuideStepPolicy::class,
        \Adldap\Models\Computer::class      => \App\Policies\ActiveDirectory\ComputerPolicy::class,
        \Adldap\Models\User::class          => \App\Policies\ActiveDirectory\UserPolicy::class,

    ],

];
