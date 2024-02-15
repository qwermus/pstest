<?php

namespace Ps\Business\Mapper;

use Ps\Shared\PaymentTransfer;

interface MapperInterface
{
    /**
     * Specification:
     * - Maps an array of payment data to `payment` transfer.
     *
     * @param array<string, mixed> $payment
     * @param \Ps\Shared\PaymentTransfer $paymentTransfer
     *
     * @return \Ps\Shared\PaymentTransfer
     */
    public function mapPaymentArrayToPaymentTransfer(
        array $payment,
        PaymentTransfer $paymentTransfer
    ): PaymentTransfer;
}
