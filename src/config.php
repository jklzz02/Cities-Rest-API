<?php


if (file_exists(BASE_PATH . '.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
    $dotenv->load();
}

return [
    "database" => [
        "type" => $_ENV["DB_type"],
        "host" => $_ENV["DB_HOST"],
        "port" => $_ENV["DB_PORT"],
        "name" => $_ENV["DB_NAME"],
        "username" => $_ENV["DB_USERNAME"] ?? '',
        "password" => $_ENV["DB_PASSWORD"] ?? '',
    ]
];