<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'photo',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}

