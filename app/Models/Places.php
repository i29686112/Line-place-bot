<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Places extends Model
{
    //

    protected $fillable = [
        'name','url','add_user_id','category_id','address','category_name'
    ];


    public function user()
    {
        return $this->hasOne('Models\LineUsers','line_id','add_user_id');
    }

    public function category()
    {
        return $this->hasOne('Models\Categories','id','category_id');
    }
}
