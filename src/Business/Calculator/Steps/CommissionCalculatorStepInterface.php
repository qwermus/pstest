<?php

namespace Ps\Business\Calculator\Steps;

use Ps\Shared\PaymentTransfer;

interface CommissionCalculatorStepInterface
{
    /**
     * Specification:
     * - Executes a separate step for commission calculating.
     *
     * @param \Ps\Shared\PaymentTransfer $paymentTransfer
     * @param float $amount
     *
     * @return float
     */
    public function calculate(PaymentTransfer $paymentTransfer, float $amount): float;
}
