<?php

declare(strict_types=1);

namespace CarMaster\Exception;

class FormatValidationException extends InputValidationException
{
    public function __construct()
    {
        parent::__construct('Invalid data input format');
    }
}