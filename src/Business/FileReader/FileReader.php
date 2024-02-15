<?php

namespace Ps\Business\FileReader;

use Ps\Business\Exception\CanNotReadFileException;
use Ps\Business\Exception\FileIsEmptyException;

class FileReader implements FileReaderInterface
{
    /**
     * @var string
     */
    private const CONTENT_DELIMITER = PHP_EOL;

    /**
     * {@inheritDoc}
     *
     * @param string $path
     *
     * @throws \Ps\Business\Exception\CanNotReadFileException
     * @throws \Ps\Business\Exception\FileIsEmptyException
     *
     * @return string
     */
    public function readFile(string $path): string
    {
        $content = file_get_contents($path);
        $this->assertContent($content, $path);

        return $content;
    }

    /**
     * {@inheritDoc}
     *
     * @param string $content
     *
     * @return list<string>
     */
    public function splitContent(string $content): array
    {
        return explode(self::CONTENT_DELIMITER, $content);
    }

    /**
     * @param string|bool $content
     * @param string $path
     *
     * @throws \Ps\Business\Exception\CanNotReadFileException
     * @throws \Ps\Business\Exception\FileIsEmptyException
     *
     * @return void
     */
    private function assertContent(string|bool $content, string $path): void
    {
        if ($content === false) {
            throw new CanNotReadFileException(
                sprintf('Can not read file "%s".', $path),
            );
        }

        if (!$content) {
            throw new FileIsEmptyException(
                sprintf('File "%s" is empty.', $path),
            );
        }
    }
}
