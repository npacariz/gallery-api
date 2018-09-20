<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Gallery;
class Comment extends Model
{
        
    /** 
     * The attributes that are mass assignable.
     * */ 
    protected $fillable = [
        'body', 'gallery_id', 'user_id',
    ];

 
    /**
     * Comment relationships to gallery and user;
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function gallery() {
        return $this->belongsTo(Gallery::class);
    }
   
     /**
      * Method for adding new comment 
      */
    public static function addComment($request) {
        $user = Auth()->user()->id;
        $comment = self::create([
            "body" => $request['body'],
            "gallery_id" => $request['gallery_id'],
            'user_id' =>  $user,
        ]);
        return self::with('user')->where('id', $comment->id)->get();
            
    }
}
