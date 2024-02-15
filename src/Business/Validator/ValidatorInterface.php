<?php

namespace Ps\Business\Validator;

interface ValidatorInterface
{
    /**
     * Specification:
     * - Validates provided payment data.
     * - Throws an exception on first failed validation.
     *
     * @param array<string, mixed> $payment
     *
     * @throws \Ps\Business\Exception\ValidationFailedException
     *
     * @return void
     */
    public function validate(array $payment): void;
}
