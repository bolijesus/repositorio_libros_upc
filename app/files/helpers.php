<?php

use App\Bibliografia;
use Illuminate\Support\Facades\Auth;
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