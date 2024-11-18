<?php


if (file_exists(BASE_PATH . '.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
    $dotenv->load();
}

return [
    "database" => [
        "type" => $_ENV["database_type"],
        "host" => $_ENV["database_host"],
        "port" => $_ENV["database_port"],
        "name" => $_ENV["database_name"],
        "username" => $_ENV["username"] ?? '',
        "password" => $_ENV["password"] ?? '',
    ]
];