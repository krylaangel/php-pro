<?php

class Validator
{
    public function validateNamePart($namePart)
    {
        if (!empty($namePart) && preg_match('/^[a-zA-Z\s]+$/', $namePart)) {
            return $namePart;
        } else {
            throw new Exception('Invalid name');
        }
    }

    public function validateCharacterCount($countCharacter, $minCountCharacter)
    {
        if (strlen($countCharacter) >= $minCountCharacter) {
            return $countCharacter;
        } else {
            throw new Exception('Short name');
        }
    }
}