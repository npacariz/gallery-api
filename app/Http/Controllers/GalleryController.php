<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
use App\Image;
use App\Http\Requests\GalleryRequest;
class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Gallery::getGalleries($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GalleryRequest $request)
    {
        $gallery = Gallery::saveGallery($request);
        Image::saveImages($request->images, $gallery->id);
        return $gallery;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Gallery::getSingleGallery($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GalleryRequest $request, $gallery)
    {
        
        //checking if authenticated user editing his gallery
        $galleryForUpdate = Gallery::findOrFail($gallery);
        $user =  Auth()->user()->id;
        if($galleryForUpdate->user_id !== $user) {
            //if authenticated is not owner of this gallery ruturn error 
            abort(403, "Can't edit gallery if you are not owner"); 
        }
      
        $updatedGallery->update([
            "title" => $request['title'],
            "description" => $request['description'],
        ]);

        $updatedGallery->images()->delete();

        Image::saveImages($request->images, $gallery);
        return $gallery;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($gallery)
    {   
        $galleryCheck = Gallery::findOrFail($gallery);
        //if authenticated user is not owner of gallery don't let him delete gallery
        $user_id = Auth()->user()->id;
        if($user_id !== $galleryCheck->user_id){
            abort(403, "Can't delete gallery if you are not owner"); 
        }
        return Gallery::destroy($gallery);
    }
}
