<?php

namespace App\Validator\Constraint;

use App\Validator\TaxNumberValidator;
use Attribute;
use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class TaxNumber extends Constraint
{
    public string $message = 'This value should be a valid tax number. Example: ITXXXXXXXXXXX, GRXXXXXXXXX.';

    #[HasNamedArguments]
    public function __construct()
    {
        parent::__construct();
    }

    public function validatedBy(): string
    {
        return TaxNumberValidator::class;
    }
}