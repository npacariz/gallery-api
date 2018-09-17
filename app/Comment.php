<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Gallery;
class Comment extends Model
{
        
    // The attributes that are mass assignable.
    protected $fillable = [
        'body', 'gallery_id', 'user_id',
    ];

     //Comment relationships to gallery and user;

     public function user() {
        return $this->belongsTo(User::class);
     }
     public function gallery() {
        return $this->belongsTo(Gallery::class);
     }
   
}
