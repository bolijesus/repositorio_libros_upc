<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $fillable=['nombre'];

    //RELACIONES
    public function bilbiografias()
    {
        return $this->belongsToMany(Bibliografia::class);
    }
}
