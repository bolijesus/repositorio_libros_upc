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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('test', function(){
    $usuario=User::first();
    dd($usuario->bibliografias);
});

// DB::listen(function($query){
//     echo "<h1><pre>{$query->sql}<pre></h1>";
// });

Route::get('/', function () {
    $libros = Libro::all();
    $bibliografia = Bibliografia::first();
    
    return view('frontoffice.templates.index', compact('libros'));
});

//BACK OFFICE
Route::name('backoffice.')->middleware('auth')->group(function (){
    Route::post('/puntos/{user}',function (User $user)
    {
        if (request()->ajax()) {
            return $user;
        }
    });

    Route::resource('/role', 'RoleController');
    Route::resource('/user', 'UserController');

    Route::resource('/libro', 'LibroController');
    Route::get('/libro/download/{libro}','LibroController@download')->name('libro.download');
    Route::post('/libro/revision/{libro}', 'LibroController@revision')->name('libro.revision');

});
Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
