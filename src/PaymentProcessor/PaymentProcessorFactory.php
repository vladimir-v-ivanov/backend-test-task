<?php

namespace App\PaymentProcessor;

use App\Exception\PaymentProcessorNotSupportedException;

class PaymentProcessorFactory
{
    /**
     * @throws PaymentProcessorNotSupportedException
     */
    public static function createPaymentProcessor(string $paymentProcessorType): PaymentProcessorInterface
    {
        $paymentProcessorType = ucfirst($paymentProcessorType);
        $paymentProcessorClass = "\\App\\PaymentProcessor\\{$paymentProcessorType}PaymentProcessor";

        if (!class_exists($paymentProcessorClass)) {
            throw new PaymentProcessorNotSupportedException('Given payment processor is not supported.');
        }

        return new $paymentProcessorClass();
    }
}
