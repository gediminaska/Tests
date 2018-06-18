<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{
    protected $fillable = [
        'questionnaire_id',
        'token',
    ];

    public function answers(){
        return $this->hasMany('App\Answer');
    }
    public function questionnaire(){
        return $this->belongsTo('App\Questionnaire');
    }
}
