<?php

return [
    "db" => [
        "host" => "localhost",
        "db_name" => "db_name",
        "username" => "root",
        "password" => ""
    ],
    "SECRET_KEY" => '', //укажите случайные символы для секретного ключа
    "user_auth" => [
        "table" => "_users",
        "columns" => [
            "login" => "username",
            "password" => "password"
        ]
    ]
];
