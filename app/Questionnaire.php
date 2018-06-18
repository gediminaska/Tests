<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    protected $table = 'questionnaires';

    public function questions(){
        return $this->hasMany('App\Question');
    }
    public function attempts(){
        return $this->hasMany('App\Attempt');
    }
    public function bestAttempts(){
        return $this->attempts()->where('name', '<>', null)->orderBy('score', 'desc')->take(10);
    }
}
