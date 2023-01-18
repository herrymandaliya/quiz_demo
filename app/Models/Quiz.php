<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    
    protected $guarded = [];  

    protected $table        = 'quizzes';

    protected $primaryKey   = 'quizze_id';

    public function question(){
        return $this->hasMany('App\Models\Questionnaire', 'quizze_id', 'quizze_id');
    }
}
