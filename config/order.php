<?php

return [
    'delivery_price' => 5,
    'payments' => [
        'bog' => [
            'client_id'     => env('BOG_CLIENT_ID'),
            'secret_key'    => env('BOG_SECRET_KEY'),
            'auth_url'      => 'https://oauth2.bog.ge/auth/realms/bog/protocol/openid-connect/token',
            'order_url'     => 'https://api.bog.ge/payments/v1/ecommerce/orders',
            'order_details' => 'https://api.bog.ge/payments/v1/receipt/%s'
        ]
    ],
];
