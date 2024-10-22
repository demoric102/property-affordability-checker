<?php

namespace App\Service;

class AffordabilityCheckerService implements IAffordabilityChecker
{
    /**
     * Get a list of affordable properties based on income and expenses.
     *
     * @param array $properties List of properties.
     * @param float $income Tenant's income.
     * @param float $expenses Tenant's expenses.
     * @return array List of affordable properties.
     */
    public function getAffordableProperties(array $properties, float $income, float $expenses): array
    {
        $affordableProperties = [];
        $disposableIncome = $income - $expenses;

        foreach ($properties as $property) {
            // Ensure 'Price (pcm)' key exists before accessing it
            if (isset($property['Price (pcm)'])) {
                $rent = (float) $property['Price (pcm)'];

                // Check if the property is affordable based on the tenant's disposable income
                if ($this->isAffordable($rent, $disposableIncome)) {
                    $affordableProperties[] = $property;
                }
            } else {
                // Optionally, handle or log the missing 'Price (pcm)' key case
                // e.g., $this->logger->warning("Property missing 'Price (pcm)'");
            }
        }

        return $affordableProperties;
    }

    /**
     * Determine if the property is affordable based on disposable income.
     *
     * @param float $rent The property rent.
     * @param float $disposableIncome The tenant's disposable income.
     * @return bool True if the property is affordable, false otherwise.
     */
    private function isAffordable(float $rent, float $disposableIncome): bool
    {
        // Tenant can afford the property if disposable income exceeds rent by 125% of the rent
        return $disposableIncome > ($rent * 1.25);
    }
}