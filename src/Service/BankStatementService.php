<?php

namespace App\Service;

use App\Traits\ParseCurrencyTrait;

/**
 * Service to calculate income and expenses based on a bank statement.
 */
class BankStatementService implements IBankStatement
{
    use ParseCurrencyTrait;

    private const INCOME_KEYWORDS = ['Bank Credit', 'Employer', 'Part Time Job'];
    private const EXPENSE_KEYWORDS = ['Direct Debit', 'Card Payment', 'ATM', 'Standing Order'];

    /**
     * Calculate the income and expenses from a bank statement.
     *
     * @param array $bankStatement The bank statement data.
     * @return array The income and expenses as an associative array.
     */
    public function calculateIncomeAndExpenses(array $bankStatement): array
    {
        $income = 0;
        $expenses = 0;

        foreach ($bankStatement as $transaction) {
            // Check if 'PaymentType', 'MoneyOut', and 'MoneyIn' keys exist in the transaction array
            if (!isset($transaction['PaymentType'])) {
                continue; // Skip the row if 'PaymentType' is missing
            }

            $paymentType = $transaction['PaymentType'];
            $moneyOut = $this->parseCurrency($transaction['MoneyOut'] ?? null); // Use null if 'MoneyOut' is missing
            $moneyIn = $this->parseCurrency($transaction['MoneyIn'] ?? null);   // Use null if 'MoneyIn' is missing

            if (in_array($paymentType, self::INCOME_KEYWORDS)) {
                $income += $moneyIn;
            } elseif (in_array($paymentType, self::EXPENSE_KEYWORDS)) {
                $expenses += $moneyOut;
            }
        }

        return [
            'income' => $income,
            'expenses' => $expenses,
        ];
    }
}