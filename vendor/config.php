<?php

return [
    "db" => [
        "host" => "localhost",
        "db_name" => "test",
        "username" => "root",
        "password" => "root"
    ],
    "SECRET_KEY" => '7awbevr8qb6978rvbq89vb6q39478tv6b9783t', //укажите случайные символы для секретного ключа
    "user_auth" => [
        "table" => "users",
        "columns" => [
            "login" => "username",
            "password" => "password"
        ]
    ]
];
