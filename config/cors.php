<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie', ''],

    "AllowedMethods" => [
        "GET",
        "PUT",
        "POST",
        "DELETE"
    ],

    'allowed_origins' => ['http://127.0.0.1:8000'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => ['
        "x-amz-server-side-encryption",
        "x-amz-request-id",
        "x-amz-id-2",
        "Content-Type"
    '],

    'max_age' => 0,

    'supports_credentials' => false,

];