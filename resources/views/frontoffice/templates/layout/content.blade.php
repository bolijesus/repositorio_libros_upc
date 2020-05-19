<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="body text-center">
                <h1>¡BIENVENID@S A LA PÁGINA DE LAS BIBLIOGRAFIAS ACADEMICAS!</h1>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="card">
            <div class="header">
                <h2>LIBROS</h2>
            </div>
            <div class="body">
                <div class="row">
                    @foreach ($libros as $libro)
                   
                        @if ($libro->bibliografia->revisado == $aceptado)
                            <div class="col-sm-6 col-md-4 col-xs-12">
                                <div class="thumbnail">
                                    <img src="{{ Storage::url($libro->bibliografia->portada) }}" style="max-width:128px;max-height: 128px; ">
                                    <div class="caption">
                                        <h3>{{ $libro->bibliografia->titulo }}</h3>
                                        <small>por: <span>{{ $libro->bibliografia->usuario->usuario }}</span></small>
                                        <p>
                                            {{ Str::limit($libro->bibliografia->descripcion,151,'(...)') }}
                                        </p>
                                        <p>
                                            <a href="{{ route('backoffice.libro.show',$libro) }}" class="btn btn-lg bg-grey waves-effect waves-green" role="button">
                                                VER
                                            </a>
                                            <a href="{{ route('backoffice.libro.download',$libro->bibliografia) }}" data-user="{{ Auth::user() }}" class="descargar-ajax btn btn-lg bg-primary waves-effect pull-right btn-upc" role="button">
                                                DESCARGAR
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @csrf
                        @endif
                        
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>