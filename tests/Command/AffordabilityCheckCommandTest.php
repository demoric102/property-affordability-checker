<?php

namespace App\Tests\Command;

use App\Command\AffordabilityCheckCommand;
use App\Service\ICsvParserService;
use App\Service\IBankStatementService;
use App\Service\IAffordabilityCheckerService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * @covers \App\Command\AffordabilityCheckCommand
 */
class AffordabilityCheckCommandTest extends TestCase
{
    /**
     * Test the AffordabilityCheckCommand.
     *
     * @return void
     */
    public function testAffordabilityCheckCommand(): void
    {
        // Mock the services
        $csvParserServiceMock = $this->createMock(ICsvParserService::class);
        $bankStatementServiceMock = $this->createMock(IBankStatementService::class);
        $affordabilityCheckerServiceMock = $this->createMock(IAffordabilityCheckerService::class);

        // Mock CSV data
        $properties = [
            ['Id' => 1, 'Address' => '99 Brackley Road', 'Price (pcm)' => '300'],
            ['Id' => 2, 'Address' => '103 Ploughley Rd', 'Price (pcm)' => '310'],
        ];
        $bankStatement = [
            ['PaymentType' => 'Bank Credit', 'MoneyIn' => '£500.00'],
            ['PaymentType' => 'Card Payment', 'MoneyOut' => '£50.00'],
        ];

        // Configure the csvParserServiceMock to return the mock data for the respective paths
        $csvParserServiceMock
            ->method('parseCsvFile')
            ->willReturnCallback(function($filePath) use ($properties, $bankStatement) {
                if ($filePath === '../../files/properties.csv') {
                    return $properties;
                }
                if ($filePath === '../../files/bank_statement.csv') {
                    return $bankStatement;
                }
                return [];
            });

        // Configure the bankStatementServiceMock
        $bankStatementServiceMock
            ->method('calculateIncomeAndExpenses')
            ->willReturn(['income' => 500, 'expenses' => 50]);

        // Configure the affordabilityCheckerServiceMock
        $affordabilityCheckerServiceMock
            ->method('getAffordableProperties')
            ->willReturn($properties);

        // Instantiate the command and set up the application
        $command = new AffordabilityCheckCommand(
            $csvParserServiceMock,
            $bankStatementServiceMock,
            $affordabilityCheckerServiceMock
        );

        $application = new Application();
        $application->add($command);

        // Create a command tester and execute it
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'propertiesPath' => '../../files/properties.csv',
            'bankStatementPath' => '../../files/bank_statement.csv',
        ]);

        // Get the output and assert that it contains the expected results
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Property: 99 Brackley Road - Rent: £300', $output);
        $this->assertStringContainsString('Property: 103 Ploughley Rd - Rent: £310', $output);
        $this->assertStringContainsString('Income: £500', $output);
        $this->assertStringContainsString('Expenses: £50', $output);
    }
}