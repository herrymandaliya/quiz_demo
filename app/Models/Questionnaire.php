<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    protected $guarded = [];  

    protected $table        = 'questionnaires';

    protected $primaryKey   = 'questionnaire_id';
}
