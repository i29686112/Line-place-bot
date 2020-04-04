<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineUsers extends Model
{
    //

    protected $primaryKey = 'line_id';
    public $incrementing = false;

    protected $fillable = [
        'line_id','name'
    ];
}
