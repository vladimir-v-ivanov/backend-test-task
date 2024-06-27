<?php

namespace App\Entity;

use App\Repository\TaxValueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: TaxValueRepository::class)]
#[Table(name: 'tax_countries')]
class TaxCountry
{
    #[Id]
    #[Column(type: Types::STRING)]
    private string $countryCode;

    #[Column(name: 'tax_value', type: Types::INTEGER)]
    private int $value;

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
    }
}
