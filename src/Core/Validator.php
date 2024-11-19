<?php

namespace Jklzz02\RestApi\Core;

class Validator
{
    public static function integer(mixed $value, int $min = 0, int $max = PHP_INT_MAX): bool
    {
        if (!is_numeric($value) || (int)$value != $value){
            return false;
        }

        $int = (int) $value;

        if ($int < $min || $int > $max){
            return false;
        }

        return true;
    }

    public static function string(mixed $value, int $min = 0, int $max = PHP_INT_MAX): bool
    {
        if (!is_string($value)){
            return false;
        }

        $length = strlen($value);

        if ($length < $min || $length > $max) {
            return false;
        }

        return true;
    }

    public static function array(array $source, array $required): ?string
    {
        $missingKeys = array_diff($required, array_keys($source));

        if (!empty($missingKeys)) {
            $missingKeysList = implode(', ', $missingKeys);
            return "Missing required parameter(s): {$missingKeysList}";
        }

    }
}
