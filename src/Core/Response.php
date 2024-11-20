<?php

namespace Jklzz02\RestApi\Core;

class Response{

    public const int SUCCESS = 200;
    public const int CREATED = 201;
    public const int NO_CONTENT =204;
    public const int BAD_REQUEST = 400;
    public const int UNAUTHORIZED = 401;
    public const int FORBIDDEN = 403;
    public const int NOT_FOUND = 404;
    public const int INTERNAL_ERROR = 500;

    public function __construct() 
    {
        header("Content-Type: application/json");
        header("X-Content-Type-Options: nosniff");

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        header("X-Frame-Options: DENY");
        header("X-XSS-Protection: 1; mode=block");

        header("Expires: 0");
    }

    public function respond(int $status, string $message, array $data = []) : never
    {

        http_response_code($status);

        $response = match (true) {
            empty($data) => [
                "status" => $status,
                "message" => $message
            ],
            default => [
                "data" => $data
            ]
        };
        

        echo json_encode($response, JSON_PRETTY_PRINT);
        die();
    }

    public function success(string $message = "Resource Retrieved", array $data = []): never
    {
        $this->respond(self::SUCCESS, $message, $data);
    }

    public function created(string $message = "Resource Created", array $data = []): never
    {
        $this->respond(self::CREATED, $message, $data);
    }

    public function noContent(string $message = "No Content"): never
    {
        $this->respond(self::NO_CONTENT, $message);
    }

    public function badRequest(string $message = "Bad Request", array $data = []): never
    {
        $this->respond(self::BAD_REQUEST, $message, $data);
    }

    public function unauthorized(string $message = "Unauthorized Access", array $data = []): never
    {
        $this->respond(self::UNAUTHORIZED, $message, $data);
    }

    public function forbidden(string $message = "Forbidden", array $data = []): never
    {
        $this->respond(self::FORBIDDEN, $message, $data);
    }

    public function notFound(string $message = "Resource Not Found", array $data = []): never
    {
        $this->respond(self::NOT_FOUND, $message, $data);
    }

    public function internalError(string $message = "Internal Server Error", array $data = []): never
    {
        $this->respond(self::INTERNAL_ERROR, $message, $data);
    }
}