<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ratingbar extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'calificacion',
        'stylist',
        'comentario',
        'nombre',
        'photo',
        // 'created_at', // No necesitas incluir created_at y updated_at en $fillable
        // 'updated_at',
    ];

    // Asegúrate de configurar correctamente los nombres de las columnas de fecha si son diferentes
    // protected $dates = ['created_at', 'updated_at'];

    // Si no necesitas timestamps (created_at y updated_at) en la tabla, puedes desactivarlos
    public $timestamps = false;
}
