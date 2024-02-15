<?php

namespace Ps\Business\RateReader;

use Ps\Business\Exception\ApiKeytIsMissingException;
use Ps\Shared\PaymentTransfer;

class ExchangeRatesApiRateReader implements RateReaderInterface
{
    /**
     * @param \Ps\Shared\PaymentTransfer $paymentTransfer
     *
     * @throws \Ps\Business\Exception\ApiKeytIsMissingException
     *
     * @return float
     */
    public function getRate(PaymentTransfer $paymentTransfer): float
    {
        throw new ApiKeytIsMissingException('API key was not provided.');
    }
}
