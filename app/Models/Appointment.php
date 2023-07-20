<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model

{
    protected $fillable = [
        'dated_at',
        'finish_at',
        'duration',
        'total',


    ];
    // aca hace toda la union de las coas de las base de datos

    protected $dates = [
        'dated_at',
        'finish_at',
    ];


    protected $casts = [
        'total' => 'float',
    ];

    public function client()
    {
        return  $this->belongsTo(Client::class,);
    }
    public function clientemail()
    {
        return  $this->belongsTo(Client::class, 'email');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function stylist()
    {
        return $this->belongsTo(Stylist::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
