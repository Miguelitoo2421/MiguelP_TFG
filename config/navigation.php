<?php
// config/navigation.php

return [

    [
        'name'  => 'Dashboard',
        'route' => 'dashboard',
        'roles' => ['admin', 'user'],
    ],

    [
        'name'  => 'Users',
        'route' => 'admin.users.index',
        'roles' => ['admin'],
    ],

    [
        'name'  => 'Characters',
        'route' => 'characters.index',
        'roles' => ['admin', 'user'],
    ],

    [
        'name'  => 'Producers',
        'route' => 'producers.index',
        'roles' => ['admin', 'user'],
    ],

    [
        'name'  => 'Plays',
        'route' => 'plays.index',
        'roles' => ['admin', 'user'],
    ],

    [
        'name'  => 'Actors',
        'route' => 'actors.index',
        'roles' => ['admin', 'user'],
    ],

    [
        'name'  => 'Locations',
        'route' => 'locations.index',
        'roles' => ['admin', 'user'],
    ],

    [
        'name'  => 'Events',
        'route' => 'events.index',
        'roles' => ['admin', 'user'],
    ],

];
