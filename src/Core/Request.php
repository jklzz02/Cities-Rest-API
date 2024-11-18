<?php

namespace Jklzz02\RestApi\Core;

class Request{
    private string $path;
    private array $queryParams;
    private string $method;
    private array $headers;
    private array $body;

    public function __construct()
    {
        $uri = parse_url($_SERVER['REQUEST_URI']);

        $this->path = $uri['path'];
        $this->queryParams = [];
        parse_str($uri['query'] ?? '', $this->queryParams);
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->headers = getallheaders();
        $this->body = json_decode(file_get_contents('php://input'), true) ?? $_POST ?? [];
        
    }

    public function getPath() :string
    {
        return $this->path;
    }

    public function getQuery() :array
    {
        return $this->queryParams;
    }

    public function getMethod() :string
    {
        return $this->method;
    }

    public function getHeaders() :array
    {
        return $this->headers;
    }

    public function getBody() : array
    {
        return $this->body;
    }

    public function token() : ?string
    {
        return $this->queryParams['appid'] ?? '';
    }
}