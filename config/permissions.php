<?php

return [
    'delimiter' => '|',

    'permissions' => [
      'manage_users',
      'access_momo_dashbaord'
    ],

    'permission_registrars' => [
      /*
      * your permission registrars - have permission constants
      */
      App\Permissions\ExamplePermissionRegistrar::class,
    ],

    
    'role_registrars' => [
      /*
      * your permission registrars - have permission constants
      */
      App\Roles\ExampleRoleRegistrar::class,
    ]
];