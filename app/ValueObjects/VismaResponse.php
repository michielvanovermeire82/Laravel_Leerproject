<?php

namespace App\ValueObjects;

class VismaResponse
{
    /**
     * @var string
     */
    private $rawJson;

    /**
     * @var
     */
    private $errorMessage = '';

    public function __construct(?string $rawJsonResponse)
    {
        $this->rawJson = $rawJsonResponse;
    }

    public function isValid(): bool
    {
        if (empty($this->rawJson)) {
            $this->errorMessage = 'Response was empty';
            return false;
        }

        $data = $this->getResponseAsArray();
        if (false !== empty($data)) {
            $this->errorMessage = 'Response did not contain valid JSON';
            return false;
        }

        return true;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function getResponseAsArray(): array
    {
        return json_decode($this->rawJson, true);
    }
}
