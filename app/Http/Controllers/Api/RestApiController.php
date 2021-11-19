<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\VismaRestApiService;
use App\Services\PokemonRestApiService;
use ErrorException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use InvalidArgumentException;

use function json_decode;


class RestApiController extends Controller
{
    /**
     * @var VismaRestApiService
     */
    private $vismaRestApiService;

    public function __construct(VismaRestApiService $vismaService)
    {
        $this->vismaRestApiService = $vismaService;
    }

    public function testVismaRestApi($uri)
    {
        try {
            $vismaRequest = new VismaRestApiService();
            $vismaRequest = $vismaRequest->getVismaRequest($uri);
        } catch (InvalidArgumentException $exception) {
            $array = [
                'result' => 'error',
                'message' => $exception->getMessage()
            ];
            return new JsonResponse($array, 400);
        } catch (\Exception $exception) {
            $array = [
                'result' => 'error',
                'message' => 'Something went wrong'
            ];
            return new JsonResponse($array, 500);
        }

        return $vismaRequest;
    }

    public function testVismaRestApi2($endpoint)
    {
        try {
            $request = $this->vismaRestApiService->buildRequest($endpoint);
            $response = $this->vismaRestApiService->sendRequest($request);
            if(false === $response->isValid()) {
                $data = ['result' => 'error', 'message' => $response->getErrorMessage()];
                return new JsonResponse($data);
            }
            return new JsonResponse(
                [
                    'result' => 'ok',
                    'message' => null,
                    'data' => $response->getResponseAsArray()
                ]);
        } catch (InvalidArgumentException $exception) {
            $array = [
                'result' => 'error',
                'message' => $exception->getMessage()
            ];
            return new JsonResponse($array, 400);
        } catch (\ErrorException $exception) {
            $array = [
                'result' => 'error',
                'message' => $exception->getMessage()
            ];
            return new JsonResponse($array, 500);
        } catch (\Exception $exception) {
            $array = [
                'result' => 'error',
                'message' => 'Something went wrong'
            ];
            return new JsonResponse($array, 500);
        }
    }

    public function getAbilityAftermath()
    {
        try {
            $request = Request::createFromGlobals();
            $body = json_decode($request->getContent(), true);
            $pokemonRequest = new PokemonRestApiService();
            $pokemonRequest = $pokemonRequest->createPokemonRequest($body);
        } catch (ErrorException $exception) {
            $array = [
                'result' => 'error',
                'message' => $exception->getMessage()
            ];
            return new JsonResponse($array, 400);
        } catch (\Exception $exception) {
            $array = [
                'result' => 'error',
                'message' => 'Something went wrong'
            ];
            return new JsonResponse($array, 500);
        }

        return new JsonResponse($pokemonRequest);
    }
}
