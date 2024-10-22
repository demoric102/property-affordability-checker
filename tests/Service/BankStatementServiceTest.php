<?php

namespace App\Tests\Service;

use App\Service\BankStatementService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Service\BankStatementService
 */
class BankStatementServiceTest extends TestCase
{
    /**
     * Test the calculation of income and expenses from a bank statement.
     *
     * @return void
     */
    public function testCalculateIncomeAndExpenses(): void
    {
        $bankStatementService = new BankStatementService();
        
        // Example mock data
        $mockBankStatement = [
            ['PaymentType' => 'Bank Credit', 'MoneyIn' => '£500.00'],
            ['PaymentType' => 'Direct Debit', 'MoneyOut' => '£50.00'],
        ];

        // Test the calculation
        $result = $bankStatementService->calculateIncomeAndExpenses($mockBankStatement);

        $this->assertEquals(500.00, $result['income']);
        $this->assertEquals(50.00, $result['expenses']);
    }
}