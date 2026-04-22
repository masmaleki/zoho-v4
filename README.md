


# Zoho all in one for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/masmaleki/zoho-v4.svg?style=flat-square)](https://packagist.org/packages/masmaleki/zoho-v4)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/masmaleki/zoho-v4/run-tests?label=tests)](https://github.com/masmaleki/zoho-v4/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/masmaleki/zoho-v4/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/masmaleki/zoho-v4/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/masmaleki/zoho-v4.svg?style=flat-square)](https://packagist.org/packages/masmaleki/zoho-v4)

Laravel Package for integration ZOHO version 3 API.

## Installation

You can install the package via composer:

```bash
composer require masmaleki/zoho-v4
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="zoho-v4-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="zoho-v4-config"
```

This is the contents of the published config file:

```php
return [
];
```

<!-- ## Usage

```php
$zohoAllInOne = new masmaleki\ZohoAllInOne();
echo $zohoAllInOne->echoPhrase('Hello, masmaleki!');
``` -->

<!-- ## Testing

```bash
composer test
``` -->

## Upgrading from `masmaleki/zoho-v3`

This package was previously published as `masmaleki/zoho-v3`. Version 4 renames both the
Composer package and the underlying database table (`zoho_v3` → `zoho_v4`) and introduces
multi-organization token support.

To upgrade from v3:

1. Update the requirement in your `composer.json`:

    ```bash
    composer remove masmaleki/zoho-v3
    composer require masmaleki/zoho-v4
    ```

2. Re-publish the migrations and run them. The package ships two upgrade migrations
   that detect existing v3 data and migrate it in place — both are idempotent and
   safe to re-run:

    ```bash
    php artisan vendor:publish --tag="zoho-v4-migrations"
    php artisan migrate
    ```

   - `rename_zoho_v3_to_zoho_v4_table` renames the existing `zoho_v3` table to
     `zoho_v4` (no-op on fresh installs).
   - `add_organization_id_to_zoho_v4_table` adds the `organization_id` column
     required by the multi-organization feature (no-op if already present).

3. Re-publish the config (it has been renamed to `config/zoho-v4.php`) and copy
   any custom values from your old `config/zoho-v3.php`:

    ```bash
    php artisan vendor:publish --tag="zoho-v4-config"
    ```

   Update any `config('zoho-v3.*')` calls in your application code to
   `config('zoho-v4.*')`.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mohammad Sadegh Maleki](https://github.com/masmaleki)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
