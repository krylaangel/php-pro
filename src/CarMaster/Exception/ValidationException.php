<?php

declare(strict_types=1);

namespace CarMaster\Exception;

use RuntimeException;

class ValidationException extends RuntimeException
{
    public function __construct(string $message = "Invalid input data")
    {
        parent::__construct($message);
    }
}