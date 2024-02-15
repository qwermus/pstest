<?php

namespace Ps\Business\Calculator;

use Ps\Shared\PaymentTransfer;

class CommissionCalculator implements CommissionCalculatorInterface
{
    /**
     * @param list<\Ps\Business\Calculator\Steps\CommissionCalculatorStepInterface> $commissionCalculatorSteps
     */
    public function __construct(private array $commissionCalculatorSteps)
    {
    }

    /**
     * {@inheritDoc}
     *
     * @param \Ps\Shared\PaymentTransfer $paymentTransfer
     *
     * @return \Ps\Shared\PaymentTransfer
     */
    public function calculateCommission(PaymentTransfer $paymentTransfer): PaymentTransfer
    {
        $amount = 0;
        foreach ($this->commissionCalculatorSteps as $commissionCalculatorStep) {
            $amount = $commissionCalculatorStep->calculate($paymentTransfer, $amount);
        }

        return $paymentTransfer->setCommission($amount);
    }
}
