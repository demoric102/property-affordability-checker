<?php

namespace App\Service;

/**
 * Interface for Bank Statement Service
 */
interface IBankStatement
{
    /**
     * Calculate the total income and expenses from the bank statement.
     *
     * @param array $bankStatement Array of bank statement entries.
     * @return array Associative array with 'income' and 'expenses'.
     */
    public function calculateIncomeAndExpenses(array $bankStatement): array;
}