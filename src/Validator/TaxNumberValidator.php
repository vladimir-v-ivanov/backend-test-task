<?php

namespace App\Validator;

use App\Validator\Constraint\TaxNumber;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class TaxNumberValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof TaxNumber) {
            throw new UnexpectedTypeException($constraint, TaxNumber::class);
        }

        if (empty($value)) {
            return;
        }

        if (!in_array(mb_substr($value, 0, 2), Countries::getCountryCodes())) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }

        if (!preg_match('/^[A-Za-z0-9]{5,15}$/', mb_substr($value, 2))) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
