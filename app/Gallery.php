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

            if($user) {
                $query->where('user_id', $user);
            }

            $query->whereHas('user', function($query) use ($term) {
                    $query->where('title', 'like', '%'.$term.'%')
                            ->orWhere('description', 'like', '%'.$term.'%')
                                ->orWhere('first_name', 'like', '%'.$term.'%')
                                    ->orWhere('last_name', 'like', '%'.$term.'%');
            }); 

            $count = $query->count();
            if($count === 0) {
                abort(404, "No galleries found");
            }
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
}
