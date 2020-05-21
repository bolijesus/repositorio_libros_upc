<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $fillable =['editorial','isbn'];

    //RELACIONES
    public function bibliografia()
    {
        return $this->morphOne(Bibliografia::class, 'bibliografiable');
    }

}
