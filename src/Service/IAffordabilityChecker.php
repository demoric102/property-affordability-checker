<?php

namespace App\Service;

/**
 * Interface for Affordability Checker Service
 */
interface IAffordabilityChecker
{
    /**
     * Get all affordable properties based on income and expenses.
     *
     * @param array $properties List of properties.
     * @param float $income Monthly income.
     * @param float $expenses Monthly expenses.
     * @return array List of affordable properties.
     */
    public function getAffordableProperties(array $properties, float $income, float $expenses): array;
}