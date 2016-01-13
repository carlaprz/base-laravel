<?php

return [
    'users' => [
        'name' => 'Usuarios',
        'for_files' => false,
        'description' => 'Administración de Usuarios',
        'editor' => false,
        'fields' => [
            'name' => [
                'type' => 'text',
                'title' => 'Nombre',
                'description' => 'Introduzca el Nombre.',
                'rules' => ['required']
            ],
            'email' => [
                'type' => 'text',
                'title' => 'Email',
                'description' => 'Introduzca el correo electrónico del usuario.',
                'rules' => ['required', 'email', 'unique:users,email,{unique:id}']
            ],
            'address' => [
                'type' => 'text',
                'title' => 'Dirección',
                'description' => 'Introduzca la dirección.',
                'rules' => ['required']
            ],
            'postalcode' => [
                'type' => 'text',
                'title' => 'Código postal',
                'description' => 'Introduzca el código postal',
                'rules' => ['required']
            ],
            'city' => [
                'type' => 'text',
                'title' => 'Ciudad',
                'description' => 'Introduzca el código postal',
                'rules' => ['required']
            ],
            'telephone' => [
                'type' => 'numeric',
                'title' => 'Telefono',
                'description' => 'Introduzca el numero de telefono',
                'rules' => ['required']
            ],
            'province' => [
                'type' => 'text',
                'title' => 'Provincia',
                'description' => 'Introduzca el nombre de la provincia',
                'rules' => ['required']
            ],
            'rol' => [
                'title' => '',
                'description' => '',
                'type' => 'hidden',
                'value' => 2,
                'rules' => ['required']
            ],
            'status' => [
                'type' => 'select',
                'title' => 'Estado',
                'description' => 'users_status',
                'rules' => ['required']
            ]
        ]
    ],
    'news' => [
        'name' => 'Noticias',
        'for_files' => true,
        'description' => 'Administración de Noticias',
        'editor' => true,
        'slug' => ['title'],
        'fields' => [
            'image' => [
                'type' => 'image_file',
                'title' => 'Image',
                'description' => 'Introduzca la imagen Principal de la noticia',
                'rules' => ['required']
            ],
            'order' => [
                'type' => 'numeric',
                'title' => 'Prioridad',
                'description' => 'Introduzca el orden en caso de destacar',
                'rules' => ['numeric']
            ],
            'publish' => [
                'type' => 'datetime',
                'title' => 'Fecha de publicacion',
                'description' => 'Introduzca la fecha de publicacion',
                'rules' => ['required', 'date_format:Y-m-d H:i']
            ],
            'active' => [
                'type' => 'radio',
                'title' => 'Activo',
                'description' => 'Estado',
                'rules' => ['required']
            ]
        ],
        'lenguages' => [
            'es' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Titulo',
                        'description' => 'Titulo',
                        'rules' => ['required', 'unique:news_translations,title,{unique:id},news_id,locale,es']
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => 'Descripción',
                        'description' => 'Descripcion',
                        'rules' => ['required']
                    ]
                ]
            ],
            'en' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Title',
                        'description' => 'Title',
                        'rules' => ['unique:news_translations,title,{unique:id},news_id,locale,en']
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => 'Description',
                        'description' => 'Description',
                        'rules' => ['required_with:title']
                    ]
                ]
            ]
        ]
    ],
    'categories' => [
        'name' => 'Categorias',
        'for_files' => false,
        'description' => 'Administración de Categorias',
        'editor' => false,
        'autocomplete' => ['meta_title' => 'title'],
        'slug' => ['title'],
        'fields' => [
            'parent' => [
                'type' => 'select',
                'title' => 'Categoria Padre',
                'description' => 'all_categories_parent',
            ],
            'active' => [
                'type' => 'radio',
                'title' => 'Activo',
                'description' => 'Estado',
                'rules' => []
            ]
        ],
        'lenguages' => [
            'es' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Nombre',
                        'description' => 'Nombre',
                        'rules' => ['required', 'unique:categories_translations,title,{unique:id},categories_id,locale,es,parent,{unique:parent}']
                    ],
                    'slug' => [
                        'type' => 'text',
                        'title' => 'Url amigable',
                        'description' => 'Url amigable,en caso de no completarlo se completara con el nombre.',
                        'rules' => ['required']
                    ],
                    'meta_title' => [
                        'type' => 'text',
                        'title' => 'Meta Titulo ',
                        'description' => 'Meta Titulo',
                        'rules' => []
                    ],
                    'meta_description' => [
                        'type' => 'textarea',
                        'title' => 'Meta Descripcion',
                        'description' => 'Meta Descripcion',
                        'rules' => []
                    ]
                ]
            ],
            'en' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Name',
                        'description' => 'Name',
                        'rules' => ['unique:categories_translations,title,{unique:id},categories_id,locale,en,parent,{unique:parent}']
                    ],
                    'slug' => [
                        'type' => 'text',
                        'title' => 'Friendly url',
                        'description' => 'Friendly url',
                        'rules' => ['required_with:title']
                    ],
                    'meta_title' => [
                        'type' => 'text',
                        'title' => 'Meta title',
                        'description' => 'Meta title',
                        'rules' => []
                    ],
                    'meta_description' => [
                        'type' => 'textarea',
                        'title' => 'Meta Description',
                        'description' => 'Meta Description',
                        'rules' => []
                    ]
                ]
            ]
        ]
    ],
    'products' => [
        'name' => 'Productos',
        'for_files' => true,
        'description' => 'Administración de Productos',
        'slug' => ['title'],
        'editor' => true,
        'fields' => [
            'active' => [
                'type' => 'radio',
                'title' => 'Activo',
                'description' => 'Estado',
                'rules' => ['required']
            ],
            'pvp' => [
                'type' => 'numeric',
                'title' => 'Precio del producto',
                'description' => 'Introduzca el precio del producto',
                'rules' => ['required']
            ],
            'pvp_discounted' => [
                'type' => 'numeric',
                'title' => 'Precio del producto descontado',
                'description' => 'Introduzca el precio descontado del producto en caso de que lo tenga',
                'rules' => []
            ],
            'iva' => [
                'type' => 'numeric',
                'title' => '% de impuesto',
                'description' => 'Introduzca el valor del impuesto en porcentaje',
                'rules' => []
            ],
            'category_id' => [
                'type' => 'select',
                'title' => 'Categoria',
                'description' => 'all_categories',
                'rules' => ['required']
            ],
            'image' => [
                'type' => 'image_file',
                'title' => 'Imagen para el detalle del producto',
                'description' => 'Introduzca la imagen del producto',
                'rules' => ['required']
            ],
            'thumb' => [
                'type' => 'image_file',
                'title' => 'Imagen para el listado de productos',
                'description' => 'Introduzca la imagen del producto para el listado',
                'rules' => ['required']
            ]
        ],
        'lenguages' => [
            'es' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Titulo',
                        'description' => 'Titulo del producto',
                        'rules' => ['required']
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => 'Descripción',
                        'description' => 'Descripcion',
                        'rules' => ''
                    ],
                    'slug' => [
                        'type' => 'text',
                        'title' => 'Url amigable',
                        'description' => 'Url amigable,en caso de no completarlo se completara con el nombre del producto.',
                        'rules' => ['required']
                    ]
                ]
            ],
            'en' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Title',
                        'description' => 'Titulo del producto',
                        'rules' => []
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => 'Description',
                        'description' => 'Descripcion',
                        'rules' => ['required_with:title']
                    ],
                    'slug' => [
                        'type' => 'text',
                        'title' => 'Friendly url',
                        'description' => 'Friendly url',
                        'rules' => ['required_with:title']
                    ]
                ]
            ]
        ],
    ],
    'orders' => [
        'name' => 'Ordenes de Compra',
        'for_files' => true,
        'description' => 'Administración de Ordenes de compra',
        'slug' => false,
        'editor' => false,
        'dataShow' => ['shipping'],
        'fields' => [
            'status' => [
                'type' => 'select',
                'title' => 'Estado',
                'description' => 'orders_status',
                'rules' => ['']
            ],
            'reference' => [
                'type' => 'textDisabled',
                'title' => 'Referencia',
                'description' => '',
                'rules' => ['']
            ],
            'pvpName' => [
                'type' => 'textDisabled',
                'title' => 'Método de pago',
                'description' => 'Metodo de pago',
                'rules' => ['']
            ],
            'total_pvp' => [
                'type' => 'numericDisabled',
                'title' => 'Total pvp',
                'description' => '',
                'rules' => ['']
            ],
            'total_iva' => [
                'type' => 'numericDisabled',
                'title' => 'Total IVA',
                'description' => '',
                'rules' => ['']
            ],
            'userNameLastName' => [
                'type' => 'textDisabled',
                'title' => 'Cliente',
                'description' => '',
                'rules' => []
            ],
        ],
        "shipping" => [
            'fields' => [
                'shipping_name' => [
                    'type' => 'textDisabled',
                    'title' => 'Nombre de envio',
                    'description' => '',
                    'rules' => ['']
                ],
                'shipping_lastname' => [
                    'type' => 'textDisabled',
                    'title' => 'Apellido de envio',
                    'description' => '',
                    'rules' => ['']
                ],
                'shipping_email' => [
                    'type' => 'textDisabled',
                    'title' => 'Email de envio',
                    'description' => '',
                    'rules' => ['']
                ],
                'shipping_telephone' => [
                    'type' => 'textDisabled',
                    'title' => 'Telefono de envio',
                    'description' => '',
                    'rules' => ['']
                ],
                'shipping_address' => [
                    'type' => 'textDisabled',
                    'title' => 'Dirreccion de envio',
                    'description' => '',
                    'rules' => ['']
                ],
                'shipping_postalcode' => [
                    'type' => 'textDisabled',
                    'title' => 'Codigo postal de envio',
                    'description' => '',
                    'rules' => ['']
                ],
                'shipping_city' => [
                    'type' => 'textDisabled',
                    'title' => 'Ciudad de envio',
                    'description' => '',
                    'rules' => ['']
                ],
                'shipping_province' => [
                    'type' => 'textDisabled',
                    'title' => 'Provincia de envio',
                    'description' => '',
                    'rules' => ['']
                ],
                'shipping_country_name' => [
                    'type' => 'textDisabled',
                    'title' => 'Pais de envio',
                    'description' => '',
                    'rules' => ['']
                ],
            ],
        ],  
    ],
    'payments' => [
        'name' => 'Métodos de pago',
        'for_files' => false,
        'description' => 'Administración de métodos de pago',
        'editor' => false,
        'fields' => [
            'name' => [
                'type' => 'text',
                'title' => 'Nombre',
                'description' => 'Introduce el nombre del método de pago',
                'rules' => ['required']
            ],
            'active' => [
                'type' => 'radio',
                'title' => 'Activo',
                'description' => 'Estado',
                'rules' => ['required']
            ]
        ]
    ],
    'coupons' => [
        'name' => 'Cupones de descuento',
        'for_files' => false,
        'description' => 'Administración de cupones de descuento',
        'editor' => false,
        'fields' => [
            'code' => [
                'type' => 'text',
                'title' => 'Código',
                'description' => 'Introduce el código de descuento',
                'rules' => ['required']
            ],
            'start' => [
                'type' => 'datetime',
                'title' => 'Fecha de inicio',
                'description' => 'Fecha en la que el descuento empieza a ser aplicable',
                'rules' => ['required']
            ],
            'end' => [
                'type' => 'datetime',
                'title' => 'Fecha de fin',
                'description' => 'Fecha en la que el descuento deja de ser aplicable',
                'rules' => ''
            ],
            'percentage' => [
                'type' => 'radio',
                'title' => 'Procentaje',
                'description' => 'Tipo de descuento',
                'rules' => ['required']
            ],
            'discount' => [
                'type' => 'numeric',
                'title' => 'Valor del descuento',
                'description' => 'Valor que se le descontará al cliente',
                'rules' => ['required']
            ],
            'active' => [
                'type' => 'radio',
                'title' => 'Activo',
                'description' => 'Estado del cupon',
                'rules' => ['required']
            ],
        ]
    ],
    'shippingZones' => [
        'name' => 'Zonas de envío',
        'for_files' => false,
        'description' => 'Administración de las zonas de envíos',
        'editor' => false,
        'fields' => [
            'name' => [
                'type' => 'text',
                'title' => 'Nombre',
                'description' => 'Introduce el nombre de la zona de envío',
                'rules' => ['required']
            ]
        ]
    ],
    'shippingCountries' => [
        'name' => 'Países de envío',
        'for_files' => false,
        'description' => 'Administración de países de envío',
        'editor' => false,
        'fields' => [
            'code' => [
                'type' => 'text',
                'title' => 'Código',
                'description' => 'Introduce el nombre del país de envío',
                'rules' => ['required']
            ],
            'name' => [
                'type' => 'text',
                'title' => 'Nombre',
                'description' => 'Introduce el nombre del país de envío',
                'rules' => ['required']
            ],
            'shipping_zone' => [
                'type' => 'select',
                'title' => 'Zone',
                'description' => 'all_zones',
                'rules' => ['required']
            ]
        ]
    ],
    'shippingCosts' => [
        'name' => 'Costes de envío',
        'for_files' => false,
        'description' => 'Administración de costes de envío',
        'editor' => false,
        'fields' => [
            'name' => [
                'type' => 'text',
                'title' => 'Nombre',
                'description' => 'Introduce el nombre del coste de envío',
                'rules' => ['required']
            ],
            'pvp' => [
                'type' => 'numeric',
                'title' => 'Precio',
                'description' => 'Introduce el precio del coste de envío',
                'rules' => ['required']
            ],
            'units' => [
                'type' => 'numeric',
                'title' => 'Unidades',
                'description' => 'Introduce las unidades tendrá el coste de envío',
                'rules' => ['required']
            ],
            'shipping_zone' => [
                'type' => 'select',
                'title' => 'Zona',
                'description' => 'all_zones',
                'rules' => ['required']
            ],
            'active' => [
                'type' => 'radio',
                'title' => 'Activo',
                'description' => 'Estado',
                'rules' => ['required']
            ]
        ]
    ],
    'payments' => [
        'name' => 'Métodos de pago',
        'for_files' => false,
        'description' => 'Administración de métodos de pago',
        'editor' => false,
        'fields' => [
            'name' => [
                'type' => 'text',
                'title' => 'Nombre',
                'description' => 'Introduce el nombre del método de pago',
                'rules' => ['required']
            ],
            'active' => [
                'type' => 'radio',
                'title' => 'Activo',
                'description' => 'Estado',
                'rules' => ['required']
            ]
        ]
    ],
];
