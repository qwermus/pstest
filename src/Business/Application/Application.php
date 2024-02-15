<?php

namespace Ps\Business\Application;

use Ps\Business\Calculator\CommissionCalculatorInterface;
use Ps\Business\Decoder\DecoderInterface;
use Ps\Business\FileReader\FileReaderInterface;
use Ps\Business\Mapper\MapperInterface;
use Ps\Business\Output\OutputInterface;
use Ps\Business\Validator\ValidatorInterface;
use Ps\Shared\PaymentTransfer;

class Application
{
    /**
     * @param \Ps\Business\Output\OutputInterface $output
     * @param \Ps\Business\Mapper\MapperInterface $mapper
     * @param \Ps\Business\Decoder\DecoderInterface $decoder
     * @param \Ps\Business\FileReader\FileReaderInterface $fileReader
     * @param \Ps\Business\Validator\ValidatorInterface $paymentValidator
     * @param \Ps\Business\Calculator\CommissionCalculatorInterface $commissionCalculator
     */
    public function __construct(
        private OutputInterface $output,
        private MapperInterface $mapper,
        private DecoderInterface $decoder,
        private FileReaderInterface $fileReader,
        private ValidatorInterface $paymentValidator,
        private CommissionCalculatorInterface $commissionCalculator
    ) {
    }

    /**
     * Specification:
     * - Reads specified file.
     * - Splits file content on separate payment information.
     * - Decodes payment information to array.
     * - Validates if provided data is correct.
     * - Maps payment array to `payment` transfer.
     * - Calculates commission for provided bin, amount and currency.
     * - Expands `payment` transfer with `commission`.
     * - Prints calculated commission.
     *
     * @param string $fileName
     *
     * @return void
     */
    public function calculateCommissionsFromFile(string $fileName): void
    {
        $fileContents = $this->fileReader->readFile($fileName);
        $paymentCollection = $this->fileReader->splitContent($fileContents);
        foreach ($paymentCollection as $payment) {
            if (!$payment) {
                continue;
            }

            $paymentTransfer = $this->calculateComissionForPayment($payment);
            $this->output->print((string)$paymentTransfer->getCommissionOrFail());
        }
    }

    /**
     * @param string $payment
     *
     * @return \Ps\Shared\PaymentTransfer
     */
    private function calculateComissionForPayment(string $payment): PaymentTransfer
    {
        $decodedPayment = $this->decoder->decode($payment);
        $this->paymentValidator->validate($decodedPayment);
        $paymentTransfer = $this->mapper->mapPaymentArrayToPaymentTransfer($decodedPayment, new PaymentTransfer());
        $paymentTransfer = $this->commissionCalculator->calculateCommission($paymentTransfer);

        return $paymentTransfer;
    }
}
