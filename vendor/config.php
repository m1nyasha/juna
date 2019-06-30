<?php

return [
    "db" => [
        "status" => true,
        "host" => "localhost",
        "db_name" => "test",
        "username" => "root",
        "password" => "root"
    ],
    "SECRET_KEY" => 'c23r23rv23r', //укажите случайные символы для секретного ключа
    "user_auth" => [
        "table" => "users",
        "columns" => [
            "login" => "username",
            "password" => "password"
        ]
    ],
    "session" => false
];
