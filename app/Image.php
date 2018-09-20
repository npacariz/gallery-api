<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Gallery;
class Image extends Model
{
    /** 
     * The attributes that are mass assignable.
     * */
    protected $fillable = [
        'image_url', 'user_id', 'gallery_id'
    ];

    /**
     * Image  relationships to  gallery 
     */
    public function gallery() {
        return $this->belongsTo(Gallery::class);
    }

    /**
     * Method for saving images 
     */
    public static function saveImages($images, $id) {
        foreach($images as $img) {
            self::create([
                'image_url' => $img,
                'gallery_id' => $id
            ]);
        }
        return;
    }

}
