<?php

namespace Ps\Business\RateReader;

class RateCacher implements RateCacherInterface
{
    /**
     * @var array<string, float>
     */
    private static array $rateCache;

    /**
     * @return array<string, float>|null
     */
    public function findRates(): ?array
    {
        return self::$rateCache ?? null;
    }

    /**
     * @param array<string, float> $rates
     *
     * @return void
     */
    public function setRates(array $rates): void
    {
        self::$rateCache = $rates;
    }
}
