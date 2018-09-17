<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Gallery;
class Image extends Model
{
    //The attributes that are mass assignable.
    protected $fillable = [
        'image_url', 'user_id', 'gallery_id'
    ];

    //Image  relationships to  gallery 
    public function gallery() {
        return $this->belongsTo(Gallery::class);
    }

}
