<?php

use App\Bibliografia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

if (!function_exists('active')) {
    function active($routeName){
        return request()->routeIs($routeName) ? 'active' : '';
    }
}
if (!function_exists('swal')) {
    function swal($mensaje){
        return new HtmlString($mensaje);
    }
}
if (!function_exists('crearDirectorio')) {
    function crearDirectorio($paht)
    {
        if (Storage::allFiles($paht) == null) {
            Storage::makeDirectory($paht);
            
        }
        
    }
}
if (!function_exists('getChildModel')) {
    function getChildModel($bilbiografias)
    {
        $model = \collect();
        foreach ($bilbiografias as $bibliografia) {
            $model->push($bibliografia->bibliografiable);
        }

        return $model;
    }
}
if (!function_exists('asignarPuntos')) {
    function asignarPuntos(Bibliografia $bibliografia)
    { 
        $user = $bibliografia->usuario;

        if ($user->puntos_descarga < 99) {
            
            $user->puntos_descarga++;
            $user->save();
        }
    
        
    }
}
