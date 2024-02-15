<?php

namespace Ps\Business\Calculator\Steps;

use Ps\Shared\PaymentTransfer;

class CeilCommissionCalculatorStep implements CommissionCalculatorStepInterface
{
    /**
     * @param \Ps\Shared\PaymentTransfer $paymentTransfer
     * @param float $amount
     *
     * @return float
     */
    public function calculate(PaymentTransfer $paymentTransfer, float $amount): float
    {
        return ceil($amount * 100) / 100;
    }
}
