<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'price' => 'float',
        'category_id' => 'int',
    ];
    

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function stylists()
    {
        return $this->belongsToMany(Stylist::class);
    }
   
}

