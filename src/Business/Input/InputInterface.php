<?php

namespace Ps\Business\Input;

interface InputInterface
{
    /**
     * Specification:
     * - Returns an argument from specified position.
     *
     * @param array<int, string> $argv
     * @param int $position
     *
     * @throws \Ps\Business\Exception\ArgumentIsMissingException
     *
     * @return string
     */
    public function getArgument(array $argv, int $position): string;
}
