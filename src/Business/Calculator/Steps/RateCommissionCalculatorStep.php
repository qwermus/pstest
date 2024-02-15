<?php

namespace Ps\Business\Calculator\Steps;

use Ps\Business\AppBusinessConfig;
use Ps\Business\CountryReader\CountryReaderInterface;
use Ps\Business\Exception\EuListBrokenException;
use Ps\Business\Exception\EuListMissingException;
use Ps\Shared\PaymentTransfer;

class RateCommissionCalculatorStep implements CommissionCalculatorStepInterface
{
    /**
     * @var float
     */
    private const COEFFICIENT_EU = 0.01;

    /**
     * @var float
     */
    private const COEFFICIENT_NON_EU = 0.02;

    /**
     * @var list<string>
     */
    private static array $euListCache;

    /**
     * @param \Ps\Business\CountryReader\CountryReaderInterface $countryReader
     *
     * @throws \Ps\Business\Exception\EuListBrokenException
     * @throws \Ps\Business\Exception\EuListMissingException
     */
    public function __construct(private CountryReaderInterface $countryReader)
    {
        $this->initEuListCache();
    }

    /**
     * @param \Ps\Shared\PaymentTransfer $paymentTransfer
     * @param float $amount
     *
     * @return float
     */
    public function calculate(PaymentTransfer $paymentTransfer, float $amount): float
    {
        $country = $this->countryReader->getCountry($paymentTransfer);
        $coefficient = $this->getCoefficientForCountry($country);

        return $amount * $coefficient;
    }

    /**
     * @param string $country
     *
     * @return float
     */
    private function getCoefficientForCountry(string $country): float
    {
        return in_array($country, self::$euListCache) ? self::COEFFICIENT_EU : self::COEFFICIENT_NON_EU;
    }

    /**
     * @throws \Ps\Business\Exception\EuListBrokenException
     * @throws \Ps\Business\Exception\EuListMissingException
     *
     * @return void
     */
    private function initEuListCache(): void
    {
        $euList = file_get_contents(AppBusinessConfig::EU_LIST_FILE_PATH);
        if (!$euList) {
            throw new EuListMissingException('EU countries list config is missing.');
        }

        $decodedEuList = json_decode($euList, true);
        if (!$decodedEuList) {
            throw new EuListBrokenException('EU countries list config is broken.');
        }

        self::$euListCache = $decodedEuList;
    }
}
