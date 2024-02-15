<?php

namespace Ps\Business\CountryReader;

use Ps\Business\Exception\BinDataIsBrokenException;
use Ps\Business\Exception\BinDataIsMissingException;
use Ps\Business\Exception\CountryIsMissingException;
use Ps\Shared\PaymentTransfer;

/**
 * This reader was introduced because `binlist.net` service has limit 5 request per hour.
 */
class FileCountryReader implements CountryReaderInterface
{
    /**
     * @var string
     */
    private const FILE_PATH = PROJECT_DIR . '/Config/country_list_mock.json';

    /**
     * {@inheritDoc}
     *
     * @param \Ps\Shared\PaymentTransfer $paymentTransfer
     *
     * @throws \Ps\Business\Exception\BinDataIsBrokenException
     * @throws \Ps\Business\Exception\BinDataIsMissingException
     * @throws \Ps\Business\Exception\CountryIsMissingException
     * @throws \Ps\Business\Exception\NullValueException
     *
     * @return string
     */
    public function getCountry(PaymentTransfer $paymentTransfer): string
    {
        $countries = $this->getCountries();
        $country = $countries[$paymentTransfer->getBinOrFail()] ?? null;
        if (!$country) {
            throw new CountryIsMissingException(
                sprintf('Can not get country by BIN code. Please, extend "%s" file.', self::FILE_PATH),
            );
        }

        return $country;
    }

    /**
     * @hint Static cache is not used here because it's temporary solution for testing purposes only.
     *
     * @throws \Ps\Business\Exception\BinDataIsBrokenException
     * @throws \Ps\Business\Exception\BinDataIsMissingException
     *
     * @return array<string, string>
     */
    private function getCountries(): array
    {
        $countries = file_get_contents(self::FILE_PATH);
        if (!$countries) {
            throw new BinDataIsMissingException('Can not read countries data.');
        }

        $decodedCountries = json_decode($countries, true);
        if (!$decodedCountries) {
            throw new BinDataIsBrokenException('Can not decode countries data.');
        }

        return $decodedCountries;
    }
}
