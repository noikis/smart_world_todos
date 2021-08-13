<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $table = 'lists';

    protected $guarded = [];

    protected $hidden = ['pivot'];


    public function users()
    {
        return $this->belongsToMany(User::class, 'user_lists',
            'list_id', 'user_id')->withTimestamps();
    }


}
