<?php

namespace Ps\Business\RateReader;

use Ps\Business\AppBusinessConfig;
use Ps\Business\Exception\RatesAreMissingException;
use Ps\Business\Exception\WrongRatesException;
use Ps\Shared\PaymentTransfer;

class FileRateReader implements RateReaderInterface
{
    /**
     * @hint Cacher was implemented to be used with
     *
     * @param \Ps\Business\RateReader\RateCacherInterface $rateCacher
     */
    public function __construct(private RateCacherInterface $rateCacher)
    {
    }

    /**
     * @param \Ps\Shared\PaymentTransfer $paymentTransfer
     *
     * @throws \Ps\Business\Exception\NullValueException
     * @throws \Ps\Business\Exception\RatesAreMissingException
     * @throws \Ps\Business\Exception\WrongRatesException
     *
     * @return float
     */
    public function getRate(PaymentTransfer $paymentTransfer): float
    {
        $rates = $this->getRates();

        $rate = $rates[$paymentTransfer->getCurrencyOrFail()] ?? null;
        if ($rate === null) {
            throw new WrongRatesException(
                sprintf('Currency rate was not found for "%s".', $paymentTransfer->getCurrencyOrFail())
            );
        }

        return $rate;
    }

    /**
     * @throws \Ps\Business\Exception\RatesAreMissingException
     *
     * @return array<string, float>
     */
    private function getRates(): array
    {
        $cachedRates = $this->rateCacher->findRates();
        if ($cachedRates) {
            return $cachedRates;
        }

        $rates = $this->getRatesFromFile();
        $rateCollection = $this->getRateCollection($rates);
        $this->rateCacher->setRates($rateCollection);

        return $rateCollection;
    }

    /**
     * @throws \Ps\Business\Exception\RatesAreMissingException
     *
     * @return string
     */
    private function getRatesFromFile(): string
    {
        $rates = file_get_contents(AppBusinessConfig::RATE_MOCK_FILE_PATH);
        if (!$rates) {
            throw new RatesAreMissingException('Rates not found.');
        }

        return $rates;
    }

    /**
     * @param string $rates
     *
     * @throws \Ps\Business\Exception\RatesAreMissingException
     *
     * @return array<string, float>
     */
    private function getRateCollection(string $rates): array
    {
        $decodedRates = json_decode($rates, true);
        $rateCollection = $decodedRates['rates'] ?? null;
        if (!$rateCollection) {
            throw new RatesAreMissingException('Rates are incorrect.');
        }

        return $rateCollection;
    }
}
