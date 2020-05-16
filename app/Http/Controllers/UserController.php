<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Role;
use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        $this->authorize('viewAny',Auth::user());
        return \view('models.user.index', \compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Auth::user());
        $user = new User();
        $roles = Role::all();
        return \view('models.user.create')->with(\compact('user', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('create', Auth::user());
        
        try {
            DB::transaction(function () use ($request)
            {
                $datosUsuario = $request->except('roles');
                $user = User::create($datosUsuario);
                $request = $this->storeImage($request , $user);
                $user->password = Hash::make($request->password);
                if ($request->url_foto != null) {                    
                    $user->url_foto = $request->url_foto;
                }
                $user->roles()->sync($request->roles);
                
                $user->save();
           },5);

           return \redirect()->route('backoffice.user.index')->with('alert', \swal("
            'Guardado!',
            'El usuario se guardo correctamente',
            'success'
        "));

        } catch (\Throwable $th) {
            
            return \redirect()->back()->with('alert', \swal("
            'Error!',
            'Error en el sistema Intentelo nuevamente',
            'error'
        "));
        }
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
        return \view('models.user.show',\compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        $roles = Role::all();
        return \view('models.user.edit',\compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, User $user)
    {
        $this->authorize('update', $user);
        if (\request()->has('foto_perfil') && !($user->url_foto === 'public/profile.jpg')) {
            Storage::delete($user->url_foto);
        }
        
        $request = $this->storeImage($request, $user);

        $user->update($request->all());
        if ($request->has('roles')) {            
            $user->roles()->sync($request->roles);
            $user->save();
            return \redirect()->route('backoffice.user.index')->with('alert', \swal("
                'Actualizado!',
                'el Usuario ".$user->usuario." se actualizo con exito!',
                'success'
            "));
        }

        return \redirect()->route('backoffice.user.show',$user)->with('alert', \swal("
                'Actualizado!',
                'el Usuario ".$user->usuario." se actualizo con exito!',
                'success'
            "));

    }

    private function storeImage($request, $user){
        if ($request->has('foto_perfil')) {
            $rutaImagen = 'public/imagenes/profile/'.$user->id;
            if (Storage::allFiles($rutaImagen) == null) {
                Storage::makeDirectory($rutaImagen);            
            }  
            $rutaGuardado = $request->file('foto_perfil')->store($rutaImagen);
            $request = Arr::add($request, 'url_foto', $rutaGuardado);
        }

        return $request;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
