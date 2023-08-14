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
        'working_days', // Agregar 'working_days' como campo fillable
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'score' => 'float',
        'working_days' => 'array', // Definir 'working_days' como un campo de tipo array
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

    public function working_days()
    {
        return $this->hasMany(Stylist::class, 'stylist_id');
    }
}
