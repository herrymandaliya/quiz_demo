<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verifyotp extends Model
{
    use HasFactory;

    protected $table        = 'verifyotps';

    protected $primaryKey   = 'verifyotp_id';
}
