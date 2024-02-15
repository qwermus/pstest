<?php

namespace Ps\Business\Validator\Rules;

use Ps\Business\AppBusinessConfig;

class BinContainsFourDigitsValidationRule implements ValidatorRuleInterface
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
        $bin = $payment[AppBusinessConfig::KEY_BIN] ?? null;
        if (!$bin) {
            return 'BIN is missing.';
        }

        if (!preg_match('/^\d{4,18}$/', $bin)) {
            return 'BIN should contain 4-18 digits.';
        }

        return null;
    }
}
