<?php

namespace App\Tests\Service;

use App\Service\CsvParserService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Service\CsvParserService
 */
class CsvParserServiceTest extends TestCase
{
    /**
     * Test parsing a CSV file.
     *
     * @return void
     */
    public function testParseCsvFile(): void
    {
        $csvParserService = new CsvParserService();
        
        // Create a mock CSV file
        $testCsv = [
            ['Id', 'Address', 'Price (pcm)'],
            [1, '99 Brackley Road', 300],
            [2, '103 Ploughley Rd', 310],
        ];

        // Write to a temporary CSV file
        $tempFile = tmpfile();
        foreach ($testCsv as $line) {
            fputcsv($tempFile, $line);
        }

        // Rewind the file pointer to the start
        fseek($tempFile, 0);

        // Convert the file path
        $csvPath = stream_get_meta_data($tempFile)['uri'];

        // Parse the CSV file
        $result = $csvParserService->parseCsvFile($csvPath);

        // Test the parsing
        $this->assertCount(2, $result); // We expect 2 rows (excluding header)
        $this->assertEquals('99 Brackley Road', $result[0]['Address']);
        $this->assertEquals('103 Ploughley Rd', $result[1]['Address']);
        fclose($tempFile);
    }
}