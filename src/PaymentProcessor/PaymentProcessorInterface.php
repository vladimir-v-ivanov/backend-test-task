<?php

namespace App\PaymentProcessor;

interface PaymentProcessorInterface
{
    public function process(float $price);
}
