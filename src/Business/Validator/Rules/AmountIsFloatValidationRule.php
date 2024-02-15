<?php

namespace Ps\Business\Validator\Rules;

use Ps\Business\AppBusinessConfig;

class AmountIsFloatValidationRule implements ValidatorRuleInterface
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
        $amount = $payment[AppBusinessConfig::KEY_AMOUNT] ?? null;
        if (!$amount) {
            return 'Amount is missing.';
        }

        if (filter_var($amount, FILTER_VALIDATE_FLOAT) === false) {
            return 'Amount should be a number.';
        }

        return null;
    }
}
