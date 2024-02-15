<?php

namespace Ps\Shared;

class PaymentTransfer extends AbstractTransfer
{
    /**
     * @var string
     */
    private const BIN = 'bin';

    /**
     * @var string
     */
    private const AMOUNT = 'amount';

    /**
     * @var string
     */
    private const CURRENCY = 'currency';

    /**
     * @var string
     */
    private const COMMISSION = 'commission';

    /**
     * @var string|null
     */
    private ?string $bin;

    /**
     * @var float|null
     */
    private ?float $amount;

    /**
     * @var string|null
     */
    private ?string $currency;

    /**
     * @var float|null
     */
    private ?float $commission;

    /**
     * @param string $bin
     *
     * @return $this
     */
    public function setBin(string $bin): self
    {
        $this->bin = $bin;

        return $this;
    }

    /**
     * @throws \Ps\Business\Exception\NullValueException
     *
     * @return string
     */
    public function getBinOrFail(): string
    {
        if ($this->bin === null) {
            $this->throwNullValueException(self::BIN);
        }

        return $this->bin;
    }

    /**
     * @param float $amount
     *
     * @return $this
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @throws \Ps\Business\Exception\NullValueException
     *
     * @return float
     */
    public function getAmountOrFail(): float
    {
        if ($this->amount === null) {
            $this->throwNullValueException(self::AMOUNT);
        }

        return $this->amount;
    }

    /**
     * @param string $currency
     *
     * @return $this
     */
    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @throws \Ps\Business\Exception\NullValueException
     *
     * @return string
     */
    public function getCurrencyOrFail(): string
    {
        if ($this->currency === null) {
            $this->throwNullValueException(self::CURRENCY);
        }

        return $this->currency;
    }

    /**
     * @param float $commission
     *
     * @return $this
     */
    public function setCommission(float $commission): self
    {
        $this->commission = $commission;

        return $this;
    }

    /**
     * @throws \Ps\Business\Exception\NullValueException
     *
     * @return float
     */
    public function getCommissionOrFail(): float
    {
        if ($this->commission === null) {
            $this->throwNullValueException(self::COMMISSION);
        }

        return $this->commission;
    }
}
