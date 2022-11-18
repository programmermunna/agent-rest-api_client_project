<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageContent extends Model
{
    use SoftDeletes;

    protected $table = 'image_contents';

    public $timestamps = true;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'type',
        'path',
        'title',
        // 'constant_promosi_value_id',
        'value_bonus',
        'max_bonus_given',
        'alt',
        'order',
        'enabled',
        'content',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];

    protected $appends = [
        // 'slide_photo',
        'photo_path',
        // 'box_photo'
    ];

    public function getPhotoPath($width, $height)
    {
        if ($this->path == null) {
            return 'http://via.placeholder.com/' . $width . 'x' . $height . '/?text=Agent+WL';
        }

        return $this->path;
    }

    public function getSlidePhotoAttribute()
    {
        return null;
    }

    public function getBoxPhotoAttribute()
    {
        return null;
    }

    public function getPhotoPathAttribute()
    {
        if ($this->path == null) {
            return null;
        }

        return $this->path;
    }
}
