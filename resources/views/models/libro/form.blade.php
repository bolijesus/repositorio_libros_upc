

<div class="row clearfix">
    <div class="col-xs-12 col-md-3">
        <label for="titulo">Titulo*</label>
        <div class="form-group">
            <div class="form-line">
                <input type="text" value="{{ old('titulo', optional($libro->bibliografia)->titulo) }}" id="titulo" name="titulo" class="form-control" 
                    placeholder="Titulo del libro">
            </div>
            <label id="user_name-error" class="error">{{ $errors->first('titulo') }}</label>
        </div>
    </div>
    <div class="col-xs-12 col-md-3 ">
        <div class="row clearfix">
            <div class="col-sm-12 form-group" style="margin-top: 24px;">
                <select class="form-control show-tick" name="idioma">
                    <option value="">-- Idioma* --</option>
                    <option value="1">Español</option>
                    <option value="2">Ingles</option>
                    <option value="3">Aleman</option>
                </select>
                <label id="user_name-error" class="error">{{ $errors->first('idioma') }}</label>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-3 ">
        <div class="row clearfix">
            <div class="col-sm-12 form-group" style="margin-top: 24px;">
                <select class="form-control show-tick" name="genero">
                    <option value="">-- Genero* --</option>
                    <option value="1">Genero 1</option>
                    <option value="2">Genero 2</option>
                    <option value="3">Genero 3</option>
                </select>
                <label id="user_name-error" class="error">{{ $errors->first('genero') }}</label>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-3 ">
        <div class="row clearfix">
            <div class="col-sm-12 form-group" style="margin-top: 24px;">
                <select class="form-control show-tick" name="autor">
                    <option value="">-- Autor* --</option>
                    <option value="1">Autor 1</option>
                    <option value="2">Autor 2</option>
                    <option value="3">Autor 3</option>
                </select>
                <label id="user_name-error" class="error">{{ $errors->first('autor') }}</label>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-xs-12 col-md-4">
        <label for="editorial">Editorial*</label>
        <div class="form-group">
            <div class="form-line">
                <input type="text" value="{{ old('editorial', $libro->editorial) }}" id="editorial" name="editorial" class="form-control"
                    placeholder="Editorial del libro">
            </div>
            <label id="user_name-error" class="error">{{ $errors->first('editorial') }}</label>
        </div>
    </div>
    <div class="col-xs-12 col-md-4">
        <label for="isbn">ISBN*</label>
        <div class="form-group">
            <div class="form-line">
                <input type="number" value="{{ old('isbn', $libro->isbn) }}" id="isbn" name="isbn" class="form-control"
                    placeholder="ISBN del libro">
            </div>
            <label id="user_name-error" class="error">{{ $errors->first('isbn') }}</label>
        </div>
    </div>
    <div class="col-xs-12 col-md-4">
        <label for="archivo">Archivo*</label>
        <div class="form-group">
            <div class="form-line">
                <input type="file" id="archivo" name="archivo" class="form-control">
            </div>
            <label id="user_name-error" class="error">{{ $errors->first('archivo') }}</label>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-xs-12 ">
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="titulo">Descripcion</label>
                    <small>(max:200 palabras)</small>
                    <div class="form-line">
                        <textarea rows="4" class="form-control no-resize"
                            placeholder="Descripcion..." name="descripcion">{{ old('descripcion',optional($libro->bibliografia)->descripcion) }}</textarea>
                    </div>
                    <label id="user_name-error" class="error">{{ $errors->first('descripcion') }}</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-danger pull-right waves-effect">
        <span>SUBIR</span>
        <i class="material-icons">file_upload</i>
    </button>
</div>