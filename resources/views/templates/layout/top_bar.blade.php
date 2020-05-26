
 <nav class="navbar _theme-green">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="/">UPC - REPOSITORIO</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <!-- Call Search -->
                {{-- <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li> --}}
                <!-- #END# Call Search -->
                {{-- <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li> --}}
                @if(Auth::user())
                    <li class="pull-right">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" class="lg-outer _btn btn bg-white col-black waves-effect waves-green ">
                            CERRAR SESION
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>                        
                    </li>
                    <li class="pull-right">
                        <a href="#" class="lg-outer _btn btn bg-white col-black waves-effect waves-green ">
                            PUNTOS PARA DESCARGAR
                            <span class="puntos badge">{{ \Auth::user()->isAdmin() ? 'ILIMITED' : \Auth::user()->puntos_descarga }}</span>
                        </a>
                        
                    </li>
                    <li class="pull-right">
                    
                        <a href="{{ route('backoffice.index')}}" class="lg-outer _btn btn bg-white col-black waves-effect waves-green ">
                            DASHBOARD
                        </a>   
                    </li>
                @else
                    <li class="pull-right">
                        <a href="{{ route('login') }}" class="lg-outer btn _btn bg-white col-black waves-effect waves-orange ">
                            LogIn
                        </a>   
                    </li>
                @endif
                
            </ul>
        </div>
    </div>
</nav>