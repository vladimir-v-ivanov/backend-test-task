<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: OrderRepository::class)]
#[Table(name: 'orders')]
class Order
{
    #[Id]
    #[Column(type: Types::INTEGER)]
    #[GeneratedValue]
    private int $id;

    #[Column(type: Types::INTEGER)]
    private int $productId;

    #[Column(type: Types::STRING)]
    private ?string $discountCoupon;

    #[Column(type: Types::STRING)]
    private string $status;

    #[Column(type: Types::STRING)]
    private string $taxNumber;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }

    public function getDiscountCoupon(): ?string
    {
        return $this->discountCoupon;
    }

    public function setDiscountCoupon(?string $discountCoupon): void
    {
        $this->discountCoupon = $discountCoupon;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setTaxNumber(string $taxNumber): void
    {
        $this->taxNumber = $taxNumber;
    }
}
