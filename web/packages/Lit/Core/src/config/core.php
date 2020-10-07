<?php

return [
    'columnTypes' => [
        'text' => 'Text',
        'image' => 'Image',
        'date' => 'Date',
        'datetime' => 'Datetime'
    ],
    'columnFields' => [
        'text' => 'Text',
        'image' => 'Image',
        'date' => 'Date',
        'datetime' => 'Datetime',
        'password' => 'Password',
        'email' => 'Email',
        'number' => 'Number'
    ],
    'exceptColumn' => ['id', 'created_at', 'updated_at', 'deleted_at'],
    'requestRules' => 'accepted|active_url|alpha|alpha_dash|alpha_num|array|bail|boolean|confirmed|date|email|file|filled|image|integer|ip|ipv4|ipv6|json|nullable|numeric|password|present|required|string|timezone|url|uuid'
];
