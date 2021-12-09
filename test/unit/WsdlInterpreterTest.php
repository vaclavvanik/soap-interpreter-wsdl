<?php

declare(strict_types=1);

namespace VaclavVanikTest\Soap\Interpreter;

use PHPUnit\Framework\TestCase;
use Throwable;
use VaclavVanik\Soap\Interpreter\Exception\Wsdl;
use VaclavVanik\Soap\Interpreter\WsdlInterpreter;
use VaclavVanik\Soap\Wsdl\Exception\Runtime;
use VaclavVanik\Soap\Wsdl\WsdlProvider;

use function file_get_contents;

final class WsdlInterpreterTest extends TestCase
{
    public function testThrowWsdlException(): void
    {
        $exception = new Runtime('message', 1);

        $this->expectException(Wsdl::class);
        $this->expectExceptionMessage($exception->getMessage());

        $wsdlProvider = $this->mockWsdlProviderThrowException($exception);

        (new WsdlInterpreter($wsdlProvider))->request('sayHello');
    }

    public function testRequest(): void
    {
        $wsdlProvider = $this->mockWsdlProviderWithContent();

        (new WsdlInterpreter($wsdlProvider))->request('sayHello');
    }

    public function testResponse(): void
    {
        $wsdlProvider = $this->mockWsdlProviderWithContent();
        $data = file_get_contents(__DIR__ . '/../fixtures/wsdl-response11.xml');

        (new WsdlInterpreter($wsdlProvider))->response('sayHello', $data);
    }

    public function testCachedWsdlProvider(): void
    {
        $wsdlProvider = $this->mockWsdlProviderWithContent();

        $interpreter = new WsdlInterpreter($wsdlProvider);
        $interpreter->request('sayHello');
        $interpreter->request('sayHello');
    }

    private function mockWsdlProviderWithContent(): WsdlProvider
    {
        $data = file_get_contents(__DIR__ . '/../fixtures/soap11.wsdl');

        $wsdlProvider = $this->createMock(WsdlProvider::class);
        $wsdlProvider->expects($this->once())->method('provide')->willReturn($data);

        return $wsdlProvider;
    }

    private function mockWsdlProviderThrowException(Throwable $exception): WsdlProvider
    {
        $wsdlProvider = $this->createMock(WsdlProvider::class);
        $wsdlProvider->expects($this->once())->method('provide')->will($this->throwException($exception));

        return $wsdlProvider;
    }
}
