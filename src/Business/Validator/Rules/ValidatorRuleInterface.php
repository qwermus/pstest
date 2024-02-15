<?php

namespace Ps\Business\Validator\Rules;

interface ValidatorRuleInterface
{
    /**
     * Specification:
     * - Validates provided data.
     * - Returns null when data is correct.
     * - Returns error message when data is wrong.
     *
     * @param array<string, mixed> $payment
     *
     * @return string|null
     */
    public function validate(array $payment): ?string;
}
