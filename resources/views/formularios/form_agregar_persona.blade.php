@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection

@section('main-content')
<section  id="contenido_principal">
<section  id="content">

    <div class="" >
        <div class="container"> 
            <div class="row">
              <div class="col-sm-10 myform-cont" >
                
                     <div class="myform-top">
                        <div class="myform-top-left">
                           {{-- <img  src="" class="img-responsive logo" /> --}}
                          <h3>Agregar Persona</h3>
                            <p>Por favor llene los siguientes campos</p>
                        </div>
                        <div class="myform-top-right">
                          <i class="fa fa-user-plus"></i>
                        </div>
                    </div>

                  <div class="col-md-12" >
                    @if (count($errors) > 0)
                        <br>
                        <div class="alert alert-danger">
                            <strong>UPPS!</strong> Error al Registrar<br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    
                    @endif
                   </div>

                    <div id="div_notificacion_sol" class="myform-bottom">
                      
                    <form action="{{ url('agregar_persona') }}"  method="post" id="f_enviar_agregar_persona" class="" enctype="multipart/form-data">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <div class="col-md-12">
                        <div class="form-group">
                            <label >Nombre</label>
                            <input type="input" name="nombre" placeholder="" class="form-control" value="{{ old('nombre') }}"/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label >Apellido Paterno</label>
                            <input type="input" name="paterno" placeholder="" class="form-control" value="{{ old('paterno') }}" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label >Apellido Materno</label>
                            <input type="input" name="materno" placeholder="" class="form-control" value="{{ old('materno') }}" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label >Carnet</label>
                            <input type="input" name="cedula_identidad" id="input_cedula" placeholder="" class="form-control" value="{{ old('cedula_identidad') }}" pattern="[0-9]{6,9}"/>
                        </div>
                    </div>
                    {{-- <div class="col-md-4">
                        <div class="form-group">
                            <label >Complemento SEGIP</label>
                            <input type="input" name="complemento" placeholder="" class="form-control" value="{{ old('complemento') }}" />
                        </div>
                    </div> --}}
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="text-black">Rol</label>
                            <div class="form-group bg-gray">
                                <select  class="form-control" name="rol" id="rol_slug">
                                  @if(!old('rol'))
                                    <option value="" selected> --- SELECCIONE UN ROL --- </option>
                                    @foreach ($roles as $rol)
                                        <option value={{$rol->id}}>{{$rol->description}}</option>                                                
                                    @endforeach
                                  @else
                                    <option value=""> --- SELECCIONE UN ROL --- </option>
                                    @foreach ($roles as $rol)
                                    <option value="{{$rol->id}}" {{ old('rol', $rol->id) == $rol->id ? 'selected' : '' }}>{{$rol->description}}</option>
                                    @endforeach
                                  @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="div_edad">
                        <div class="form-group">
                            <label class=" ">Edad</label>
                            <input style='line-height: initial;' type="number" name="edad" id="edad" placeholder="" min="1" max="110" class="form-control" value="{{ old('edad') }}" />
                        </div>
                    </div>
                    <div class="col-md-6" id="div_sexo">
                        <div class="form-group">
                            <label class="text-black">Sexo</label>
                            <div class="form-group bg-gray">
                              <select class="form-control" name="sexo" id="sexo">
                                @if(!old('sexo'))
                                  <option value="" selected> --- SELECCIONE SU GENERO --- </option>
                                  <option value="MASCULINO">MASCULINO</option>
                                  <option value="FEMENINO">FEMENINO</option>
                                @else
                                  <option value=""> --- SELECCIONE SU GENERO --- </option>
                                  <option value="MASCULINO" {{ old('sexo') == 'MASCULINO' ? 'selected' : '' }}>MASCULINO</option>
                                  <option value="FEMENINO" {{ old('sexo') == 'FEMENINO' ? 'selected' : '' }}>FEMENINO</option>
                                @endif
                              </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12" id="div_institucion">
                        <div class="form-group">
                            <label >Institucion</label>
                            <input type="input" name="institucion" id="institucion" placeholder="" class="form-control" value="{{ old('institucion') }}"/>
                        </div>
                    </div>
                    <div class="col-md-12" id="div_especialidad">
                        <div class="form-group">
                            <label >Especialidad</label>
                            <input type="input" name="especialidad" id="especialidad" placeholder="" class="form-control" value="{{ old('especialidad') }}"/>
                        </div>
                    </div>

                    <div class="col-md-12" id="div_medico">
                        <div class="form-group">
                            <label class="text-black">Médico de Cabecera</label>
                            <div class="form-group bg-gray">
                              <select  class="form-control" name="medico" id="medico">

                                @if(!old('medico'))
                                    <option value="" selected> --- SELECCIONE UN MEDICO --- </option>
                                    @foreach ($personas as $item)
                                        @if ($item->usuario->roles[0]->slug == 'medico')
                                            <option value={{$item->id_persona}}>{{ $item->nombre}} {{$item->paterno}} {{$item->materno}}</option>                                                
                                        @endif
                                    @endforeach
                                @else
                                    <option value=""> --- SELECCIONE UN MEDICO --- </option>
                                    @foreach ($personas as $item)
                                        @if ($item->usuario->roles[0]->slug == 'medico')
                                        <option value="{{$item->id_persona}}" {{ old('medico', $item->id_persona) == $item->id_persona ? 'selected' : '' }}>{{ $item->nombre}} {{$item->paterno}} {{$item->materno}}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            </div>
                        </div>
                    </div>



                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-black ">Subir </label>
                            <input name="archivo" id="archivo" type="file" class="text-white" accept="image/*"/>
                        </div>
                    </div> --}}
                    <div class="col-md-12">
                        <br>
                    </div>
                        <button type="submit" class="mybtn">Registrar</button>
                    </form>
                    
                    </div>
              </div>
            </div>

        </div>
      </div>
 
</section>

</section>
@endsection


@include('formularios.persona.scripts')