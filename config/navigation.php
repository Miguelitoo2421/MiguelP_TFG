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
        'roles' => ['admin'],
    ],

    [
        'name'  => 'Producers',
        'route' => 'producers.index',
        'roles' => ['admin'],
    ],

    [
        'name'  => 'Plays',
        'route' => 'plays.index',
        'roles' => ['admin'],
    ],

    [
        'name'  => 'Actors',
        'route' => 'actors.index',
        'roles' => ['admin'],
    ],

    [
        'name'  => 'Locations',
        'route' => 'locations.index',
        'roles' => ['admin'],
    ],

    [
        'name'  => 'Events',
        'route' => 'events.index',
        'roles' => ['admin'],
    ],

];
