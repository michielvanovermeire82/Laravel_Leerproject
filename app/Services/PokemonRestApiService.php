<?php


namespace App\Services;


use ErrorException;

class PokemonRestApiService

{
    public function createPokemonRequest()
    {
        $curl = curl_init();
        $timeout = 5;
        curl_setopt($curl, CURLOPT_URL, "https://pokeapi.co/api/v2/ability/aftermath");
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
            throw new ErrorException("cURL Error #:" . $error);
        }

        return $response;
    }
}
