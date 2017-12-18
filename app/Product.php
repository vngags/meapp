<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['user_id', 'title', 'slug', 'body'];

    public function scopeFindBySlug($query, $slug)
    {
        return $query->where('slug', $slug)->first();
    }

    public function setSlugAttribute($title) 
    {
        $slug = str_slug($title);
        $count = $this->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        $this->attributes['slug'] =  $count ? "{$slug}-{$count}" : $slug;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
