<?php

namespace App\Type;

use Symfony\Component\Validator\Constraints\NotBlank;

readonly class TaxNumber
{
    public function __construct(private string $number)
    {
    }

    public function getCountryCode(): string
    {
        return mb_strtoupper(mb_substr($this->number, 0, 2));
    }

    public function getNumber(): string
    {
        return mb_strtoupper($this->number);
    }
}
