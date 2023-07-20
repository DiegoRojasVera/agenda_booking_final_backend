<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stylist extends Model
{
    protected $fillable = [
        'name',
        'photo',
        'phone',
        'score',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'score' => 'float',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function ratings()
    {
        return $this->hasMany(Ratingbar::class, 'stylist', 'name');
    }

    public function averageRating()
    {
        return $this->ratings()->avg('calificacion');
    }
}



