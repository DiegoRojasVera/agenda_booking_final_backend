<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Client extends Model
{
    // protected $table='appointments';
    // protected $primaryKey='id';
    use HasFactory;
    public $table = "clients";


    protected $fillable = [
        'name',
        'email',
        'phone',
        'stylistName',
        'inicio',
        'stylist',
        'service',
        'mensaje',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function stylist()
    {
        return $this->belongsTo(Stylist::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
