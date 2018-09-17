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
        return $this->belongsTo(Gallery::class);
     }
     public function images() {
         return $this->hasMany(Image::class);
     }
     public function comments() {
         return $this->hasMany(Comment::class);
     }
}
