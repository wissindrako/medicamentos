<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
    <ul class="nav navbar-nav">
      {{-- <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li> --}}
      @role('super_admin')
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Configuracion <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ url('listado_usuarios') }}"><i class="fa fa-list-alt"></i>Usuarios</a></li>
            @if (Auth::user()->persona)
            <li><a href="{{route('form_editar_persona', ['id' => Auth::user()->persona->id_persona])}}"><i class="fa fa-user"></i> Mi perfil</a></li>
            @endif
            
              {{-- <li><a href="{{ url('listado_empresas') }}">Usuarios</a></li> --}}
          </ul>
      </li>
      @endrole
      @role('medico')
      <li><a href="{{route('form_editar_persona', ['id' => Auth::user()->persona->id_persona])}}"><i class="fa fa-user"></i> Mi perfil</a></li>
      @endrole
      {{-- <li><a href="{{ url('mapa') }}"><i class="fa fa-map-marker"></i> Mapa</a></li>
      <li><a href="{{ url('quienes_somos') }}"><i class="fa fa-info-circle"></i> Quienes Somos</a></li>
      <li><a href="{{ url('contactos') }}"><i class="fa fa-phone-square"></i> Contactos</a></li>
      <li><a href="#"><i class="fa fa-question-circle "></i> F.A.Q.</a></li> --}}
      {{-- <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="#">Action</a></li>
          <li><a href="#">Another action</a></li>
          <li><a href="#">Something else here</a></li>
          <li class="divider"></li>
          <li><a href="#">Separated link</a></li>
          <li class="divider"></li>
          <li><a href="#">One more separated link</a></li>
        </ul>
      </li> --}}
    </ul>
    {{-- <form class="navbar-form navbar-left" role="search">
      <div class="form-group">
        <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
      </div>
    </form> --}}
  </div>
