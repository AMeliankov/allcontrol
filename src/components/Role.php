<?php

class Role
{
    const role = [

        'admin' => [
            'index' => 'workers',
            0 => 'workers/view/',
            1 => 'workers/edit',
            2 => 'workers/add',
            3 => 'workers/print',
            4 => 'workers/delete',
            6 => 'info/exit//',
            7 => 'info',
            8 => 'table',
            9 => 'money/close/',
            10 => 'money/delete/',
            11 => 'money/add',
            12 => 'money',
            13 => 'users/add',
            14 => 'users/edit/',
            15 => 'users/delete/',
            16 => 'users',
            17 => 'security',
        ],

        'moderator' => [
            'index' => 'workers',
            0 => 'workers/view/',
            1 => 'workers/edit',
            2 => 'workers/add',
            3 => 'workers/print',
            4 => 'info',
            5 => 'table',
        ],

        'security' => [
            'index' => 'security',
            0 => 'info/exit//',
            1 => 'info',
        ],

        'view' => [
            'index' => 'workers',
            0 => 'workers/view/',
            1 => 'info',
            2 => 'table',
            3 => 'money',
        ],
    ];
}
