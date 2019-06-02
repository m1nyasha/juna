<?php

return [
    "db" => [
        "status" => false,
        "host" => "localhost",
        "db_name" => "db",
        "username" => "root",
        "password" => ""
    ],
    "SECRET_KEY" => '', //укажите случайные символы для секретного ключа
    "user_auth" => [
        "table" => "users",
        "columns" => [
            "login" => "username",
            "password" => "password"
        ]
    ],
    "session" => false
];
