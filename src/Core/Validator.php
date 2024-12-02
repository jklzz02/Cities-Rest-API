<?php

namespace Jklzz02\RestApi\Core;

class Validator
{
    public function integer(mixed $value, int $min = 0, int $max = PHP_INT_MAX): bool
    {
        if(!is_numeric($value) || (int)$value != $value){
            return false;
        }

        $int = (int) $value;

        if ($int < $min || $int > $max){
            return false;
        }

        return true;
    }

    public function string(mixed $value, int $min = 0, int $max = PHP_INT_MAX): bool
    {
        if(!is_string($value)){
            return false;
        }

        $length = strlen($value);

        if($length < $min || $length > $max){
            return false;
        }

        return true;
    }

    public function array(array $source, array $requiredKeys, array $optionalKeys = []): string
    {
        $missingKeys = array_diff($requiredKeys, array_keys($source));
        $missingKeys = array_diff($missingKeys, $optionalKeys);

        if($missingKeys ?? false){
            $missingKeysList = implode(', ', $missingKeys);
            return "Missing required parameter(s): {$missingKeysList}";
        }

        return "";
    }
}
