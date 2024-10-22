<?php

namespace App\Command;

use App\Service\ICsvParser;
use App\Service\IBankStatement;
use App\Service\IAffordabilityChecker;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Command to check property affordability based on bank statement data.
 */
#[AsCommand(name: 'app:affordability-check')]
class AffordabilityCheckCommand extends Command
{
    private ICsvParser $csvParserService;
    private IBankStatement $bankStatementService;
    private IAffordabilityChecker $affordabilityCheckerService;

    /**
     * @param ICsvParser $csvParserService
     * @param IBankStatement $bankStatementService
     * @param IAffordabilityChecker $affordabilityCheckerService
     */
    public function __construct(
        ICsvParser $csvParserService,
        IBankStatement $bankStatementService,
        IAffordabilityChecker $affordabilityCheckerService
    ) {
        parent::__construct();
        $this->csvParserService = $csvParserService;
        $this->bankStatementService = $bankStatementService;
        $this->affordabilityCheckerService = $affordabilityCheckerService;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Check affordability based on bank statement data.')
            ->addArgument('propertiesPath', InputArgument::REQUIRED, 'The path to the properties CSV file.')
            ->addArgument('bankStatementPath', InputArgument::REQUIRED, 'The path to the bank statement CSV file.');
    }

    /**
     * Executes the command.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $properties = $this->csvParserService->parseCsvFile($input->getArgument('propertiesPath'));
        $bankStatement = $this->csvParserService->parseCsvFile($input->getArgument('bankStatementPath'));

        // Calculate income and expenses
        $incomeAndExpenses = $this->bankStatementService->calculateIncomeAndExpenses($bankStatement);

        $income = $incomeAndExpenses['income'] ?? 0.00;
        $expenses = $incomeAndExpenses['expenses'] ?? 0.00;

        // Output the calculated income and expenses for debugging
        $output->writeln("Income: £$income");
        $output->writeln("Expenses: £$expenses");

        // Get affordable properties
        $affordableProperties = $this->affordabilityCheckerService->getAffordableProperties($properties, $income, $expenses);

        // Output the results
        if (empty($affordableProperties)) {
            $output->writeln("No affordable properties found.");
        } else {
            foreach ($affordableProperties as $property) {
                $output->writeln('Property: ' . $property['Address'] . ' - Rent: £' . $property['Price (pcm)']);
            }
        }

        return Command::SUCCESS;
    }
}