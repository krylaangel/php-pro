<?php
declare(strict_types=1);

namespace CarMaster;

use Exception;

class Validator
{
    /**
     * @throws Exception
     */
    public function validateNamePart($namePart)
    {
        if (!empty($namePart) && preg_match('/^[a-zA-Z\s]+$/', $namePart)) {
            return $namePart;
        } else {
            throw new Exception('Invalid name');
        }
    }

    /**
     * @throws Exception
     * проверка на тип получаемого значения, приведение его к строке и проверка на кол-во симовлов в строке.
     */
    public function validateCharacterCount($countCharacter, int $minCountCharacter): bool
    {
        $numberLength = (is_string($countCharacter) ? strlen((string)$countCharacter) : is_int($countCharacter)) ? strlen((string)$countCharacter) : null;
        if ($numberLength !== null >= $minCountCharacter) {
            return true;
        } else {
            throw new Exception('Short name');
        }
    }
}