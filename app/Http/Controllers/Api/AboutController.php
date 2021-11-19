<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class AboutController extends Controller
{
    public function getAbout()
    {
        $array = ['bleep', 'bloop', 'bla'];
        return new JsonResponse($array, 202);
    }

}
