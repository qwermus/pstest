<?php

namespace Ps\Business\CountryReader;

use Ps\Business\Exception\BinListBrokenException;
use Ps\Shared\PaymentTransfer;

class BinListCountryReader implements CountryReaderInterface
{
    /**
     * @var string
     */
    private const BIN_LIST_URL = 'https://lookup.binlist.net/%s';

    /**
     * @var string
     */
    private const KEY_COUNTRY = 'country';

    /**
     * @var string
     */
    private const KEY_ALPHA2 = 'alpha2';

    /**
     * {@inheritDoc}
     *
     * @hint If there can be same bins, it's better to introduce static cache to avoid multiple connections.
     *
     * @param \Ps\Shared\PaymentTransfer $paymentTransfer
     *
     * @throws \Ps\Business\Exception\BinListBrokenException
     * @throws \Ps\Business\Exception\NullValueException
     *
     * @return string
     */
    public function getCountry(PaymentTransfer $paymentTransfer): string
    {
        $cardInfo = $this->getCardInfo(
            $paymentTransfer->getBinOrFail(),
        );

        return $this->getAlpha2($cardInfo);
    }

    /**
     * @param string $bin
     *
     * @throws \Ps\Business\Exception\BinListBrokenException
     *
     * @return array<string, mixed>
     */
    private function getCardInfo(string $bin): array
    {
        $contents = $this->performRequest($bin);
        if (!$contents) {
            throw new BinListBrokenException(
                sprintf('Can not get country by BIN "%s".', $bin),
            );
        }

        $cardInfo = json_decode($contents, true);
        if (!$cardInfo) {
            throw new BinListBrokenException(
                sprintf('Can not decode country info by BIN "%s".', $bin),
            );
        }

        return $cardInfo;
    }

    /**
     * @param string $bin
     *
     * @throws \Ps\Business\Exception\BinListBrokenException
     *
     * @return string
     */
    private function performRequest(string $bin): string
    {
        $ch = curl_init(sprintf(self::BIN_LIST_URL, $bin));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $contents = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new BinListBrokenException(
                sprintf('Can not get country by BIN "%s": %s.', $bin, curl_error($ch)),
            );
        }
        curl_close($ch);

        return $contents;
    }

    /**
     * @param array<string, mixed> $cardInfo
     *
     * @throws \Ps\Business\Exception\BinListBrokenException
     *
     * @return string
     */
    private function getAlpha2(array $cardInfo): string
    {
        $alpha2 = $cardInfo[self::KEY_COUNTRY][self::KEY_ALPHA2] ?? null;
        if (!$alpha2) {
            throw new BinListBrokenException(
                sprintf('Country info is wrong. Provided: "%s".', json_encode($cardInfo)),
            );
        }

        return $alpha2;
    }
}
