<?php

declare(strict_types=1);

namespace VaclavVanik\Soap\Interpreter;

use VaclavVanik\Soap\Wsdl;

final class WsdlInterpreter implements Interpreter
{
    /** @var Wsdl\WsdlProvider */
    private $provider;

    /** @var PhpInterpreter|null */
    private $interpreter;

    /** @var int|null */
    private $features;

    /** @var string|null */
    private $location;

    /** @var int|null */
    private $soapVersion;

    /**
     * @param int|null    $soapVersion Should be one of either SOAP_1_1 or SOAP_1_2. If null, 1.1 is used
     * @param int|null    $features    Bitmask of SOAP_SINGLE_ELEMENT_ARRAYS, SOAP_USE_XSI_ARRAY_TYPE,
     *       SOAP_WAIT_ONE_WAY_CALLS. Defaults is SOAP_SINGLE_ELEMENT_ARRAYS
     * @param string|null $location    URL of the SOAP server to send the request
     */
    public function __construct(
        Wsdl\WsdlProvider $provider,
        ?int $soapVersion = null,
        ?int $features = null,
        ?string $location = null
    ) {
        $this->provider = $provider;
        $this->features = $features;
        $this->location = $location;
        $this->soapVersion = $soapVersion;
    }

    /** @inheritdoc */
    public function request(string $operation, array $parameters = [], array $soapHeaders = []): Request
    {
        return $this->interpreter()->request($operation, $parameters, $soapHeaders);
    }

    public function response(string $operation, string $response): Response
    {
        return $this->interpreter()->response($operation, $response);
    }

    /** @throws Exception\Wsdl */
    private function interpreter(): Interpreter
    {
        if ($this->interpreter) {
            return $this->interpreter;
        }

        $this->interpreter = PhpInterpreter::fromWsdl(
            $this->wsdl(),
            $this->soapVersion,
            $this->features,
            $this->location,
        );

        return $this->interpreter;
    }

    /** @throws Exception\Wsdl */
    private function wsdl(): string
    {
        try {
            return Wsdl\Utils::toDataUrl($this->provider->provide());
        } catch (Wsdl\Exception\Exception $e) {
            throw Exception\Wsdl::fromThrowable($e);
        }
    }
}
