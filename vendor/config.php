<?php

return [
    "db" => [
        "status" => false,
        "host" => "localhost",
        "db_name" => "db",
        "username" => "root",
        "password" => ""
    ],
    "SECRET_KEY" => '45bt345bt453t', //укажите случайные символы для секретного ключа
    "user_auth" => [
        "table" => "_users",
        "columns" => [
            "login" => "username",
            "password" => "password"
        ]
    ]
];
