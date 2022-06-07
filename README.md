# Thingston Coverage Check

Console script to check code coverage using Clover reports.

## Requirements

- PHP 8.1

## Instalation

`composer require thingston/coverage-check`

## Usage

From your project root run:

`php vendor/bin/phpcov /path/to/coverage.xml 99`

Or just this one to get more help:

`php vendor/bin/phpcov --help`

## Testing

Available Composer scripts:

- `composer run test` - Runs all tests using PHPUnit.
- `composer run coverage:text` - Runs all tests using PHPUnit and generates a coverage report to the console.
- `composer run coverage:clover` - Runs all tests using PHPUnit and generates an XML coverage report to file `coverage.xml`.
- `composer run coverage:html` - Runs all tests using PHPUnit and generates an XML coverage report to directory `coverage`.
- `composer run coverage:check` - Runs the `coverage:clover` script and checks the code coverage rate (requires >= 90%).
- `composer run analyze` - Runs the PHPStan static analysis and displays the results to the console.
- `composer run cs` - Runs the Code Sniffer static analysis and displays any errors to the console.
- `composer run cbf` - Runs the Code Sniffer code fixer and displays the results to the console.
- `composer run checks` - Runs the scripts `cs`, `analyze` and `coverage:check` and displays the results to the console.

## Support

- Issues: https://github.com/thingston/coverage-check/issues
- Documentation: https://github.com/thingston/coverage-check/wiki