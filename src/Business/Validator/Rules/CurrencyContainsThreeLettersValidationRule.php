<?php

namespace Ps\Business\Validator\Rules;

use Ps\Business\AppBusinessConfig;

class CurrencyContainsThreeLettersValidationRule implements ValidatorRuleInterface
{
    /**
     * {@inheritDoc}
     *
     * @param array<string, mixed> $payment
     *
     * @return string|null
     */
    public function validate(array $payment): ?string
    {
        $currency = $payment[AppBusinessConfig::KEY_CURRENCY] ?? null;
        if (!$currency) {
            return 'Currency is missing.';
        }

        if (!preg_match('/^[A-Z]{3}$/', $currency)) {
            return 'Currency has wrong format.';
        }

        return null;
    }
}
