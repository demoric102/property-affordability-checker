<?php

namespace App\Service;

/**
 * Interface for CSV Parser Service
 */
interface ICsvParser
{
    /**
     * Parse a CSV file and return its content as an associative array.
     *
     * @param string $filePath Path to the CSV file.
     * @return array The CSV data as an associative array.
     * @throws \Exception If the file cannot be opened.
     */
    public function parseCsvFile(string $filePath): array;
}