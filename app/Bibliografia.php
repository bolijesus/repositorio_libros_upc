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
        'portada',
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

    public function autores()
    {
        return $this->belongsToMany(Autor::class);
    }

    //METODOS
    public function hasAutor($autorToSearch)
    {
        foreach ($this->autores as $autor_bibliografia) {
            
            if ($autor_bibliografia->id == $autorToSearch->id) {
               
                return true;
            }
        }
    }
    
}

