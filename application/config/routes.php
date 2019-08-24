<?php

return [
    //MainController
    '' => [
        'controller' => 'main',
        'action' => 'index',
    ],
    //AccountController
    'account/login' => [
        'controller' => 'account',
        'action' => 'login',
    ],

    'account/register' => [
        'controller' => 'account',
        'action' => 'register',
    ],

    'account/logout' => [
        'controller' => 'account',
        'action' => 'logout',
    ],

    'account/recovery' => [
        'controller' => 'account',
        'action' => 'recovery',
    ],

    'account/reset' => [
        'controller' => 'account',
        'action' => 'reset',
    ],

    'account/edit' => [
        'controller' => 'account',
        'action' => 'edit',
    ],

    'photo' => [
        'controller' => 'photo',
        'action' => 'photo',
    ],

];