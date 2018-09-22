<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;

class UserController extends Controller
{
     /**
     * Method for getting all galleries from specific user 
     * using gallery model 
     */
    public function index(Request $request, $id)
    {
        return Gallery::getGalleries($request, $id);
    }
}
