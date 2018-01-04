<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImageDetail extends Model
{
    protected $fillable = ['media_id', 'media_price', 'media_caption'];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}
