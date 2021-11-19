<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;

use function json_decode;

class CalculatorController extends Controller
{

    public function getSum()
    {
        try {
            $request = Request::createFromGlobals();
            $numbers = json_decode($request->getContent(), true);

            if (!isset($numbers['number1'])) {
                throw new \InvalidArgumentException('Number 1 must be provided');
            }

            if (!isset($numbers['number2'])) {
                throw new \InvalidArgumentException('Number 2 must be provided');
            }

            $sum = $numbers['number1'] + $numbers['number2'];
            $response = ['result' => $sum];
            return new JsonResponse($response);

        } catch(InvalidArgumentException $e) {
            $array = ['result' => 'error',
                      'message' => $e->getMessage()];
            return new JsonResponse($array, 400);

        } catch (\Exception $e) {
            $array = ['result' => 'error',
                'message' => 'Something went wrong!'];
            return new JsonResponse($array, 500);
        }
    }

}
