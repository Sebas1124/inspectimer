<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpUsers extends Model
{
    use HasFactory;

    protected $table = 'otp_login';

    protected $fillable = [
        'userId',
        'otpCode',
        'approved',
        'created_at',
        'updated_at'
    ];

}
