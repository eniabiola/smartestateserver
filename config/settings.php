<?php

return [
    'pass_count' => [
        'title' => 'Visitor Pass Count',
        'desc' => 'Visitor Pass Count',
        'icon' => 'glyphicon glyphicon-sunglasses',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'pass_count', // unique name for field
                'label' => "Pass Count", // you know what label it is
                'rules' => 'nullable', // validation rule of laravel
                'value' => 20 // default value if you want
            ]
        ]
    ],
    /*'theme' => [
        'title' => 'Theme',
        'desc' => 'Theme look and feel',
        'icon' => 'glyphicon glyphicon-sunglasses',

        'elements' => [
            [
                'type' => 'color', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'primary_color', // unique name for field
                'label' => 'Primary Color', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 'blue' // default value if you want
            ],
            [
                'type' => 'color', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'secondary_color', // unique name for field
                'label' => 'Secondary Color', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '#AAf' // default value if you want
            ],
            [
                'type' => 'file', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'logo', // unique name for field
                'label' => 'Logo', // you know what label it is
                'rules' => 'nullable|file|mimes:jpeg,jpg,bmp,png', // validation rule of laravel
                'value' => config('app.url') . '/storage/logo/default-logo.jpg'// null // default value if you want
            ],
            [
                'type' => 'file', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'bg_image', // unique name for field
                'label' => 'Background Image', // you know what label it is
                'rules' => 'nullable|file|mimes:jpeg,jpg,bmp,png', // validation rule of laravel
                'value' => '' // default value if you want
            ]

        ]
    ],*/


    /*'external_api' => [
        'title' => 'External Api',
        'desc' => 'Configure Web Service for External use',
        'icon' => 'glyphicon glyphicon-sunglasses',
        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'external_secret_key', // unique name for field
                'label' => 'Secret Key for External api', // you know what label it is
                'rules' => 'nullable', // validation rule of laravel
                'value' => '$3#@fdUYGY5%66^76545' // default value if you want
            ],
        ]

    ],*/

    /*'support' => [
        'title' => 'Support Information',
        'desc' => 'Define contact support for the application',
        'icon' => 'glyphicon glyphicon-sunglasses',
        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'support_contact_number', // unique name for field
                'label' => 'Support Contact Number', // you know what label it is
                'rules' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:11', // validation rule of laravel
                'value' => "" // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'support_contact_email', // unique name for field
                'label' => 'Support Contact Email', // you know what label it is
                'rules' => 'nullable|email', // validation rule of laravel
                'value' => "" // default value if you want
            ]
        ]

    ],*/

    /*'chat' => [
        'title' => 'Chat Setting',
        'desc' => 'Configure setting for chat',
        'icon' => 'glyphicon glyphicon-sunglasses',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'tawkto_chat_app_code', // unique name for field
                'label' => "Tawk To Application Code", // you know what label it is
                'rules' => 'nullable', // validation rule of laravel
                'value' => '', // default value if you want
                'title' => ''
            ],

        ]
    ],*/

    /*'app_links' => [
        'title' => 'App Links Setting',
        'desc' => 'Configure app link setting',
        'icon' => 'glyphicon glyphicon-sunglasses',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'password_reset_url', // unique name for field
                'label' => "Sender", // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 'http://google.com', // default value if you want
                'title' => ''
            ],
        ]

    ],*/

    /*'sms' => [
        'title' => 'SMS Setting',
        'desc' => 'Configure setting for bulk sms',
        'icon' => 'glyphicon glyphicon-sunglasses',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'sms_sender', // unique name for field
                'label' => "Sender", // you know what label it is
                'rules' => 'nullable', // validation rule of laravel
                'value' => '', // default value if you want
                'title' => ''
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'sms_username', // unique name for field
                'label' => "Username", // you know what label it is
                'rules' => 'nullable', // validation rule of laravel
                'value' => '', // default value if you want
                'title' => ''
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'sms_password', // unique name for field
                'label' => "Password", // you know what label it is
                'rules' => 'nullable', // validation rule of laravel
                'value' => '', // default value if you want
                'title' => ''
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'sms_consumer_key', // unique name for field
                'label' => "Consumer Key", // you know what label it is
                'rules' => 'nullable', // validation rule of laravel
                'value' => '', // default value if you want
                'title' => ''
            ],

        ]
    ],*/

    /*"css_config" => [
        'title' => 'CSS Setting',
        'desc' => 'Configure setting for css',
        'icon' => 'glyphicon glyphicon-sunglasses',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'client_id', // unique name for field
                'label' => "Client ID", // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => 'PQNZJGXPKW', // default value if you want
                'title' => ''
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'client_secret', // unique name for field
                'label' => "Client Secret", // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'value' => '&>%UfU~TB[Hh:zrn;nW/!}}*FyhWrk#,{zy_)pN]d$]+<~@5nLL,BAQ7PXb58$HW^WH52#NVGxzjpe$AR{', // default value if you want
                'title' => ''
            ],

        ]
    ]*/

];

//setting('enable_part_payment');
