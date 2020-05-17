<?php
namespace App\Http\Controllers;

use App\Bibliografia;
use App\Http\Requests\Libro\StoreRequest;
use App\Http\Requests\libro\UpdateRequest;
use App\Libro;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Illuminate\Support\Facades\Storage;

class LibroController extends Controller
{
    private $path='public/libros/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = Auth::user();
        if ($usuario->isAdmin()) {            
            $libros = Libro::all();
        }else {
            $bibliografias_libros = $usuario->bibliografias->where('bibliografiable_type',Libro::class);
            $libros = \getChildModel($bibliografias_libros);
        }
        return \view('models.libro.index',\compact('libros'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \view('models.libro.create',['libro' => new Libro()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {   
        $bibliografia=$request->except(['editorial', 'isbn', '_archivo']);
        $libro=$request->only(['editorial', 'isbn']);                
        $bibliografia = $this->storeFile($request)->except(['editorial', 'isbn', '_archivo']);
        try {
            DB::transaction(function()use($bibliografia, $libro){
                $libro = Libro::create($libro);
                $bibliografia = $libro->bibliografia()->create($bibliografia);
                
            },5);
        } catch (\Throwable $th) {
            dd($th);
            return \redirect()->route('backoffice.libro.index')->with('alert',swal(
                "'ERROR en el sistema',
                'No se pudo subir su archivo, por favor intente mas tarde',
                'error'"
            ));
        }
        return \redirect()->route('backoffice.libro.index')
        ->with('alert', \swal("
            'Archivo Subido!',
            'El archivo fue Cargado con exito',
            'success'
        "));
        //TODO:: hacer un campo en la tabla donde se especifique el titulo$titulo original del archivo para relacionarlo con el titulo$titulo que se le dara
        
    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function show(Libro $libro)
    {
        return \view('models.libro.show',\compact('libro'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function edit(Libro $libro)
    {
        FacadesGate::authorize('editar-libros', $libro);
        return \view('models.libro.edit',['libro' => $libro] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Libro $libro)
    {
        FacadesGate::authorize('editar-libros', $libro);
        
        try {
            DB::transaction(function () use ($request, $libro)
            {
                if (request()->has('_archivo')) {
                    Storage::delete($libro->bibliografia->archivo);               
                    $request = $this->updateFile($request, $libro);
                } 
                    
                $libro->bibliografia->update($request->except(['editorial','isbn']));                    
                $libro->update($request->only(['editorial','isbn']));
                
            },5);

            // TODO::ordenar si en una funcion para guardar archivos y mensajes de swerAler
            return \redirect()->route('backoffice.libro.index')->with('alert',\swal("
                'Libro Atualizado',
                'Se actualizo el libro satisfactoriamente',
                'success'
            "));
            
        } catch (Throwable $th) {
            return \redirect()->route('backoffice.libro.index')->with('alert',\swal("
                'Libro NO Atualizado',
                '(ERROR DEL SISTEMA) intentelo nuevamente',
                'error'
            "));
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Libro $libro)
    {
        if (\request()->ajax()) {
       
            try {
                Storage::delete($libro->bibliografia->archivo);
                $libro->bibliografia->user_id = null;
                $libro->bibliografia->save();
                $libro->bibliografia->delete();
                $libro->delete();
                
                return \json_encode(['respuesta'=>true]);
            } catch (\Throwable $th) {
                return \json_encode(['respuesta'=>false]);
            }
        }
    }
    
    //METODOS PROPIOS
    private function storeFile($request)
    {   
        $id_usuario = Auth::id();

        $request = $this->setFile($request, $id_usuario);

        $request = Arr::add($request, 'user_id', $id_usuario);
        
       
        return $request;
        
    }

    private function updateFile($request, $libro)
    {   
        $id_usuario = $libro->bibliografia->usuario->id;
        $request = $this->setFile($request, $id_usuario);        
        
        return $request;
        
    }

    private function setFile($request, $id_usuario)
    {
        $archivo = $request->file('_archivo');
        $extencion = $archivo->extension();        
        $rutaLibro = $this->path.$id_usuario;
        $nombre_a_guardar = str_replace(['-',' ',':'],'',Carbon::now());
        
        \crearDirectorio($rutaLibro);
        
        $rutaGuardado = $request->file('_archivo')->storeAs($rutaLibro,$nombre_a_guardar.'.'.$extencion);
        $request = Arr::add($request, 'archivo', $rutaGuardado);

        return $request;
    }

    public function download($bibliografia)
    {
        $bibliografia = Bibliografia::findOrFail($bibliografia);
        $usuario = Auth::user();
        $puntosDescargaActuales = $usuario->puntos_descarga;
        if ($puntosDescargaActuales<=0) {
            return \redirect()->back()->with('alert',swal(
                "'Usted tiene 0 puntos de descarga',
                'No se puede descargar el archivo, porfavor espere 1 dia.',
                'error'"
            ));
        }
        if (!$usuario->isAdmin()) {
            
            $usuario->puntos_descarga = --$puntosDescargaActuales;
          
            $usuario->save();
        }
        return Storage::download($bibliografia->archivo);
    }

    public function revision(Request $request, Libro $libro)
    {
        
        $revision = $request->only('revisado')['revisado'];
        
        $bibliografia = $libro->bibliografia;
        $enRevison = 1;
        $noAceptado = 2;
        $revisado = 3;
        $mensaje = "'Ha ocurrido un Error', 'Intentelo nuevamente', 'error'";
 
        if ($revision == $noAceptado) {
            $bibliografia->revisado = $noAceptado;
            $mensaje = "'Archivo No aceptado', 'El archivo no se acepto en la plataforma', 'warning'";
        }elseif ($revision == $revisado) {
            $bibliografia->revisado = $revisado;
            \asignarPuntos($libro->bibliografia);
            $mensaje = "'Archivo aceptado', 'El archivo se acepto en la plataforma', 'success'";
            
        } else {
            $bibliografia->revisado = $enRevison;
        }
        
        $bibliografia->save();
        return \redirect()->route('backoffice.libro.index')->with('alert',swal($mensaje));
    }

     
}
