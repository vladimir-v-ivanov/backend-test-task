<?php

namespace App\Entity;

use App\Repository\DiscountCouponRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: DiscountCouponRepository::class)]
#[Table(name: 'discount_coupons')]
class DiscountCoupon
{
    #[Id]
    #[Column(type: Types::INTEGER)]
    private string $code;

    #[Column(type: Types::INTEGER)]
    private int $discount;

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getDiscount(): int
    {
        return $this->discount;
    }

    public function setDiscount(int $discount): void
    {
        $this->discount = $discount;
    }
}
