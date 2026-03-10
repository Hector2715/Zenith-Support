<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MustVerifyEmail;

class OtpCode extends Model
{
    protected $fillable = ['user_id', 'code', 'expires_at'];
}
