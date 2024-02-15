<?php

namespace Ps\Business\CountryReader;

use Ps\Shared\PaymentTransfer;

interface CountryReaderInterface
{
    /**
     * Specification:
     * - Returns a country code for provided payment.
     *
     * @param \Ps\Shared\PaymentTransfer $paymentTransfer
     *
     * @throws \Ps\Business\Exception\BinListBrokenException
     * @throws \Ps\Business\Exception\NullValueException
     *
     * @return string
     */
    public function getCountry(PaymentTransfer $paymentTransfer): string;
}
