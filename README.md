# Symfony tool to check property affordability
# Requirements

- PHP 8.2
- Composer 2

# Running the command

Clone the project `git clone https://github.com/demoric102/property-affordability-checker.git`

Run `composer install`:

- `bin/console app:affordability-check ./files/properties.csv ./files/bank_statement.csv`

# Running the tests

- `./vendor/bin/phpunit`

# Features
- CSV File Parsing: Parses CSV files for properties and bank statements.

- Income and Expense Calculation: Calculates income and expenses from a bank statement.

- Affordability Check: Determines if the tenant can afford properties based on their disposable income.

- Command-Line Interface: A Symfony-based command-line tool for affordability checking.

# Principles
This project follows SOLID principles for code design:

- Single Responsibility Principle: Each service has a single responsibility (e.g., BankStatementService only handles bank statement calculations).

- Open/Closed Principle: The system is open for extension but closed for modification. New features or changes can be added without modifying existing code.

- Liskov Substitution Principle: Interfaces are used for service abstraction, ensuring that classes can be substituted without affecting functionality.

- Interface Segregation Principle: Services implement small, focused interfaces for their functionality.

- Dependency Inversion Principle: The system depends on abstractions (interfaces) rather than concrete implementations.

# Design Patterns

- Service Pattern provices a structured approach to accessing and managing the business logic while using the controllers for handling http requests.
