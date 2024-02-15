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
     * Specification:
     * - Contains a path to the file with the list of EU countries.
     *
     * @var string
     */
    public const EU_LIST_FILE_PATH = __DIR__ . '/../Config/eu_list.json';

    /**
     * Specification:
     * - Contains a path to the file with the list of bin-to-country relation for mocking purposes.
     *
     * @var string
     */
    public const COUNTRY_LIST_MOCK_FILE_PATH = __DIR__ . '/../Config/country_list_mock.json';

    /**
     * Specification:
     * - Contains a path to the file with the list of rates that are used instead of `ExchangeRatesApi` response.
     *
     * @var string
     */
    public const RATE_MOCK_FILE_PATH = __DIR__ . '/../Config/rate_mock.json';
}
