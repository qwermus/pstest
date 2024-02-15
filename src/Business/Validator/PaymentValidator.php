<?php

namespace Ps\Business\Validator;

use Ps\Business\Exception\ValidationFailedException;

class PaymentValidator implements ValidatorInterface
{
    /**
     * @param list<\Ps\Business\Validator\Rules\ValidatorRuleInterface> $validationRules
     */
    public function __construct(private array $validationRules)
    {
    }

    /**
     * {@inheritDoc}
     *
     * @param array<string, mixed> $payment
     *
     * @throws \Ps\Business\Exception\ValidationFailedException
     *
     * @return void
     */
    public function validate(array $payment): void
    {
        foreach ($this->validationRules as $validationRule) {
            $error = $validationRule->validate($payment);
            if ($error === null) {
                continue;
            }

            throw new ValidationFailedException(
                sprintf('%s. Provided data: "%s"', $error, json_encode($payment)),
            );
        }
    }
}
