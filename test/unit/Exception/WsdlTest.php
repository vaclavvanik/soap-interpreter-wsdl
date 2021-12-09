<?php

declare(strict_types=1);

namespace VaclavVanikTest\Soap\Interpreter\Exception;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use VaclavVanik\Soap\Interpreter\Exception\Wsdl;

final class WsdlTest extends TestCase
{
    public function testFromThrowable(): void
    {
        $throwable = new RuntimeException('message', 1);
        $exception = Wsdl::fromThrowable($throwable);

        $this->assertSame($throwable->getMessage(), $exception->getMessage());
        $this->assertSame($throwable->getCode(), $exception->getCode());
        $this->assertSame($throwable, $exception->getPrevious());
    }
}
