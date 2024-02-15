<?php

namespace Ps\Business\Decoder;

interface DecoderInterface
{
    /**
     * Specification:
     * - Decodes file content.
     * - Returns a key-value array.
     *
     * @param string $content
     *
     * @throws \Ps\Business\Exception\DecodeFailedException
     *
     * @return array<string, mixed>
     */
    public function decode(string $content): array;
}
