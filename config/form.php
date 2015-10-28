<?php

return [
    'categories' => [
        'name' => 'Categorias',
        'for_files' => false,
        'description' => 'Administración de Categorias',
        'save' => 'admin.categiries.save',
        'update' => 'admin.categiries.update',
        'editor' => false,
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
                'rules' => 'required'
            ]
        ],
        'lenguages' => [
            'es' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Nombre',
                        'description' => 'Nombre',
                        'rules' => []
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
                        'rules' => []
                    ],
                    'meta_title' => [
                        'type' => 'text',
                        'title' => 'Meta title ',
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
            ],
            'fr' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Nom',
                        'description' => 'Nom',
                        'rules' => []
                    ],
                    'meta_title' => [
                        'type' => 'text',
                        'title' => 'Meta titre ',
                        'description' => 'Meta titre',
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
        'save' => 'admin.products.save',
        'update' => 'admin.products.update',
        'editor' => false,
        'fields' => [
            'active' => [
                'type' => 'radio',
                'title' => 'Activo',
                'description' => 'Estado',
                'rules' => 'required'
            ],
            'category_id' => [
                'type' => 'select',
                'title' => 'Categoria',
                'description' => 'all_categories',
                'rules' => 'required'
            ],
            'image' => [
                'type' => 'image_file',
                'title' => 'Image:',
                'description' => 'Introduzca la imagen del producto',
                'rules' => [
                ]
            ]
        ],
        'lenguages' => [
            'es' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Nombre',
                        'description' => 'Nombre',
                        'rules' => []
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => 'Descripcion',
                        'description' => 'Descripcion',
                        'rules' => []
                    ],
                    'data_comercial' => [
                        'type' => 'file',
                        'title' => 'Ficha Comercial:',
                        'description' => '',
                        'rules' => [
                        ]
                    ],
                    'data_sheet' => [
                        'type' => 'file',
                        'title' => 'Ficha tecnica:',
                        'description' => '',
                        'rules' => [
                        ]
                    ],
                    'data_iom' => [
                        'type' => 'file',
                        'title' => 'IOM:',
                        'description' => '',
                        'rules' => [
                        ]
                    ],
                    'data_drawing' => [
                        'type' => 'file',
                        'title' => 'Dibujos:',
                        'description' => '',
                        'rules' => [
                        ]
                    ]
                ]
            ],
            'en' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Name',
                        'description' => 'Name',
                        'rules' => []
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => 'Description',
                        'description' => 'Description',
                        'rules' => []
                    ],
                    'data_comercial' => [
                        'type' => 'file',
                        'title' => 'Ficha Comercial:',
                        'description' => '',
                        'rules' => [
                        ]
                    ],
                    'data_sheet' => [
                        'type' => 'file',
                        'title' => 'Ficha tecnica:',
                        'description' => '',
                        'rules' => [
                        ]
                    ],
                    'data_iom' => [
                        'type' => 'file',
                        'title' => 'IOM:',
                        'description' => '',
                        'rules' => [
                        ]
                    ],
                    'data_drawing' => [
                        'type' => 'file',
                        'title' => 'Dibujos:',
                        'description' => '',
                        'rules' => [
                        ]
                    ]
                ]
            ],
            'fr' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Nom',
                        'description' => 'Nom',
                        'rules' => []
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => 'Description',
                        'description' => 'Description',
                        'rules' => []
                    ],
                    'data_comercial' => [
                        'type' => 'file',
                        'title' => 'Ficha Comercial:',
                        'description' => '',
                        'rules' => [
                        ]
                    ],
                    'data_sheet' => [
                        'type' => 'file',
                        'title' => 'Ficha tecnica:',
                        'description' => '',
                        'rules' => [
                        ]
                    ],
                    'data_iom' => [
                        'type' => 'file',
                        'title' => 'IOM:',
                        'description' => '',
                        'rules' => [
                        ]
                    ],
                    'data_drawing' => [
                        'type' => 'file',
                        'title' => 'Dibujos:',
                        'description' => '',
                        'rules' => [
                        ]
                    ]
                ]
            ]
        ]
    ],
    'jobs' => [
        'name' => 'Bolsa de empleo',
        'for_files' => false,
        'description' => 'Administración de Bolsa de empleo',
        'save' => 'admin.jobs.save',
        'update' => 'admin.jobs.update',
        'editor' => true,
        'fields' => [
            'active' => [
                'type' => 'radio',
                'title' => 'Activo',
                'description' => 'Estado',
                'rules' => 'required'
            ]
        ],
        'lenguages' => [
            'es' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Titulo',
                        'description' => 'Titulo',
                        'rules' => []
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => 'Descripcion',
                        'description' => 'Descripcion',
                        'rules' => []
                    ]
                ]
            ],
            'en' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Title',
                        'description' => 'Title',
                        'rules' => []
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => 'Description',
                        'description' => 'Description',
                        'rules' => []
                    ]
                ]
            ],
            'fr' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Titre',
                        'description' => 'Titre',
                        'rules' => []
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => 'Description',
                        'description' => 'Description',
                        'rules' => []
                    ]
                ]
            ]
        ]
    ],
    'news' => [
        'name' => 'Noticias',
        'for_files' => true,
        'description' => 'Administración de Noticias',
        'save' => 'admin.news.save',
        'update' => 'admin.news.update',
        'editor' => true,
        'fields' => [
            'image' => [
                'type' => 'image_file',
                'title' => 'Image:',
                'description' => 'Introduzca la imagen Principal de la noticia',
                'rules' => [
                ]
            ],
            'active' => [
                'type' => 'radio',
                'title' => 'Activo',
                'description' => 'Estado',
                'rules' => 'required'
            ]
        ],
        'lenguages' => [
            'es' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Titulo',
                        'description' => 'Titulo',
                        'rules' => []
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => 'Descripcion',
                        'description' => 'Descripcion',
                        'rules' => []
                    ]
                ]
            ],
            'en' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Title',
                        'description' => 'Title',
                        'rules' => []
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => 'Description',
                        'description' => 'Description',
                        'rules' => []
                    ]
                ]
            ],
            'fr' => [
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Titre',
                        'description' => 'Titre',
                        'rules' => []
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => 'Description',
                        'description' => 'Description',
                        'rules' => []
                    ]
                ]
            ]
        ]
    ]
];
