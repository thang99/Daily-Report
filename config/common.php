<?php
return [
    'status_user' => [
        'active' => 1,
        'disabled' => 0,
        'block' => -1
    ],

    'status_division' => [
        'active' => 1,
        'disabled' => 0,
        'deleted' => -1
    ],
    'status_position' => [
        'active' => 1,
        'disabled' => 0,
        'deleted' => -1,
    ],
    'status_report' => [
        'accept' => 1,
        'waiting' => 0,
        'reject' => -1,
    ],
    'status_follow' => [
        'on_follow' => 1,
        'un_follow' => 0,
    ],
    'role_user' => [
        'admin' => 'admin',
        'manager' => 'manager',
        'user' => 'user'
    ]
];
