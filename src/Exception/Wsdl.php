<?php

declare(strict_types=1);

namespace VaclavVanik\Soap\Interpreter\Exception;

use RuntimeException;
use Throwable;

final class Wsdl extends RuntimeException implements Exception
{
    public static function fromThrowable(Throwable $e): self
    {
        return new self($e->getMessage(), $e->getCode(), $e);
    }
}
