# A Filament plugin to display Volet Feature Board data

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mydnic/volet-feature-board-filament-plugin.svg?style=flat-square)](https://packagist.org/packages/mydnic/volet-feature-board-filament-plugin)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mydnic/volet-feature-board-filament-plugin/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/mydnic/volet-feature-board-filament-plugin/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/mydnic/volet-feature-board-filament-plugin/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/mydnic/volet-feature-board-filament-plugin/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mydnic/volet-feature-board-filament-plugin.svg?style=flat-square)](https://packagist.org/packages/mydnic/volet-feature-board-filament-plugin)

Add a simple Resource page to your Filament panel to display Volet Feature Board data.

## Installation

You can install the package via composer:

```bash
composer require mydnic/volet-feature-board-filament-plugin
```

## Usage

```php
use Mydnic\VoletFeatureBoardFilamentPlugin\VoletFeatureBoardFilamentPlugin;
// ...

return $panel
    ->plugin(new VoletFeatureBoardFilamentPlugin());
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Clément Rigo](https://github.com/Mydnic)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
