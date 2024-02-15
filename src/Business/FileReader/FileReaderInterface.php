<?php

namespace Ps\Business\FileReader;

interface FileReaderInterface
{
    /**
     * Specification:
     * - Reads a file from the specified path.
     * - Returns file content.
     *
     * @param string $path
     *
     * @throws \Ps\Business\Exception\CanNotReadFileException
     * @throws \Ps\Business\Exception\FileIsEmptyException
     *
     * @return string
     */
    public function readFile(string $path): string;

    /**
     * Specification:
     * - Splits the file content to separate lines using specified delimiter.
     *
     * @param string $content
     *
     * @return list<string>
     */
    public function splitContent(string $content): array;
}
