<?php

namespace Ps\Business\Mapper;

use Ps\Business\AppBusinessConfig;
use Ps\Shared\PaymentTransfer;

class Mapper implements MapperInterface
{
    /**
     * {@inheritDoc}
     *
     * @param array<string, mixed> $payment
     * @param \Ps\Shared\PaymentTransfer $paymentTransfer
     *
     * @return \Ps\Shared\PaymentTransfer
     */
    public function mapPaymentArrayToPaymentTransfer(
        array $payment,
        PaymentTransfer $paymentTransfer
    ): PaymentTransfer {
        return $paymentTransfer
            ->setBin($payment[AppBusinessConfig::KEY_BIN])
            ->setAmount($payment[AppBusinessConfig::KEY_AMOUNT])
            ->setCurrency($payment[AppBusinessConfig::KEY_CURRENCY]);
    }
}
