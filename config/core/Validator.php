<?php

namespace App\Config\Core;

class Validator
{
    private array $errors = [];

    public function __construct()
    {
        $this->errors = [];
    }
    public  function isEmail(int $key, $value, $message)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($key, $message);
        }
    }
    public  function isEmpty(int $key, $value, $message)
    {
        if (empty($value)) {
            $this->addError($key, $message);
        }
    }


    public  function getErrors(): array
    {
        return $this->errors;
    }


    public function addError($key, $message): void
    {
        $this->errors[$key] = $message;
    }

    public function isValid(): bool
    {
        return empty($this->errors);
    }
}
