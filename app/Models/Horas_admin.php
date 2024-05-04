<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Horas_admin extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'horas_admin';

    protected $fillable = [
        'adminUserId',
        'horas_empleados_id',
        'status',
        'comentario'
    ];
}
