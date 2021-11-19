<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Request;


class AboutController extends Controller
{

    /*
     *
     */
    public function getAbout()
    {
        $request = Request::createFromGlobals();
        $name = $request->get('name');
        return view('about', ['name' => ucfirst($name)]);
    }

}

