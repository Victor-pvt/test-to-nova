<?php

namespace Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueUser extends Constraint
{
    public $message = 'Пароль повторный не совпадает с первым';

    public function validatedBy()
    {
        return 'not_unique_password_validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
