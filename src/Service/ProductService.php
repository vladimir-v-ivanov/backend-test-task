<?php

namespace App\Service;

use App\Entity\DiscountCoupon;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\TaxCountry;
use App\Exception\CountryNotSupportedException;
use App\Exception\PaymentProcessorNotSupportedException;
use App\Exception\ProductNotFoundException;
use App\PaymentProcessor\PaymentProcessorFactory;
use App\Repository\DiscountCouponRepository;
use App\Repository\ProductRepository;
use App\Repository\TaxValueRepository;
use App\Type\TaxNumber;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

readonly class ProductService
{
    public function __construct(
        private ProductRepository        $productRepository,
        private TaxValueRepository       $taxValueRepository,
        private DiscountCouponRepository $discountCouponRepository,
        private PaymentProcessorFactory  $paymentProcessorFactory,
        private EntityManagerInterface   $entityManager
    ) {
    }

    /**
     * @throws ProductNotFoundException
     * @throws CountryNotSupportedException
     */
    public function calculatePrice(int $productId, string $taxCountry, ?string $couponCode): float
    {
        /**
         * @var Product $product
         */
        $product = $this->productRepository->find($productId);

        if (!$product) {
            throw new ProductNotFoundException('Product not found.');
        }

        /**
         * @var TaxCountry $taxValue
         */
        $taxValue = $this->taxValueRepository->find($taxCountry);

        if (!$taxValue) {
            throw new CountryNotSupportedException('Country of the given tax number is not supported.');
        }

        $finalPrice = $product->getPrice();
        $finalPrice += $finalPrice * $taxValue->getValue() / 100;

        if (!empty($couponCode)) {
            /**
             * @var DiscountCoupon $discountCoupon
             */
            $discountCoupon = $this->discountCouponRepository->find($couponCode);

            if ($discountCoupon) {
                $finalPrice -= $finalPrice * $discountCoupon->getDiscount() / 100;
            }
        }

        return $finalPrice;
    }

    /**
     * @throws ProductNotFoundException
     * @throws CountryNotSupportedException
     * @throws PaymentProcessorNotSupportedException
     */
    public function purchase(int $productId, TaxNumber $taxNumber, string $paymentProcessor, ?string $couponCode): array
    {
        $price = $this->calculatePrice($productId, $taxNumber->getCountryCode(), $couponCode);

        $order = new Order();
        $order->setProductId($productId);
        $order->setTaxNumber($taxNumber->getNumber());
        $order->setDiscountCoupon($couponCode);
        $order->setStatus('processing');
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        $paymentProcessor = $this->paymentProcessorFactory->createPaymentProcessor($paymentProcessor);

        try {
            $paymentProcessor->process($price);

            $order->setStatus('paid');
            $this->entityManager->persist($order);
            $this->entityManager->flush();
        } catch (Throwable) {
            // do some actions
        }

        return [$price, $order];
    }
}
