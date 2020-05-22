<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Bibliografia;
use App\Libro;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('test', function(){
   ddd(User::all());
});

// DB::listen(function($query){
//     echo "<h1><pre>{$query->sql}<pre></h1>";
// });

Route::get('/demo',function ()
{
    return view('demo');
});

Route::get('/', function () {
    $libros = Libro::all()->load(['bibliografia', 'bibliografia.usuario']);
    
    return view('frontoffice.templates.index', compact('libros'));
});

//BACK OFFICE
Route::name('backoffice.')->middleware('auth')->group(function (){

    Route::resource('/role', 'RoleController');
    Route::resource('/user', 'UserController');
    Route::resource('/autor', 'AutorController');
    Route::resource('/genero', 'GeneroController');
    

    Route::resource('/libro', 'LibroController');
    Route::get('/libro/download/{libro}','LibroController@download')->name('libro.download');
    Route::post('/libro/revision/{libro}', 'LibroController@revision')->name('libro.revision');
    Route::post('/puntos/{libro}', 'LibroController@puntosActuales');
});
Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
