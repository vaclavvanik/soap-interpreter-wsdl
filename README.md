# Soap Interpreter Wsdl

Enhances basic [soap-interpreter](https://github.com/vaclavvanik/soap-interpreter) with [soap-wsdl](https://github.com/vaclavvanik/soap-wsdl).

## Install

You can install this package via composer. 

``` bash
composer require vaclavvanik/soap-interpreter-wsdl
```

For usage with WSDL over HTTP install with [soap-wsdl-http](https://github.com/vaclavvanik/soap-wsdl-http) package.

``` bash
composer require vaclavvanik/soap-interpreter-wsdl vaclavvanik/soap-wsdl-http
```

## Usage

### Create WsdlInterpreter:

```php
<?php

declare(strict_types=1);

use VaclavVanik\Soap\Interpreter\WsdlInterpreter;
use VaclavVanik\Soap\Wsdl\FileProvider;

$wsdlProvider = new FileProvider('my-service.wsdl');
$interpreter = new WsdlInterpreter($wsdlProvider);
```

## Exceptions

- [Exception\Wsdl](src/Exception/Wsdl.php) if wsdl provider throws exception.

## Run check - coding standards and php-unit

Install dependencies:

```bash
make install
```

Run check:

```bash
make check
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
