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
                'rules' => ['required','email','unique:users,email']
            ],
            /*'password' => [
                'type' => 'text',
                'title' => 'Contraseña',
                'description' => 'Introduzca la contraseña del usuario.',
                'rules' => ['required']
            ],*/
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
        'fields' => [
            'image' => [
                'type' => 'image_file',
                'title' => 'Image:',
                'description' => 'Introduzca la imagen Principal de la noticia',
                'rules' => ['required']
            ],
            'active' => [
                'type' => 'radio',
                'title' => 'Activo',
                'description' => 'Estado',
                'rules' => ''
            ]
        ],
        'lenguages' => [
            'es' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Titulo',
                        'description' => 'Titulo',
                        'rules' => 'required'
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => 'Descripcion',
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
                        'rules' => ''
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => 'Description',
                        'description' => 'Description',
                        'rules' => ''
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
                'rules' => ''
            ]
        ],
        'lenguages' => [
            'es' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Nombre',
                        'description' => 'Nombre',
                        'rules' => ['required']
                    ],
                    'meta_title' => [
                        'type' => 'text',
                        'title' => 'Meta Titulo ',
                        'description' => 'Meta Titulo',
                        'rules' => ''
                    ],
                    'meta_description' => [
                        'type' => 'textarea',
                        'title' => 'Meta Descripcion',
                        'description' => 'Meta Descripcion',
                        'rules' => ''
                    ]
                ]
            ],
            'en' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Name',
                        'description' => 'Name',
                        'rules' => ''
                    ],
                    'meta_title' => [
                        'type' => 'text',
                        'title' => 'Meta title ',
                        'description' => 'Meta title',
                        'rules' => ''
                    ],
                    'meta_description' => [
                        'type' => 'textarea',
                        'title' => 'Meta Description',
                        'description' => 'Meta Description',
                        'rules' => ''
                    ]
                ]
            ]
        ]
    ],
    'products' => [
        'name' => 'Productos',
        'for_files' => true,
        'description' => 'Administración de Productos',
        'slug' => false,
        'editor' => true,
        'fields' => [
            'active' => [
                'type' => 'radio',
                'title' => 'Activo',
                'description' => 'Estado',
                'rules' => ''
            ],
            'category_id' => [
                'type' => 'select',
                'title' => 'Categoria',
                'description' => 'all_categories',
                'rules' => ['required']
            ],
            'image' => [
                'type' => 'image_file',
                'title' => 'Image:',
                'description' => 'Introduzca la imagen del producto',
                'rules' => ['required']
            ],
            'thumb' => [
                'type' => 'image_file',
                'title' => 'Thumb para el listado:',
                'description' => 'Introduzca la imagen del producto para el listado',
                'rules' => ['required']
            ],
            'pvp' => [
                'type' => 'numeric',
                'title' => 'Precio del producto:',
                'description' => 'Introduzca el precio del producto',
                'rules' => ['required']
            ],
            'pvp_discounted' => [
                'type' => 'numeric',
                'title' => 'Precio del producto descontado:',
                'description' => 'Introduzca el precio descontado del producto en caso de que lo tenga',
                'rules' => ''
            ],
            'iva' => [
                'type' => 'numeric',
                'title' => '% de impuesto:',
                'description' => 'Introduzca el valor del impuesto en porcentaje',
                'rules' => ''
            ]
        ],
        'lenguages' => [
            'es' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'title',
                        'description' => 'Titulo del producto',
                        'rules' => ['required']
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => 'description',
                        'description' => 'Descripcion',
                        'rules' => ''
                    ],
                    'slug' => [
                        'type' => 'text',
                        'title' => 'Slug',
                        'description' => 'Caracteristicas Tecnicas',
                        'rules' => ['required']
                    ]
                ]
            ],
            'en' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'title',
                        'description' => 'Titulo del producto',
                        'rules' => ''
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => 'description',
                        'description' => 'Descripcion',
                        'rules' => ''
                    ],
                    'slug' => [
                        'type' => 'text',
                        'title' => 'Slug',
                        'description' => 'Caracteristicas Tecnicas',
                        'rules' => ['required']
                    ]
                ]
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
    
    'cupons' => [
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
            'date_start' => [
                'type' => 'datetime',
                'title' => 'Fecha de inicio',
                'description' => 'Fecha en la que el descuento empieza a ser aplicable',
                'rules' => ['required']
            ],
            'date_end' => [
                'type' => 'datetime',
                'title' => 'Fecha de fin',
                'description' => 'Fecha en la que el descuento deja de ser aplicable',
                'rules' => ''
            ],
            'type' => [
                'type' => 'select',
                'title' => 'Tipo',
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
                'type' => 'numeric',
                'title' => 'Valor del descuento',
                'description' => 'Valor que se le descontará al cliente',
                'rules' => ['required']
            ],
        ]
    ]
];
