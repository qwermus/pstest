<?php

namespace Ps\Business\Input;

use Ps\Business\Exception\ArgumentIsMissingException;

class Input implements InputInterface
{
    /**
     * {@inheritDoc}
     *
     * @param array<int, string> $argv
     * @param int $position
     *
     * @throws \Ps\Business\Exception\ArgumentIsMissingException
     *
     * @return string
     */
    public function getArgument(array $argv, int $position): string
    {
        $argument = $argv[$position] ?? null;
        if (!$argument) {
            throw new ArgumentIsMissingException('Not all arguments are provided.');
        }

        return $argument;
    }
}
