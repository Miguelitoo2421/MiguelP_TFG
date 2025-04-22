<?php
// config/navigation.php

return [
    [
        'name'  => 'Dashboard',
        'route' => 'dashboard',
        'roles' => ['admin', 'user'],
    ],
    [
        'name'  => '',
        'route' => '',
        'roles' => ['admin', 'user'],
    ],
    [
        'name'  => 'Users',
        'route' => 'admin.users.index',
        'roles' => ['admin'],
    ],
    // aqui agregaremos mas enlaces cuando los tengamos.
];
