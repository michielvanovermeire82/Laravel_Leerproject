<?php

namespace App\Services;

use App\Http\Controllers\Api\RestApiController;
use App\ValueObjects\VismaRequest;
use App\ValueObjects\VismaResponse;
use ErrorException;
use InvalidArgumentException;

use function curl_close;
use function curl_error;
use function curl_exec;
use function curl_init;
use function curl_setopt;

use const CURLOPT_CONNECTTIMEOUT;
use const CURLOPT_FOLLOWLOCATION;
use const CURLOPT_HTTPHEADER;
use const CURLOPT_RETURNTRANSFER;
use const CURLOPT_SSL_VERIFYHOST;
use const CURLOPT_SSL_VERIFYPEER;
use const CURLOPT_URL;

class VismaRestApiService
{
    public function getVismaRequest($endpoint)
    {
        $curl = curl_init();
        $timeout = 5;

        $supportedEndpoints = ['account', 'ledger'];
        if(!in_array($endpoint, $supportedEndpoints)) {
            throw new \InvalidArgumentException(
                'Endpoint not supported: '
                       . $endpoint. '. Expected one of the following: '
                       . implode(', ', $supportedEndpoints));
        }

        $url = "https://integration.visma.net/API/controller/api/v1/" . $endpoint;
        curl_setopt($curl, CURLOPT_URL, $url);

        $parameterValue = 'false';
        $parameters = ['active' => $parameterValue];
        $url = $endpoint . '?' . http_build_query($parameters);
        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'ipp-company-id: 1228107',
                'Authorization: Bearer 3ff9a6f6-cf6d-4ec5-a2a1-7e2671d884a3'
            )
        );
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);

        $certificateLocation = '/usr/local/openssl-0.9.8/certs/cacert.pem';
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $certificateLocation);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $certificateLocation);

        $response = curl_exec($curl);

        $error = curl_error($curl);
        curl_close($curl);

        if ($error) {
            throw new ErrorException("cURL Error #: " . $error);
        }

        return $response;
    }


    /**Endpoint n
     * @param string $endpoint
     * @return VismaRequest
     */
    public function buildRequest(string $endpoint): VismaRequest
    {
        $request = new VismaRequest($endpoint);
        if (false === $request->isValid()) {
            throw new \InvalidArgumentException(
                'Endpoint not supported: '
                . $endpoint. '. Expected one of the following: '
                . implode(', ', VismaRequest::SUPPORTED_ENDPOINTS));
        }

        return $request;
    }

    /**
     * @param VismaRequest $request
     * @return bool|string
     * @throws ErrorException
     */
    public function sendRequest(VismaRequest $request): VismaResponse
    {
        $curl = curl_init();
        $timeout = 5;

        $url = "https://integration.visma.net/API/controller/api/v1/" . $request->getEndpoint();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'ipp-company-id: 1228107',
                'Authorization: Bearer e157b756-4d21-4eb3-8139-0160437d74b3'
            )
        );
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);

        $certificateLocation = '/usr/local/openssl-0.9.8/certs/cacert.pem';
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $certificateLocation);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $certificateLocation);

        $response = curl_exec($curl);

        $error = curl_error($curl);
        curl_close($curl);

        if ($error) {
            throw new ErrorException("cURL Error #: " . $error);
        }

        return new VismaResponse($response);
    }
}

