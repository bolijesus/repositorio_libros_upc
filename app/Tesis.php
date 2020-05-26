<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tesis extends Model
{
    protected $fillable = ['publicadores'];
    //RELACIONES
    public function bibliografia()
    {
        return $this->morphOne(Bibliografia::class, 'bibliografiable');
    }
}
