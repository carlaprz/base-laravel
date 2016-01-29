<?php

return [
    'users' => [
        'admin' => true,
        'front' => true,
        'fb_connect' => true,
        'gp_connect' => true,
    ],
    'languages' => [
        [
            'locale' => 'es_ES',
            'code' => 'es',
            'name' => 'Español',
            'default' => 1
        ],
        [
            'locale' => 'en_EN',
            'code' => 'en',
            'name' => 'Ingles',
            'default' => 0
        ]
    ],
    'news' => true,
    'ecommerce' => [
        'categories' => true,
        'products' => true,
        'products_related' => true,
        'products_options' => [
            'size' => true,
            'colour' => true,
        ],
        'money' => [
           'multiple' => true
        ],
        'cart' => true,
        'cart_opcion' => [
            'shipping' => true,
            'coupons' => true
        ]
    ],
    'faqs' => true,
    'banners' => true,
];
