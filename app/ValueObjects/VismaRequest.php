<?php

namespace App\ValueObjects;

class VismaRequest
{
    public const SUPPORTED_ENDPOINTS = [
        'ledger',
        'account',
    ];

    private $endpoint;

    /**
     * VismaRequest constructor.
     * @param string $endpoint
     */
    public function __construct(string $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return in_array($this->endpoint, self::SUPPORTED_ENDPOINTS);
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }
}
