
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
                                        <option value="" selected> --- SELECCIONE UN ROL --- </option>
                                        @foreach ($roles as $rol)
                                            <option value={{$rol->id}}>{{$rol->description}}</option>                                                
                                        @endforeach
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
                                        <option value="" selected> --- SELECCIONE SU GENERO --- </option>
                                        <option value="MASCULINO">MASCULINO</option>
                                        <option value="FEMENINO">FEMENINO</option>
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
                                        <option value="" selected> --- SELECCIONE UN MEDICO --- </option>
                                        @foreach ($personas as $item)
                                            @if ($item->usuario->roles[0]->slug == 'medico')
                                                <option value={{$item->id_persona}}>{{ $item->nombre}} {{$item->paterno}} {{$item->materno}}</option>                                                
                                            @endif
                                        @endforeach
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

@section('scripts')
	
@parent
<script>
	function activar_mesas() {


    // Ocultando Divs al iniciar

    $("#div_institucion").hide();
    $("#div_especialidad").hide();
    $("#div_medico").hide();
    $("#div_edad").hide();
    $("#div_sexo").hide();
    document.getElementById("institucion").required = false;
    document.getElementById("especialidad").required = false;
    document.getElementById("medico").required = false;


    $("#rol_slug").change(function(){
        
        
        //id obtenido de la base de datos "campo : slug"
        var rol_slug = $("#rol_slug").val();
        // alertify.success(rol_slug);
        if (rol_slug == '3') { //medico
            $("#div_institucion").show();
            $("#div_especialidad").show();
            $("#div_medico").hide();
            $("#div_edad").hide();
            $("#div_sexo").hide();
            document.getElementById("institucion").required = true;
            document.getElementById("especialidad").required = true;
            document.getElementById("medico").required = false;
            document.getElementById("edad").required = false;
            document.getElementById("sexo").required = false;
        }else if(rol_slug == '1'){ //Administrador
            $("#div_institucion").hide();
            $("#div_especialidad").hide();
            $("#div_medico").hide();
            $("#div_edad").hide();
            $("#div_sexo").hide();
            document.getElementById("institucion").required = false;
            document.getElementById("especialidad").required = false;
            document.getElementById("medico").required = false;
            document.getElementById("edad").required = false;
            document.getElementById("sexo").required = false;

        }else{
            $("#div_institucion").hide();
            $("#div_especialidad").hide();
            $("#div_medico").show();
            $("#div_edad").show();
            $("#div_sexo").show();
            document.getElementById("institucion").required = false;
            document.getElementById("especialidad").required = false;
            document.getElementById("medico").required = true;
            document.getElementById("edad").required = true;
            document.getElementById("sexo").required = true;
        }
    });
  


    
	
	}	
	activar_mesas();
	
	
	</script>
@endsection