<?php

namespace App\PaymentProcessor;

use Exception;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor as ExternalPaypalPaymentProcessor;
use Throwable;

class PaypalPaymentProcessor implements PaymentProcessorInterface
{
    /**
     * @throws Exception
     */
    public function process(float $price): void
    {
        (new ExternalPaypalPaymentProcessor())->pay((int) $price);
    }
}
