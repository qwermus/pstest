<?php

namespace Ps\Business\Output;

interface OutputInterface
{
    /**
     * Specification:
     * - Prints the line on screen.
     *
     * @param string $content
     *
     * @return void
     */
    public function print(string $content): void;
}
