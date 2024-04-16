<?php

declare(strict_types=1);

namespace CarMaster\Exception;

class LengthValidationException extends InputValidationException
{
    public function __construct(int $minCountCharacter)
    {
        parent::__construct("Input data length is less than {$minCountCharacter}");
    }
}