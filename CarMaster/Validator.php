<?php

declare(strict_types=1);

namespace CarMaster;

use CarMaster\Exception\FormatValidationException;
use CarMaster\Exception\LengthValidationException;

class Validator
{
    public function validateNamePart($namePart)
    {
        if (!empty($namePart) && preg_match('/^[a-zA-Z\s]+$/', $namePart)) {
            return $namePart;
        } else {
            throw new FormatValidationException;
        }
    }

    public function validateCharacterCount($countCharacter, int $minCountCharacter): bool
    {
        $numberLength = (is_string($countCharacter) ? strlen((string)$countCharacter) : is_int(
            $countCharacter
        )) ? strlen((string)$countCharacter) : null;
        if ($numberLength >= $minCountCharacter) {
            return true;
        } else {
            throw new LengthValidationException($minCountCharacter);
        }
    }
}