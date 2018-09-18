<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Image;
use App\Comment;
class Gallery extends Model
{
    
    // The attributes that are mass assignable.
    protected $fillable = [
        'title', 'description', 'user_id',
    ];

     //Gallery relationships to user, images and comments
     
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
      * Method for calling database and getting all galleries;
      */

      public static function getGalleries($request) {
            $page = $request['page'];
            $term = $request['term'];

            $query = self::query();
            $query->with(['user', 'images']);
            if(!empty($term)){
                $query->where('title', 'like', '%'.$term.'%')
                        ->orWhere('description', 'like', '%'.$term.'%');
            }
            $count = $query->count();
            $galleries = $query->skip(($page-1) * 10)
                                ->take(10)
                                ->get();
            return compact("galleries", "count");
      }
}
