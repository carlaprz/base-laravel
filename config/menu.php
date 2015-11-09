<?php

return [
    [
        'dropdown' => true,
        'icon' => 'fa fa-shopping-cart',
        'name' => 'Productos',
        'childs' => [
            [
                'route' => 'admin.products.index',
                'resource' => 'products',
                'create' => 'admin.products.create',
                'edit' => 'admin.products.edit',
                'delete' => 'admin.products.delete',
                'name' => 'Productos',
                'icon' => 'fa fa-shopping-cart',
            ],
            [
                'route' => 'admin.categories.index',
                'resource' => 'categories',
                'create' => 'admin.categories.create',
                'edit' => 'admin.categories.edit',
                'delete' => 'admin.categories.delete',
                'name' => 'Categorías',
                'icon' => 'fa fa-align-left',
            ]
        ],
    ],
    [
        'route' => 'admin.jobs.index',
        'create' => 'admin.jobs.create',
        'edit' => 'admin.jobs.edit',
        'delete' => 'admin.jobs.delete',
        'icon' => 'fa fa-users',
        'name' => 'Bolsa de trabajos',
        'resource' => 'jobs'
    ],
    [
        'route' => 'admin.news.index',
        'create' => 'admin.news.create',
        'edit' => 'admin.news.edit',
        'delete' => 'admin.news.delete',
        'icon' => 'fa fa-bullhorn',
        'name' => 'Noticias',
        'resource' => 'news'
    ],
     [
        'route' => 'admin.users.index',
        'create' => 'admin.users.create',
        'edit' => 'admin.users.edit',
        'delete' => 'admin.users.delete',
        'icon' => 'fa fa-user',
        'name' => 'Usuarios',
        'resource' => 'users'
    ]
];
