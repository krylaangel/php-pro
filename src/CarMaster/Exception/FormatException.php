<?php

declare(strict_types=1);

namespace CarMaster\Exception;

class FormatException extends ValidationException
{
    public function __construct()
    {
        parent::__construct('Invalid data input format');
    }
}