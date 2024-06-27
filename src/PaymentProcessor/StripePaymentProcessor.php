<?php

namespace App\PaymentProcessor;

use Exception;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor as ExternalStripePaymentProcessor;

class StripePaymentProcessor implements PaymentProcessorInterface
{
    /**
     * @throws Exception
     */
    public function process(float $price): void
    {
        if (!(new ExternalStripePaymentProcessor())->processPayment($price)) {
            throw new Exception('Unable to process payment. No reason specified.');
        }
    }
}
