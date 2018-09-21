<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Image;
use App\Comment;
class Gallery extends Model
{
    
    /** 
     *  The attributes that are mass assignable.
     */
    protected $fillable = [
        'title', 'description', 'user_id',
    ];

     /** 
      * Gallery relationships to user, images and comments
      */
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function images() {
         return $this->hasMany(Image::class);
    }
    public function comments() {
         return $this->hasMany(Comment::class);
    }

     /**
      * Method for calling database and getting all galleries with pagination and filter,
      * Using same method for getting my galleries and user galleries
      */

    public static function getGalleries($request, $user=null) {
        $page = $request['page'];
        $term = $request['term'];

        $query = self::query();
        $query->with('user', 'images');
        //Check if user id is given 
        if($user) {
            $query->where('user_id', $user);
        }
        //search database for given term
        $query->whereHas('user', function($query) use ($term) {
                $query->where('title', 'like', '%'.$term.'%')
                        ->orWhere('description', 'like', '%'.$term.'%')
                            ->orWhere('first_name', 'like', '%'.$term.'%')
                                ->orWhere('last_name', 'like', '%'.$term.'%');
        }); 

        $count = $query->count();
        //If there is no galleries return error message
        if($count === 0) {
            abort(404, "No galleries found");
        }
        //Pagination with descending order
        $galleries = $query->skip(($page-1) * 10)
                            ->take(10)
                            ->orderBy('created_at','desc')
                            ->get();
        return compact("galleries", "count");
    }

    /**
     * Getting single gallery with user, comments and images
     */
    public static function getSingleGallery($id) {
        return Gallery::with('user', 'images', 'comments.user')
                        ->findOrFail($id);
    }

    /**
     * Method for saving gallery
     */
    public static function saveGallery($request) 
    {
        $user = Auth()->user()->id;
        return  self::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'user_id' => $user
        ]);
        
    }
    /**
     * Method for updating gallery
     */
    public static function updateGallery($request, $gallery)
    {
        //checking if authenticated user editing his gallery
        $galleryForUpdate = self::findOrFail($gallery);
        $user =  Auth()->user()->id;
        if($galleryForUpdate->user_id !== $user) {
            //if authenticated is not owner of this gallery ruturn error 
            abort(401, "Can't edit gallery if you are not owner"); 
        }
      
        $galleryForUpdate->update([
            "title" => $request['title'],
            "description" => $request['description'],
        ]);

        return $galleryForUpdate;
    }

    /**
     * Method for deleting gallery
     */

    public static function deleteGallery($gallery) {

        $galleryCheck = Gallery::findOrFail($gallery);
        //if authenticated user is not owner of gallery don't let him delete gallery
        $user_id = Auth()->user()->id;
        if($user_id !== $galleryCheck->user_id){
            abort(403, "Can't delete gallery if you are not owner"); 
        }
        return self::destroy($gallery);
    }
}
