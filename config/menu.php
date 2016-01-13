<?php

return [
    [
        'route' => 'admin.users.index',
        'create' => 'admin.users.create',
        'edit' => 'admin.users.edit',
        'delete' => 'admin.users.delete',
        'icon' => 'fa fa-user',
        'name' => 'Usuarios',
        'resource' => 'users'
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
        'dropdown' => true,
        'icon' => 'fa fa-tag',
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
        'route' => 'admin.orders.index',
        'details' => 'admin.orders.details',
        'icon' => 'fa fa-shopping-cart',
        'name' => 'Ordenes de Compra',
        'resource' => 'orders'
    ],
    [
        'route' => 'admin.payments.index',       
        'edit' => 'admin.payments.edit',
        'icon' => 'fa fa-credit-card',
        'name' => 'Metodos de pago',
        'resource' => 'payments'
    ],
    [
        'dropdown' => true,
        'icon' => 'fa fa-road',
        'name' => 'Gastos de envio',
        'childs' => [
            [
                'route' => 'admin.shippingZones.index',
                'resource' => 'shippingZones',
                'create' => 'admin.shippingZones.create',
                'edit' => 'admin.shippingZones.edit',
                'delete' => 'admin.shippingZones.delete',
                'name' => 'Zonas'                
            ],
            [
                'route' => 'admin.shippingCountries.index',
                'resource' => 'shippingCountries',
                'create' => 'admin.shippingCountries.create',
                'edit' => 'admin.shippingCountries.edit',
                'delete' => 'admin.shippingCountries.delete',
                'name' => 'Paises',
            ],
            [
                'route' => 'admin.shippingCosts.index',
                'resource' => 'shippingCosts',
                'create' => 'admin.shippingCosts.create',
                'edit' => 'admin.shippingCosts.edit',
                'delete' => 'admin.shippingCosts.delete',
                'name' => 'Gastos de envio',
            ]
        ],
    ],
    [
        'route' => 'admin.coupons.index',
        'create' => 'admin.coupons.create',
        'edit' => 'admin.coupons.edit',
        'delete' => 'admin.coupons.delete',
        'icon' => 'fa fa-gift',
        'name' => 'Coupons',
        'resource' => 'coupons'
    ],
    [
        'dropdown' => true,
        'icon' => 'fa fa-question',
        'name' => 'Faqs',
        'childs' => [
            [
                'route' => 'admin.faqsCategories.index',
                'resource' => 'faqsCategories',
                'create' => 'admin.faqsCategories.create',
                'edit' => 'admin.faqsCategories.edit',
                'delete' => 'admin.faqsCategories.delete',
                'name' => 'Categorias'                
            ],
            [
                'route' => 'admin.faqs.index',
                'resource' => 'faqs',
                'create' => 'admin.faqs.create',
                'edit' => 'admin.faqs.edit',
                'delete' => 'admin.faqs.delete',
                'name' => 'Faqs',
            ]            
        ]
    ]
];
