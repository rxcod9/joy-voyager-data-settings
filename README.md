# Joy VoyagerDataSettings

This [Laravel](https://laravel.com/)/[Voyager](https://voyager.devdojo.com/) module adds VoyagerDataSettings support to Voyager.

By 🐼 [Ramakant Gangwar](https://github.com/rxcod9).

[![Screenshot](https://raw.githubusercontent.com/rxcod9/joy-voyager-data-settings/main/cover.jpg)](https://joy-voyager.herokuapp.com/)

[![Latest Version](https://img.shields.io/github/v/release/rxcod9/joy-voyager-data-settings?style=flat-square)](https://github.com/rxcod9/joy-voyager-data-settings/releases)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/rxcod9/joy-voyager-data-settings/run-tests?label=tests)
[![Total Downloads](https://img.shields.io/packagist/dt/joy/voyager-data-settings.svg?style=flat-square)](https://packagist.org/packages/joy/voyager-data-settings)

---

## Prerequisites

*   Composer Installed
*   [Install Laravel](https://laravel.com/docs/installation)
*   [Install Voyager](https://github.com/the-control-group/voyager)

---

## Installation

```bash
# 1. Require this Package in your fresh Laravel/Voyager project
composer require joy/voyager-data-settings

# 2. Publish
php artisan vendor:publish --provider="Joy\VoyagerDataSettings\VoyagerDataSettingsServiceProvider" --force
# 3. Migrate
php artisan migrate
# 4. Generate Permissions & Attach Permissions with roles
php artisan db:seed --class="\Joy\VoyagerDataSettings\Database\Seeders\VoyagerDatabaseSeeder"
# 5. Seed data setting types (Optional)
php artisan db:seed --class="\Joy\VoyagerDataSettings\Database\Seeders\VoyagerDummyDatabaseSeeder"
```

---


## Working Example

You can try laravel demo here [https://joy-voyager.herokuapp.com/admin/users/1/settings](https://joy-voyager.herokuapp.com/admin/users/1/settings)
OR
[https://joy-voyager.herokuapp.com/admin/roles/1/settings](https://joy-voyager.herokuapp.com/admin/roles/1/settings).

## Documentation

Find yourself stuck using the package? Found a bug? Do you have general questions or suggestions for improving the joy voyager-data-settings? Feel free to [create an issue on GitHub](https://github.com/rxcod9/joy-voyager-data-settings/issues), we'll try to address it as soon as possible.

If you've found a bug regarding security please mail [gangwar.ramakant@gmail.com](mailto:gangwar.ramakant@gmail.com) instead of using the issue tracker.

## Testing

You can run the tests with:

```bash
vendor/bin/phpunit
```

## Upgrading

Please see [UPGRADING](UPGRADING.md) for details.

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email [gangwar.ramakant@gmail.com](mailto:gangwar.ramakant@gmail.com) instead of using the issue tracker.

## Credits

- [Ramakant Gangwar](https://github.com/rxcod9)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
