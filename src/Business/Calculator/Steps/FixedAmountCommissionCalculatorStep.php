<?php

namespace Ps\Business\Calculator\Steps;

use Ps\Business\RateReader\RateReaderInterface;
use Ps\Shared\PaymentTransfer;

class FixedAmountCommissionCalculatorStep implements CommissionCalculatorStepInterface
{
    /**
     * @param \Ps\Business\RateReader\RateReaderInterface $rateReader
     */
    public function __construct(private RateReaderInterface $rateReader)
    {
    }

    /**
     * @param \Ps\Shared\PaymentTransfer $paymentTransfer
     * @param float $amount
     *
     * @return float
     */
    public function calculate(PaymentTransfer $paymentTransfer, float $amount): float
    {
        if ($paymentTransfer->getCurrencyOrFail() === 'EUR') {
            return $paymentTransfer->getAmountOrFail();
        }

        $rate = $this->rateReader->getRate($paymentTransfer);
        if ($rate == 0) {
            return $paymentTransfer->getAmountOrFail();
        }

        return $paymentTransfer->getAmountOrFail() / $rate;
    }
}
