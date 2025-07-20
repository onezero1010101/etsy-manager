<?php
return [
    'client_id' => getenv('ETSY_CLIENT_ID'),
    'client_secret' => getenv('ETSY_CLIENT_SECRET'),
    'redirect_uri' => getenv('ETSY_REDIRECT_URI'),
    'access_token' => getenv('ETSY_ACCESS_TOKEN'),
    'db' => [
        'host' => getenv('DB_HOST'),
        'name' => getenv('DB_NAME'),
        'user' => getenv('DB_USER'),
        'pass' => getenv('DB_PASS')
    ]
];