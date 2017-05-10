# Testing

Tests make sure that the functionality we're writing is stable. This document will outline how to run the tests, as well as what's included in the tests themselves.

## Usage

To run tests locally, you must...

1. Visit [phpunit.xml.dist](../../phpunit.xml.dist) in the root directory and update it with settings for your development environment.
2. Run `composer test`.

## Testing

The tests include a few different components...

### PHPUnit

[PHPUnit](https://phpunit.de/) runs a few functional and unit tests. 

-   BrowserTestExampleTest: Runs a headless web browser to test functionality on the site.
-   KernelTestExampleTest: Has access to files and the database, but the environment is empty.
-   UnitTestExampleTest: Unit tests that don't have access to the database.
-   WebTestExampleTest: Test that uses the legacy SimpleTest system. It's recommended to use the BrowserTest instead.

To run the PHPUnit unit tests, execute:

```
vendor/bin/phpunit path/to/src/TestClass.php
```

If phpunit is not available, you can run it through `vendor/bin/phpunit`.

### PHP Code Sniffer

[PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) runs some static analysis on the files to make sure our custom modules abide by the [Drupal Coding Standards](https://www.drupal.org/docs/develop/standards) through the use of [Coder](https://www.drupal.org/project/coder).

To run the tests, execute:

```
vendor/bin/phpcs --config-set installed_paths vendor/drupal/coder/coder_sniffer
vendor/bin/phpcs --standard=Drupal web/modules/custom
vendor/bin/phpcs --standard=Drupal web/themes
```

If phpcs is not available, you can run it through `vendor/bin/phpcs`.
