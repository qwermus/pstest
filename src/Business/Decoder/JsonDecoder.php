<?php

namespace Ps\Business\Decoder;

use Ps\Business\Exception\DecodeFailedException;

class JsonDecoder implements DecoderInterface
{
    /**
     * {@inheritDoc}
     *
     * @param string $content
     *
     * @throws \Ps\Business\Exception\DecodeFailedException
     *
     * @return array<string, string>
     */
    public function decode(string $content): array
    {
        $decodedContent = json_decode($content, true);
        if (!$decodedContent) {
            throw new DecodeFailedException(
                sprintf('Failed to decode a JSON string "%s"', $content),
            );
        }

        return $decodedContent;
    }
}
