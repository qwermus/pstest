<?php

namespace Ps\Business\Calculator;

use Ps\Shared\PaymentTransfer;

interface CommissionCalculatorInterface
{
    /**
     * Specification:
     * - Executes calculator steps to calculate commission.
     * - Expands `payment` transfer with calculated commission.
     *
     * @param \Ps\Shared\PaymentTransfer $paymentTransfer
     *
     * @return \Ps\Shared\PaymentTransfer
     */
    public function calculateCommission(PaymentTransfer $paymentTransfer): PaymentTransfer;
}
