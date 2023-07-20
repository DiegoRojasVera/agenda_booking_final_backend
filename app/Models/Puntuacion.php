<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puntuacion extends Model
{
    use HasFactory;

    protected $table = 'ratingbar';

    protected $fillable = [
        'calificacion',
        'stylist',
        'comentario',
        'nombre',
        'photo'

    ];
}
