<?php

/**
 * Created by PhpStorm.
 * User: victor
 * Date: 07.08.16
 * Time: 1:33
 */
namespace Validator\Constraints;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Model\User;

class RepeatPassword extends Constraint
{
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
