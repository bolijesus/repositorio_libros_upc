
@extends('templates.index')

@section('title','Usuario|'.$user->usuario)

@section('css')
<link href="{{ asset('css/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
@endsection

{{-- SECCION PARA CAMBIAR LA CLASE DE LA ETIQUETA BODY PARA EL INICIO DE SESION --}}
{{-- @section('type_page','login-page ls-closed') --}} 

{{-- breadcrumbs --}}

@section('breadcrumbs')
    <li><a href="/">Inicio</a></li>
        <li class="active">Usuario: {{ $user->usuario }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-xs-12 col-sm-3">
            <div class="card profile-card">
                <div class="profile-header">&nbsp;</div>
                <div class="profile-body">
                    <div class="image-area">
                        <img src="{{ Storage::url($user->foto_perfil) }}" alt="AdminBSB - Profile Image" style="width: 128px;height:128px" />
                    </div>
                    <div class="content-area">
                        <h3>{{ $user->nombre.' '.$user->apellido }}</h3>
                        <span>Roles:</span>
                        @foreach ($user->roles as $role)
                            <p>{{ $role->nombre }}</p>
                        @endforeach
                    </div>
                </div>
                <div class="profile-footer">
                    <ul>
                        <li>
                            <span>Libros Aprovados</span>
                            <span>{{ $user->bibliografias->where('revisado','=','3')->count() }}</span>
                        </li>
                        <li>
                            <span>Revistas</span>
                            <span>1.201(estatico)</span>
                        </li>
                        <li>
                            <span>Tesis</span>
                            <span>14.252(estatico)</span>
                        </li>
                    </ul>
                    <a href="{{ route('backoffice.user.edit',$user) }}" class="btn btn-upc btn-lg waves-effect btn-block">EDITAR PERFIL</a>
                </div>
            </div>

        </div>
        <div class="col-xs-12 col-sm-9">
            <div class="card">
                <div class="body">
                    <div>
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#libros" aria-controls="libros" role="tab" data-toggle="tab">Libros</a></li>
                            <li role="presentation"><a href="#profile_settings" aria-controls="settings" role="tab" data-toggle="tab">Revistas</a></li>
                            <li role="presentation"><a href="#change_password_settings" aria-controls="settings" role="tab" data-toggle="tab">Tesis</a></li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="libros">
                                @include('models.libro.content-index',['libros' => $libros])
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="profile_settings">
                                @include('models.revista.content-index',['revistas' => $revistas])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script src="{{ asset('js/jquery-datatable/jquery.dataTables.js') }}"></script>
<script src="{{ asset('js/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('js/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
<script src="{{ asset('js/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
<script src="{{ asset('js/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/tables/jquery-datatable.js') }}"></script>
@include('models.libro.delete')
@endsection
