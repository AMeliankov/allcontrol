<?php

return [

    /*
     * WorkersController
     */
    'workers/view/([0-9]+)' => 'workers/view/$1',
    'workers/edit' => 'workers/edit',
    'workers/add' => 'workers/add',
    'workers/print' => 'workers/print',
    'workers/delete' => 'workers/delete',
    'workers' => 'workers/index',

    /*
     * SecurityController
     */
    'security' => 'security/index',

    /*
     * InfoControleer
     */
    'info/exit/([0-9]+)/([0-9]+)' => 'info/exit/$1/$2',
    'info' => 'info/index',

    /*
     * TableController
     */
    'table' => 'table/index',

    /*
     * MoneyControler
     */
    'money/close/([0-9]+)' => 'money/close/$1',
    'money/delete/([0-9]+)' => 'money/delete/$1',
    'money/add' => 'money/add',
    'money' => 'money/index',

    /*
     * UserController
     */
    'users/add' => 'users/add',
    'users/edit/([0-9]+)' => 'users/edit/$1',
    'users/delete/([0-9]+)' => 'users/delete/$1',
    'users' => 'users/index',
    'login' => 'users/login',
    'exit' => 'users/exit',
    '' => 'users/login',
];
