<?php

namespace App\Traits;

use Exception;

/**
 * Trait CsvParserTrait
 *
 * Provides a method to parse CSV files into an array.
 */
trait CsvParserTrait
{
    /**
     * Parse a CSV file into an array.
     *
     * @param string $filePath The path to the CSV file.
     * @return array The parsed CSV data as an array.
     * @throws Exception if the file cannot be opened.
     */
    public function parseCsvFile(string $filePath): array
    {
        $data = [];
        if (($csvFile = fopen($filePath, 'r')) !== false) {
            $header = fgetcsv($csvFile); // Get header row
            while (($row = fgetcsv($csvFile)) !== false) {
                $data[] = array_combine($header, $row); // Combine header with row data
            }
            fclose($csvFile);
        } else {
            throw new Exception("Unable to open file: $filePath");
        }
        return $data;
    }
}