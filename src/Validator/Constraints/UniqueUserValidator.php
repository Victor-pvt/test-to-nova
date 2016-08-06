<?php

/**
 * Date: 16.02.16
 * Time: 17:00.
 */

namespace Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Model\User;

class UniqueUserValidator extends ConstraintValidator
{
    /**
     * @param Constraint $constraint
     *
     * @return bool
     */
    public function validate($user, Constraint $constraint)
    {
        /** @var User $user */
        $password = $user->getPassword();
        $passwordRepeat = $user->getPasswordRepeat();

        if ($password != $passwordRepeat) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $user)
                ->addViolation();
        }
    }
}
