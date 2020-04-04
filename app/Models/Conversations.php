<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Conversations extends Model
{
    //
    protected $fillable = [
        'note','type','user_id','status'
    ];


    public function user()
    {
        return $this->hasOne('Models\Conversations','line_id','user_id');
    }

}
