<?php

namespace Ps\Business\RateReader;

/**
 * @hint Cacher was implemented to be used with `ExchangeRatesApi` so not to have multiple calls.
 */
interface RateCacherInterface
{
    /**
     * @return array<string, float>|null
     */
    public function findRates(): ?array;

    /**
     * @param array<string, float> $rates
     *
     * @return void
     */
    public function setRates(array $rates): void;
}
