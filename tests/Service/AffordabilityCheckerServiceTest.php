<?php

namespace App\Tests\Service;

use App\Service\AffordabilityCheckerService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Service\AffordabilityCheckerService
 */
class AffordabilityCheckerServiceTest extends TestCase
{
    /**
     * Test the affordability checker for properties.
     *
     * @return void
     */
    public function testGetAffordableProperties(): void
    {
        $affordabilityChecker = new AffordabilityCheckerService();
        
        // Mock data
        $properties = [
            ['Id' => 1, 'Address' => '99 Brackley Road', 'Price (pcm)' => '300'],
            ['Id' => 2, 'Address' => '103 Ploughley Rd', 'Price (pcm)' => '310'],
        ];
        $income = 1000;
        $expenses = 200;
        $disposableIncome = $income - $expenses;

        // Test affordable properties
        $affordableProperties = $affordabilityChecker->getAffordableProperties($properties, $income, $expenses);

        // Assert expected result
        $this->assertCount(2, $affordableProperties); // Only 1 property should be affordable
        $this->assertEquals('99 Brackley Road', $affordableProperties[0]['Address']);
    }
}