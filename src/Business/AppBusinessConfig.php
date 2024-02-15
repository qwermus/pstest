<?php

namespace Ps\Business;

class AppBusinessConfig
{
    /**
     * Specification:
     * - Contains a key for `bin` in JSON data.
     *
     * @var string
     */
    public const KEY_BIN = 'bin';

    /**
     * Specification:
     * - Contains a key for `amount` in JSON data.
     *
     * @var string
     */
    public const KEY_AMOUNT = 'amount';

    /**
     * Specification:
     * - Contains a key for `currency` in JSON data.
     *
     * @var string
     */
    public const KEY_CURRENCY = 'currency';

    /**
     * @var string
     */
    public const EU_LIST_FILE_PATH = __DIR__ . '/../Config/eu_list.json';
}
