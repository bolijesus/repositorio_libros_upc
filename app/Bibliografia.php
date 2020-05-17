<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bibliografia extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'fechaPublicacion',
        'idioma',
        'archivo',
        'revisado',
        'user_id',
    ];

    //RELACIONES
    public function bibliografiable()
    {
        return $this->morphTo();
    }

    public function usuario()
    {
       return $this->belongsTo(User::class, 'user_id');
    }
    
}

