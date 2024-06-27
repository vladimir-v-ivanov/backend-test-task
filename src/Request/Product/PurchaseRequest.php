<?php

namespace App\Request\Product;

use App\Type\TaxNumber as TaxNumberType;
use App\Validator\Constraint\TaxNumber;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

readonly class PurchaseRequest
{
    private TaxNumberType $taxNumberType;

    public function __construct(
        #[Positive]
        private int $product,

        #[NotBlank]
        #[TaxNumber]
        private string $taxNumber,

        #[NotBlank(allowNull: true)]
        private ?string $couponCode,

        #[Choice(['paypal', 'stripe'])]
        private string $paymentProcessor,
    ) {
        $this->taxNumberType = new TaxNumberType($this->taxNumber);
    }

    public function getProduct(): int
    {
        return $this->product;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function getTaxNumberType(): TaxNumberType
    {
        return $this->taxNumberType;
    }

    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }

    public function getPaymentProcessor(): string
    {
        return $this->paymentProcessor;
    }
}
