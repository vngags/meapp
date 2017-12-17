<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['user_id', 'phone_number', 'about'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
