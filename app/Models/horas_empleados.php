<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class horas_empleados extends Model
{
    use HasFactory;

    protected $table = 'horas_empleados';

    public $timestamps = false;

    protected $fillable = [
        'userId',
        'hora_inicio',
        'hora_fin',
        'horas',
        'fecha',
        'tipo'
    ];

}
