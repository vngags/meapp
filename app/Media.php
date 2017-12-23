<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['user_id', 'original_url', 'type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
