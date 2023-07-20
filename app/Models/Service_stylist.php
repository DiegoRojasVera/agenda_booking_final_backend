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

    ];
}
