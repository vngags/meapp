<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Auth;

class Product extends Model
{
    protected $fillable = ['user_id', 'title', 'slug', 'body'];

    protected $hidden = ['pivot'];

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

    public static function fetchByUidSlug($user_slug, $slug)
    {
        $owner = User::findBySlug($user_slug);
        $product = self::with('user')->where('user_id', $owner->id)
                    ->where('slug', $slug)->first();
        return $product;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->belongsToMany(Media::class, 'product_media');
    }
}
