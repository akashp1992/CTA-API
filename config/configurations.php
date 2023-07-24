<?php
return [
    [
        'key'          => 'general',
        'display_text' => 'General',
        'value'        => '',
        'input_type'   => 'text',
        'children'     => [
            [
                'key'          => 'name',
                'display_text' => 'Name',
                'value'        => 'Rides',
                'input_type'   => 'text',
            ],
            [
                'key'          => 'website',
                'display_text' => 'Website',
                'value'        => 'https://www.google.com/',
                'input_type'   => 'text',
            ],
            [
                'key'          => 'email',
                'display_text' => 'Email',
                'value'        => 'harsh@hotmail.com',
                'input_type'   => 'text',
            ],
            [
                'key'          => 'phone',
                'display_text' => 'Phone',
                'value'        => '8320058628',
                'input_type'   => 'text',
            ],
            [
                'key'          => 'whatsapp_number',
                'display_text' => 'Whatsapp Number',
                'value'        => '8320058628',
                'input_type'   => 'text',
            ],
            [
                'key'          => 'address',
                'display_text' => 'Address',
                'value'        => '5151 Irvine Boulevard, Irvine, CA, USA',
                'input_type'   => 'text',
            ],
            [
                'key'          => 'sender_email',
                'display_text' => 'Sender Email',
                'value'        => 'sender@gmail.com',
                'input_type'   => 'text',
            ],
            [
                'key'          => 'receiver_email',
                'display_text' => 'Receiver Email',
                'value'        => 'receiver@gmail.com',
                'input_type'   => 'text',
            ]
        ]
    ],
    [
        'key'          => 'assets',
        'display_text' => 'Assets',
        'value'        => '',
        'input_type'   => 'text',
        'children'     => [
            [
                'key'          => 'logo',
                'display_text' => 'Logo',
                'value'        => 'uploads/configurations/logo.png',
                'input_type'   => 'file',
            ],
            [
                'key'          => 'actual_logo',
                'display_text' => 'Actual Logo',
                'value'        => 'uploads/configurations/actual_logo.png',
                'input_type'   => 'file'
            ],
            [
                'key'          => 'favicon',
                'display_text' => 'Favicon',
                'value'        => 'uploads/configurations/favicon.ico',
                'input_type'   => 'file',
            ]
        ]
    ],
    [
        'key'          => 'social_media',
        'display_text' => 'Social Media',
        'value'        => '',
        'input_type'   => 'text',
        'children'     => [
            [
                'key'          => 'facebook_URL',
                'display_text' => 'Facebook',
                'value'        => 'https://www.facebook.com/',
                'input_type'   => 'text',
            ],
            [
                'key'          => 'instagram_URL',
                'display_text' => 'Instagram',
                'value'        => 'https://www.instagram.com/',
                'input_type'   => 'text',
            ],
            [
                'key'          => 'twitter_URL',
                'display_text' => 'Twitter',
                'value'        => 'https://twitter.com/',
                'input_type'   => 'text',
            ],
            [
                'key'          => 'LinkedIn_URL',
                'display_text' => 'LinkedIn',
                'value'        => 'https://www.linkedin.com/',
                'input_type'   => 'text',
            ]
        ]
    ],
    [
        'key'          => 'settings',
        'display_text' => 'Settings',
        'value'        => '',
        'input_type'   => 'text',
        'children'     => [
            [
                'key'          => 'week_day_off',
                'display_text' => 'Week Day Off',
                'value'        => 'Friday',
                'input_type'   => 'select',
                'options'      => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
            ],
            [
                'key'          => 'advance_percentage_for_online',
                'display_text' => 'Advance Percentage ( Online )',
                'value'        => '10',
                'input_type'   => 'text'
            ],
            [
                'key'          => 'advance_percentage_for_pos',
                'display_text' => 'Advance Percentage ( POS )',
                'value'        => '10',
                'input_type'   => 'text'
            ],
        ]
    ],
    [
        'key'          => 'sms_provider',
        'display_text' => 'SMS Provider',
        'value'        => '',
        'input_type'   => 'text',
        'children'     => [
            [
                'key'          => 'uid',
                'display_text' => 'UID',
                'value'        => '',
                'input_type'   => 'text',
            ],
            [
                'key'          => 'account_id',
                'display_text' => 'Account ID',
                'value'        => '',
                'input_type'   => 'text',
            ],
            [
                'key'          => 'password',
                'display_text' => 'Password',
                'value'        => '',
                'input_type'   => 'text',
            ],
            [
                'key'          => 'sender',
                'display_text' => 'Sender',
                'value'        => '',
                'input_type'   => 'text',
            ],
        ]
    ],
    [
        'key'          => 'payment_provider',
        'display_text' => 'Payment Provider',
        'value'        => '',
        'input_type'   => 'text',
        'children'     => [
            [
                'key'          => 'is_sandbox',
                'display_text' => 'Is Sandbox?',
                'value'        => 'Yes',
                'input_type'   => 'select',
                'options'      => ['Yes', 'No']
            ],
            [
                'key'          => 'fatoorah_api_key',
                'display_text' => 'Fatoorah API Key',
                'value'        => 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL',
                'input_type'   => 'textarea',
            ],
            [
                'key'          => 'u_payment_api_key',
                'display_text' => 'UPayment API Key',
                'value'        => '',
                'input_type'   => 'textarea',
            ],
        ]
    ]
];
