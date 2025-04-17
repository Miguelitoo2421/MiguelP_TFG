<?php
// config/navigation.php

return [
    [
        'name'  => 'Dashboard',
        'route' => 'dashboard',
        'roles' => ['admin', 'user'],
    ],
    [
        'name'  => 'Profile',
        'route' => 'profile.edit',
        'roles' => ['admin', 'user'],
    ],
    // aqui agregaremos mas enlaces cuando los tengamos.
];
