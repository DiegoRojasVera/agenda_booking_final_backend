<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;
use App\Models\Stylist;

class Service_stylist extends Model
{
    use HasFactory;
    public $table = "service_stylist";

    protected $fillable = [
        'service_id',
        'stylist_id',
        'nombre_servicio'
    ];

    // Deshabilitar marcas de tiempo
    public $timestamps = false;
	
	public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function stylist()
    {
        return $this->belongsTo(Stylist::class, 'stylist_id');
    }
}
