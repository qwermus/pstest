<?php

namespace Ps\Business\RateReader;

use Ps\Shared\PaymentTransfer;

interface RateReaderInterface
{
    /**
     * Specification:
     * - Returns rate for provided currency.
     *
     * @param \Ps\Shared\PaymentTransfer $paymentTransfer
     *
     * @throws \Ps\Business\Exception\NullValueException
     * @throws \Ps\Business\Exception\RatesAreMissingException
     * @throws \Ps\Business\Exception\WrongRatesException
     *
     * @return float
     */
    public function getRate(PaymentTransfer $paymentTransfer): float;
}
