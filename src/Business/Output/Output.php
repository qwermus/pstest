<?php

namespace Ps\Business\Output;

class Output implements OutputInterface
{
    /**
     * {@inheritDoc}
     *
     * @param string $content
     *
     * @return void
     */
    public function print(string $content): void
    {
        echo $content . PHP_EOL;
    }
}
