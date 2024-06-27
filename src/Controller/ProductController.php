<?php

namespace App\Controller;

use App\Entity\Order;
use App\Exception\CountryNotSupportedException;
use App\Exception\PaymentProcessorNotSupportedException;
use App\Exception\ProductNotFoundException;
use App\Request\Product\CalculatePriceRequest;
use App\Request\Product\PurchaseRequest;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    public function __construct(
        private readonly ProductService $productService
    )
    {
    }

    #[Route('/calculate-price', name: 'product.calculate-price', methods: 'POST')]
    public function calculatePrice(#[MapRequestPayload(acceptFormat: 'json')] CalculatePriceRequest $request): JsonResponse
    {
        try {
            $product = $request->getProduct();
            $price = $this->productService->calculatePrice(
                $product,
                $request->getTaxNumberType()->getCountryCode(),
                $request->getCouponCode()
            );

            return new JsonResponse(['result' => true, 'data' => ['product' => $product, 'price' => $price]]);
        } catch (ProductNotFoundException) {
            return new JsonResponse(['result' => false, 'error' => 'Product not found.'], 404);
        } catch (CountryNotSupportedException) {
            return new JsonResponse(['result' => false, 'error' => 'Country of the tax number not supported.'], 400);
        }
    }

    #[Route('/purchase', name: 'product.purchase', methods: 'POST')]
    public function purchase(#[MapRequestPayload(acceptFormat: 'json')] PurchaseRequest $request): JsonResponse
    {
        // Сделать метод в этом же сервисе для создания заказа
        // Сделать обертки для PaymentProcessor, которые будут вызывать нужный метод
        // Сделать таблицу orders с заказами
        try {
            $product = $request->getProduct();
            /**
             * @var Order $order
             */
            [$price, $order] = $this->productService->purchase(
                $product,
                $request->getTaxNumberType(),
                $request->getPaymentProcessor(),
                $request->getCouponCode()
            );

            return new JsonResponse(['result' => true, 'data' => ['product' => $product, 'price' => $price, 'order' => $order->getId()]]);
        } catch (ProductNotFoundException) {
            return new JsonResponse(['result' => false, 'error' => 'Product not found.'], 404);
        } catch (CountryNotSupportedException) {
            return new JsonResponse(['result' => false, 'error' => 'Country of the tax number not supported.'], 400);
        } catch (PaymentProcessorNotSupportedException) {
            return new JsonResponse(['result' => false, 'error' => 'Payment processor is not supported.'], 400);
        }
    }
}
