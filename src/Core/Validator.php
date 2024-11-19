<?php

namespace Jklzz02\RestApi\Core;

class Validator{

    protected array $errors = [];
    public const string ARRAY_ERROR = "array";
    public const string STRING_ERROR = "string";
    public const string INTEGER_ERROR = "integer";

    public function array(array $source, array $required): void
    {
        $missingKeys = array_diff($required, array_keys($source));

        if (!empty($missingKeys)) {
            $missingKeysList = implode(', ', $missingKeys);
            $this->errors[static::ARRAY_ERROR] = "Missing required parameters: {$missingKeysList}";
        }
    }
    
    public function getAllErrors(): array
    {
        return $this->errors;
    }

    public function getError(string $key, string $default = ""): string
    {
        return $this->errors[$key] ?? $default;
    }

    public function validate(): bool
    {
        return (bool) count($this->errors);
    }

}