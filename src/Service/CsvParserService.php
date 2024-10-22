<?php

namespace App\Service;

use App\Traits\CsvParserTrait;

/**
 * Service for parsing CSV files.
 */
class CsvParserService implements ICsvParser
{
    use CsvParserTrait;
}