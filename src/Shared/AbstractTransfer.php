<?php

namespace Ps\Shared;

use Ps\Business\Exception\NullValueException;

abstract class AbstractTransfer
{
    /**
     * @param string $propertyName
     *
     * @throws \Ps\Business\Exception\NullValueException
     *
     * @return void
     */
    protected function throwNullValueException(string $propertyName): void
    {
        throw new NullValueException(
            sprintf('Property "%s" of transfer `%s` is null.', $propertyName, static::class),
        );
    }
}
