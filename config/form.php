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
                'description' => 'Introduzca el nombre.',
                'rules' => ['required']
            ],
            'lastname' => [
                'type' => 'text',
                'title' => 'Apellido',
                'description' => 'Introduzca los apellidos.',
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
                'description' => 'Introduzca la ciudad',
                'rules' => ['required']
            ],
            'telephone' => [
                'type' => 'numeric',
                'title' => 'Teléfono',
                'description' => 'Introduzca el número de teléfono',
                'rules' => ['required']
            ],
            'province' => [
                'type' => 'text',
                'title' => 'Provincia',
                'description' => 'Introduzca el nombre de la provincia',
                'rules' => ['required']
            ],
            'country_id' => [
                'type' => 'select',
                'title' => 'País',
                'description' => 'all_countries',
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
        'orderToShow' => ['lenguages', 'generals'],
        'editor' => true,
        'slug' => ['title'],
        'fields' => [
            'image' => [
                'type' => 'imageFile',
                'title' => 'Image',
                'description' => 'Introduzca la imagen principal de la noticia (100x100px)',
                'rules' => ['required']
            ],
            'publish' => [
                'type' => 'datetime',
                'title' => 'Fecha de publicación',
                'description' => 'Introduzca la fecha de publicación',
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
                        'title' => 'Título',
                        'description' => 'Título de la noticia',
                        'rules' => ['required', 'unique:news_translations,title,{unique:id},news_id,locale,es']
                    ],
                    'description' => [
                        'type' => 'text',
                        'title' => 'Descripción corta',
                        'type' => 'textarea',
                        'title' => 'Descripción corta de la noticia',
                        'description' => '',
                        'rules' => ['required']
                    ],
                    'content' => [
                        'type' => 'textarea',
                        'title' => 'Contenido',
                        'description' => 'Contenido de la noticia',
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
                        'type' => 'text',
                        'title' => 'Description',
                        'description' => 'Short text for preview the new',
                        'rules' => ['required_with:title']
                    ],
                    'content' => [
                        'type' => 'textarea',
                        'title' => 'Content',
                        'description' => 'Content of the new',
                        'rules' => ['required_with:title']
                    ]
                ]
            ]
        ]
    ],
    'news_crop' => [
        'name' => 'Noticias',
        'for_files' => true,
        'description' => 'Administración de Imagen de Noticia',
        'slug' => false,
        'editor' => false,
        'dataShow' => [],
        'fields' => [
            'image' => [
                'type' => 'imageCrop',
                'title' => 'Imagen',
                'description' => ''               
            ],
        ]
    ],
    'categories' => [
        'name' => 'Categorías',
        'for_files' => false,
        'description' => 'Administración de Categorías',
        'orderToShow' => ['generals', 'lenguages'],
        'editor' => false,
        'autocomplete' => ['meta_title' => 'title'],
        'slug' => ['title'],
        'fields' => [
            'parent' => [
                'type' => 'select',
                'title' => 'Categoría padre',
                'description' => 'all_categories_parent',
            ],
            'active' => [
                'type' => 'radio',
                'title' => 'Activo',
                'description' => 'Estado'
            ]
        ],
        'lenguages' => [
            'es' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Nombre de la categoria (ES) ',
                        'description' => 'Nombre',
                        'rules' => ['required', 'unique:categories_translations,title,{unique:id},categories_id,locale,es,parent,{unique:parent}']
                    ],
                    'slug' => [
                        'type' => 'text',
                        'title' => 'Url amigable (ES) ',
                        'description' => 'URL amigable para SEO,en caso de no completarlo se completara con el nombre.',
                        'rules' => ['required']
                    ],
                    'meta_title' => [
                        'type' => 'text',
                        'title' => 'Meta Titulo (ES) ',
                        'description' => 'Meta Titulo'
                    ],
                    'meta_description' => [
                        'type' => 'textarea',
                        'title' => 'Meta Descripcion (ES) ',
                        'description' => 'Meta Descripcion',
                        'title' => 'Meta Título (ES) ',
                        'description' => 'Introduzca Meta Título',
                        'rules' => []
                    ],
                    'meta_description' => [
                        'type' => 'textarea',
                        'title' => 'Meta Descripción (ES) ',
                        'description' => 'Introduzca Meta Descripción',
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
                        'title' => 'URL',
                        'description' => 'Friendly SEO URL',
                        'rules' => ['required_with:title']
                    ],
                    'meta_title' => [
                        'type' => 'text',
                        'title' => 'Meta title',
                        'description' => 'Meta title',
                        'description' => 'Insert Meta title',
                        'rules' => []
                    ],
                    'meta_description' => [
                        'type' => 'textarea',
                        'title' => 'Meta Description',
                        'description' => 'Meta Description',
                        'description' => 'Insert Meta Description',
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
        'orderToShow' => ['lenguages', 'generals', 'dataShow'],
        'dataShow' => ['currencies'],
        'slug' => ['title'],
        'editor' => false,
        'fields' => [
            'reference' => [
                'type' => 'text',
                'title' => 'Referencia',
                'description' => 'La referencia del producto',
                'rules' => ['required', 'unique:products,reference,{unique:id}']
            ],
            'active' => [
                'type' => 'radio',
                'title' => 'Activo',
                'description' => 'Estado',
                'rules' => ['required']
            ],
            'image' => [
                'type' => 'imageFile',
                'title' => 'Imagen para el detalle del producto (400x400)',
                'description' => 'Introduzca la imagen del producto',
                'rules' => ['required']
            ],
            /* 'pvp' => [
              'type' => 'numeric',
              'title' => 'Precio del producto en Euro',
              'description' => 'Introduzca el precio sin IVA del producto',
              'rules' => ['required']
              ],
              'pvp_discounted' => [
              'type' => 'numeric',
              'title' => 'Precio descontado del producto Euro',
              'description' => 'Introduzca el precio descontado del producto en caso de que lo tenga',
              'rules' => []
              ],
              'iva' => [
              'type' => 'numeric',
              'title' => '% de IVA en Euros',
              'description' => 'Introduzca el valor del impuesto en porcentaje',
              'rules' => []
              ], */
            'category_id' => [
                'type' => 'select',
                'title' => 'Categoria',
                'description' => 'all_categories',
                'rules' => ['required']
            ],
            'size_id' => [
                'type' => 'multipleSelect',
                'title' => 'Talla',
                'description' => 'all_sizes',
            //'rules' => ['array|exists:sizes,id']
            ],
            'colour_id' => [
                'type' => 'multipleSelect',
                'title' => 'Colores',
                'description' => 'all_colours',
            //'rules' => ['array|exists:colours,id']
            ],
            'product_id_related' => [
                'type' => 'multipleSelectProducts',
                'title' => 'Productos Relacionados',
                'description' => 'all_products_backend',
            ],
        ],
        'currencies' => [
            '1' => [
                'fields' => [
                    'pvp' => [
                        'type' => 'numeric',
                        'title' => 'Precio del producto en Euro',
                        'description' => 'Introduzca el precio sin IVA del producto',
                        'rules' => ['required', 'numeric']
                    ],
                    'pvp_discounted' => [
                        'type' => 'numeric',
                        'title' => 'Precio descontado del producto Euro',
                        'description' => 'Introduzca el precio descontado del producto en caso de que lo tenga',
                    ],
                    'iva' => [
                        'type' => 'numeric',
                        'title' => '% de IVA en Euros',
                        'description' => 'Introduzca el valor del impuesto en porcentaje',
                    ],
                ]
            ],
            '2' => [
                'fields' => [
                    'pvp' => [
                        'type' => 'numeric',
                        'title' => 'Precio del producto en Dolar',
                        'description' => 'Introduzca el precio sin IVA del producto',
                        'rules' => ['required', 'numeric']
                    ],
                    'pvp_discounted' => [
                        'type' => 'numeric',
                        'title' => 'Precio descontado del producto Dolar',
                        'description' => 'Introduzca el precio descontado del producto en caso de que lo tenga',
                    ],
                    'iva' => [
                        'type' => 'numeric',
                        'title' => '% de IVA en Dolar',
                        'description' => 'Introduzca el valor del impuesto en porcentaje',
                    ],
                ]
            ],
        ],
        'lenguages' => [
            'es' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Nombre del producto (ES)',
                        'description' => 'Introduzca nombre del producto',
                        'rules' => ['required', 'unique:products_translations,title,{unique:id},products_id,locale,es']
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => 'Introduzca descripción del producto (ES)',
                        'description' => 'Descripcion',
                    ],
                    'slug' => [
                        'type' => 'text',
                        'title' => 'Url Amigable del producto (ES)',
                        'description' => 'URL amigable para SEO. En caso de no completarlo se completara con el nombre del producto.',
                    ]
                ]
            ],
            'en' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Nombre del producto (EN)',
                        'description' => 'Insert name of the product',
                        'rules' => ['unique:products_translations,title,{unique:id},products_id,locale,en']
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => 'Descripción del producto (EN)',
                        'description' => 'Insert description of the product',
                        'rules' => ['required_with:title']
                    ],
                    'slug' => [
                        'type' => 'text',
                        'title' => 'Url Amigable del producto (EN)',
                        'description' => 'Friendly SEO URL',
                        'rules' => ['required_with:title']
                    ]
                ]
            ]
        ],
    ],
    'products_crop' => [
        'name' => 'Productos',
        'for_files' => true,
        'description' => 'Administración de Imagenes de productos',
        'slug' => false,
        'editor' => false,
        'dataShow' => [],
        'fields' => [
            'image' => [
                'type' => 'imageCrop',
                'title' => 'Imagen detalle',
                'description' => ''               
            ],
            'thumb' => [
                'type' => 'imageCrop',
                'title' => 'Imagen Listado',
                'description' => ''
            ]
        ]
    ],
    'sizes' => [
        'name' => 'Tallas',
        'for_files' => false,
        'description' => 'Administración de Tallas',
        'editor' => false,
        'autocomplete' => [],
        'slug' => [],
        'fields' => [
            'active' => [
                'type' => 'radio',
                'title' => 'Activo',
                'description' => 'Estado'
            ]
        ],
        'lenguages' => [
            'es' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Nombre',
                        'description' => 'Nombre',
                        'rules' => ['required', 'unique:sizes_translations,title,{unique:id},sizes_id,locale,es']
                    ]
                ]
            ],
            'en' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Name',
                        'description' => 'Name',
                        'rules' => ['unique:sizes_translations,title,{unique:id},sizes_id,locale,en']
                    ]
                ]
            ]
        ]
    ],
    'colours' => [
        'name' => 'Colores',
        'for_files' => false,
        'description' => 'Administración de Colores',
        'editor' => false,
        'autocomplete' => [],
        'slug' => [],
        'fields' => [
            'active' => [
                'type' => 'radio',
                'title' => 'Activo',
                'description' => 'Estado'
            ]
        ],
        'lenguages' => [
            'es' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Nombre',
                        'description' => 'Nombre',
                        'rules' => ['required', 'unique:colours_translations,title,{unique:id},colours_id,locale,es']
                    ]
                ]
            ],
            'en' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Name',
                        'description' => 'Name',
                        'rules' => ['unique:colours_translations,title,{unique:id},colours_id,locale,en']
                    ]
                ]
            ]
        ]
    ],
    'orders' => [
        'name' => 'Pedidos',
        'for_files' => true,
        'description' => 'Administración de Pedidos',
        'slug' => false,
        'editor' => false,
        'orderToShow' => [ 'generals', 'dataShow'],
        'dataShow' => [ 'products' ,'shipping'],
        'fields' => [
            'status' => [
                'type' => 'selectDisabled',
                'title' => 'Estado',
                'description' => 'orders_status'
            ],
            'reference' => [
                'type' => 'textDisabled',
                'title' => 'Código pedido',
                'description' => ''
            ],
            'paymentName' => [
                'type' => 'textDisabled',
                'title' => 'Método de pago',
                'description' => 'Método de pago'
            ],
            'paymentResponse' => [
                'type' => 'textDisabled',
                'title' => 'Respuesta del método de pago',
                'description' => 'Respuesta del método de pago'
            ],
            'total_pvp' => [
                'type' => 'numericDisabled',
                'title' => 'Importe total',
                'description' => ''
            ],
            'total_iva' => [
                'type' => 'numericDisabled',
                'title' => 'IVA',
                'description' => ''
            ],
            'userNameLastName' => [
                'type' => 'textDisabled',
                'title' => 'Cliente',
                'description' => ''
            ],
            'cupon_code' => [
                'type' => 'textDisabled',
                'title' => 'Cupón de descuento',
                'description' => ''
            ],
            'bill' => [
                'type' => 'radioDisabled',
                'title' => 'Factura',
                'description' => ''
            ],
            'products_cant_unit' => [
                'type' => 'textDisabled',
                'title' => 'Total de Productos',
                'description' => ''                
            ],
            'cant_products' => [
                'type' => 'hidden',
                'title' => '',
                'description' => ''
            ],
        ],
        "shipping" => [
            'fields' => [
                'shipping_name' => [
                    'type' => 'textDisabled',
                    'title' => 'Nombre',
                    'description' => ''                   
                ],
                'shipping_lastname' => [
                    'type' => 'textDisabled',
                    'title' => 'Apellido',
                    'description' => ''                   
                ],
                'shipping_email' => [
                    'type' => 'textDisabled',
                    'title' => 'Email',
                    'description' => ''                   
                ],
                'shipping_telephone' => [
                    'type' => 'textDisabled',
                    'title' => 'Teléfono',
                    'description' => ''                   
                ],
                'shipping_address' => [
                    'type' => 'textDisabled',
                    'title' => 'Dirección de envío',
                    'description' => ''                   
                ],
                'shipping_postalcode' => [
                    'type' => 'textDisabled',
                    'title' => 'Código postal de envío',
                    'description' => ''                   
                ],
                'shipping_city' => [
                    'type' => 'textDisabled',
                    'title' => 'Ciudad de envío',
                    'description' => ''                   
                ],
                'shipping_province' => [
                    'type' => 'textDisabled',
                    'title' => 'Provincia de envío',
                    'description' => ''                   
                ],
                'shipping_country_name' => [
                    'type' => 'textDisabled',
                    'title' => 'País de envío',
                    'description' => ''                   
                ],
            ],
        ],
        "products" => [
            "loop" => true,
            "fields" => [
                'link' => [
                    'type' => 'link',
                    'title' => 'Producto Link',
                    'description' => ''                   
                ],
                'product_description' => [
                    'type' => 'textDisabled',
                    'title' => 'Producto nombre',
                    'description' => ''                   
                ],
                'pvp' => [
                    'type' => 'textDisabled',
                    'title' => 'Precio',
                    'description' => ''                   
                ],
                'iva' => [
                    'type' => 'textDisabled',
                    'title' => 'iva',
                    'description' => ''                   
                ],
                'cant' => [
                    'type' => 'textDisabled',
                    'title' => 'Unidades',
                    'description' => ''                   
                ],
                'separacion' => [
                    'type' => 'line',
                    'title' => '',
                    'description' => ''                   
                ],
            ],
        ],
    ],
    'ordersStatus' => [
        'name' => 'Pedidos',
        'for_files' => true,
        'description' => 'Cambiar estado de pedido',
        'slug' => false,
        'editor' => false,
        'dataShow' => false,
        'fields' => [
            'status' => [
                'type' => 'select',
                'title' => 'Estado',
                'description' => 'orders_status',
               
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
                'description' => 'Introduzca el nombre del método de pago',
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
                'description' => 'Introduzca el código de descuento',
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
                'description' => 'Introduzca el nombre de la zona de envío',
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
                'description' => 'Introduzca el nombre del país de envío',
                'rules' => ['required']
            ],
            'name' => [
                'type' => 'text',
                'title' => 'Nombre',
                'description' => 'Introduzca el nombre del país de envío',
                'rules' => ['required']
            ],
            'shipping_zone' => [
                'type' => 'select',
                'title' => 'Zona',
                'description' => 'all_zones',
                'rules' => ['required']
            ]
        ]
    ],
    'shippingCosts' => [
        'name' => 'Costes de envío',
        'for_files' => false,
        'description' => 'Administración de gastos de envío',
        'dataShow' => ['currencies'],
        'editor' => false,
        'fields' => [
            'name' => [
                'type' => 'text',
                'title' => 'Nombre',
                'description' => 'Introduzca el nombre del gasto de envío',
                'rules' => ['required']
            ],
            'units' => [
                'type' => 'numeric',
                'title' => 'Unidades',
                'description' => 'Introduzca el numero de productos para este gasto de envío',
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
        ],
        'currencies' => [
            '1' => [
                'fields' => [
                    'pvp' => [
                        'type' => 'numeric',
                        'title' => 'Precio Euro',
                        'description' => 'Introduzca el precio del gasto de envío',
                        'rules' => ['required']
                    ],
                ]
            ],
            '2' => [
                'fields' => [
                    'pvp' => [
                        'type' => 'numeric',
                        'title' => 'Precio Dolar',
                        'description' => 'Introduzca el precio del gasto de envío',
                        'rules' => ['required']
                    ],
                ]
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
                'description' => 'Introduzca el nombre del método de pago',
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
    'banners' => [
        'name' => 'Banners',
        'for_files' => true,
        'description' => 'Administración de banners',
        'editor' => false,
        'fields' => [
            'name' => [
                'type' => 'text',
                'title' => 'Nombre',
                'description' => 'Introduzca el nombre del banner',
                'rules' => ['required']
            ],
            'text' => [
                'type' => 'text',
                'title' => 'Texto',
                'description' => 'Introduzca el texto del banner',
                'rules' => ''
            ],
            'link' => [
                'type' => 'text',
                'title' => 'Enlace',
                'description' => 'Enlace del banner',
                'rules' => ''
            ],
            'image' => [
                'type' => 'imageFileNoCrop',
                'title' => 'Imagen del banner',
                'description' => 'Imagen del banner. Deberá tener las medidas exactas especificadas por diseño (100x100px).',
                'rules' => ['required']
            ],
            'active' => [
                'type' => 'radio',
                'title' => 'Activo',
                'description' => 'Estado del banner',
                'rules' => ['required']
            ]
        ]
    ],
   
    'banners_crop' => [
        'name' => 'Banners',
        'for_files' => true,
        'description' => 'Administración de imágenes de banners',
        'slug' => false,
        'editor' => false,
        'dataShow' => [],
        'fields' => [
            'image' => [
                'type' => 'imageCrop',
                'title' => 'Imagen',
                'description' => '',
                'rules' => [''],
            ],
        ]
    ],
    'faqsCategories' => [
        'name' => 'Categorias de FAQs',
        'for_files' => false,
        'description' => 'Administración de Categorías de FAQs',
        'editor' => false,
        'fields' => [
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
                        'title' => 'Título',
                        'description' => 'Título de la categoría',
                        'rules' => ['required', 'unique:faqs_categories_translations,title,{unique:id},faqs_categories_id,locale,es']
                    ],
                    'description' => [
                        'type' => 'text',
                        'title' => 'Descripcion',
                        'description' => 'Descripcion de la categoría',
                        'rules' => []
                    ]
                ]
            ],
            'en' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Name',
                        'description' => 'Name of the category',
                        'rules' => ['unique:faqs_categories_translations,title,{unique:id},faqs_categories_id,locale,en']
                    ],
                    'descriptiton' => [
                        'type' => 'text',
                        'title' => 'Description',
                        'description' => 'Description of the category',
                        'rules' => []
                    ]
                ]
            ]
        ]
    ],
    'faqs' => [
        'name' => 'FAQs',
        'for_files' => false,
        'description' => 'Administración de FAQs',
        'editor' => true,
        'fields' => [
            'active' => [
                'type' => 'radio',
                'title' => 'Activo',
                'description' => 'Estado',
                'rules' => ['required']
            ],
            'faqs_categories_id' => [
                'type' => 'select',
                'title' => 'Categoría',
                'description' => 'all_faqs_categories',
                'rules' => ['required']
            ]
        ],
        'lenguages' => [
            'es' => [
                'fields' => [
                    'question' => [
                        'type' => 'text',
                        'title' => 'Pregunta',
                        'description' => 'Introduzca la pregunta',
                        'rules' => ['required', 'unique:faqs_translations,question,{unique:id},faqs_id,locale,es']
                    ],
                    'answer' => [
                        'type' => 'textarea',
                        'title' => 'Respuesta',
                        'description' => 'Introduzca la respuesta',
                        'rules' => ['required']
                    ]
                ]
            ],
            'en' => [
                'fields' => [
                    'question' => [
                        'type' => 'text',
                        'title' => 'Question',
                        'description' => 'Insert the name of the question',
                        'rules' => ['unique:faqs_translations,question,{unique:id},faqs_id,locale,en']
                    ],
                    'answer' => [
                        'type' => 'text',
                        'title' => 'Answer',
                        'description' => 'Insert the answer of the question',
                        'rules' => ['required_with:title']
                    ]
                ]
            ]
        ]
    ]
];
