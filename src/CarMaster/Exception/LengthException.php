<?php

declare(strict_types=1);

namespace CarMaster\Exception;

class LengthException extends ValidationException
{
    public function __construct(int $minCountCharacter)
    {
        parent::__construct("Input data length is less than {$minCountCharacter}");
    }
}