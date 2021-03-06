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
        'order' => 'admin.news.order',
        'create' => 'admin.news.create',
        'edit' => 'admin.news.edit',
        'delete' => 'admin.news.delete',
        'crop' => 'admin.news.crop',
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
                'excel' => 'admin.products.excel',
                'crop' => 'admin.products.crop',
                'order' => 'admin.products.order',
                'name' => 'Productos',
            ],
            [
                'route' => 'admin.categories.index',
                'resource' => 'categories',
                'create' => 'admin.categories.create',
                'edit' => 'admin.categories.edit',
                'delete' => 'admin.categories.delete',
                'name' => 'Categorías',
            ],
            [
                'route' => 'admin.sizes.index',
                'resource' => 'sizes',
                'create' => 'admin.sizes.create',
                'edit' => 'admin.sizes.edit',
                'delete' => 'admin.sizes.delete',
                'name' => 'Tallas'
            ],
            [
                'route' => 'admin.colours.index',
                'resource' => 'colours',
                'create' => 'admin.colours.create',
                'edit' => 'admin.colours.edit',
                'delete' => 'admin.colours.delete',
                'name' => 'Colores'
            ]
        ],
    ],
    [
        'route' => 'admin.orders.index',
        'details' => 'admin.orders.details',
        'excel' => 'admin.orders.excel',
        'bill' => 'admin.orders.bill',
        'editstatus' => 'admin.orders.editstatus',
        'icon' => 'fa fa-shopping-cart',
        'name' => 'Pedidos',
        'resource' => 'orders'
    ],
    [
        'route' => 'admin.payments.index',
        'edit' => 'admin.payments.edit',
        'icon' => 'credit-card',
        'name' => 'Métodos de pago',
        'resource' => 'payments'
    ],
    [
        'dropdown' => true,
        'icon' => 'fa fa-truck',
        'name' => 'Gastos de envío',
        'childs' => [
            [
                'route' => 'admin.shippingCosts.index',
                'resource' => 'shippingCosts',
                'create' => 'admin.shippingCosts.create',
                'edit' => 'admin.shippingCosts.edit',
                'delete' => 'admin.shippingCosts.delete',
                'name' => 'Gastos de envío',
            ],
            [
                'route' => 'admin.shippingCountries.index',
                'resource' => 'shippingCountries',
                'create' => 'admin.shippingCountries.create',
                'edit' => 'admin.shippingCountries.edit',
                'delete' => 'admin.shippingCountries.delete',
                'name' => 'Países',
            ],
            [
                'route' => 'admin.shippingZones.index',
                'resource' => 'shippingZones',
                'create' => 'admin.shippingZones.create',
                'edit' => 'admin.shippingZones.edit',
                'delete' => 'admin.shippingZones.delete',
                'name' => 'Zonas'
            ]
        ],
    ],
    [
        'route' => 'admin.coupons.index',
        'create' => 'admin.coupons.create',
        'edit' => 'admin.coupons.edit',
        'delete' => 'admin.coupons.delete',
        'icon' => 'fa fa-gift',
        'name' => 'Cupones',
        'resource' => 'coupons'
    ],
    [
        'dropdown' => true,
        'icon' => 'fa fa-question',
        'name' => 'Faqs',
        'childs' => [
            [
                'route' => 'admin.faqs.index',
                'resource' => 'faqs',
                'create' => 'admin.faqs.create',
                'edit' => 'admin.faqs.edit',
                'delete' => 'admin.faqs.delete',
                'order' => 'admin.faqs.order',
                'name' => 'Faqs',
            ],
            [
                'route' => 'admin.faqsCategories.index',
                'resource' => 'faqsCategories',
                'create' => 'admin.faqsCategories.create',
                'edit' => 'admin.faqsCategories.edit',
                'delete' => 'admin.faqsCategories.delete',
                'order' => 'admin.faqsCategories.order',
                'name' => 'Categorías'
            ]
        ]
    ],
    [
        'route' => 'admin.banners.index',
        'create' => 'admin.banners.create',
        'edit' => 'admin.banners.edit',
        'delete' => 'admin.banners.delete',
        'order' => 'admin.banners.order',
        'icon' => 'fa fa-picture-o',
        'name' => 'Banners',
        'resource' => 'banners'
    ]
];
