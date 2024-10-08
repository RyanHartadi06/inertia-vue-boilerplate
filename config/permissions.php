<?php

return [
    [
        'name' => 'Authentication',
        'permissions' => [
            'view users',
            'edit users',
            'view roles',
            'edit roles',
        ]
    ], [
        'name' => 'Dashboard',
        'permissions' => [
            'view dashboard',
        ]
    ], [
        'name' => 'Periode',
        'permissions' => [
            'view periods',
            'create periods',
            'edit periods',
            'delete periods',
        ]
    ], [
        'name' => 'Satuan Indikator',
        'permissions' => [
            'view indicator units',
            'create indicator units',
            'edit indicator units',
            'delete indicator units',
        ]
    ], [
        'name' => 'Panduan',
        'permissions' => [
            'view guides',
            'create guides',
            'edit guides',
            'delete guides',
        ]
    ],
];
