<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;

class MyGalleryController extends Controller
{
    /**
     * Method for getting galleries from login user
     * using gallery model 
     */
    public function index(Request $request)
    {
        $user = Auth()->user()->id;
        return Gallery::getGalleries($request, $user);
    }
}
