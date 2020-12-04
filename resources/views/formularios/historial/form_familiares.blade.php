
@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection

@section('main-content')
<section  id="contenido_principal">
<section  id="content">

    <div class="" >
        <div class="container"> 
            @if (count($personas) > 0)
            <div class="box box-primary">
               
                <div class="box-body table-responsive no-padding">
                    
                    <table id="" class="table table-hover table-striped table-bordered">
                      <thead>
                          <th>Nombre</th>
                          <th>Celular</th>
                          <th>Parentesco</th>
                      </thead>
                      <tbody>
                          @foreach ($personas as $item)
                              <tr>
                                  <td>{{ $item->nombre}} {{$item->paterno}} {{$item->materno}}</td>
                                  <td>{{ $item->telefono_celular}}</td>
                                  <td>{{ $item->parentesco}}</td>
                              </tr>
                          @endforeach
                      </tbody>
                    </table>
                  

                  </div>
            </div>
            @endif

            <div class="row">
              <div class="col-sm-12 myform-cont" >
                
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
                   @if (count($personas) == 0)
                   {{-- <br> --}}
                   <div class="col-xs-12">
                       <div class='aprobado' style="margin-top:20px; text-align: center">
                       <label style='color:#177F6B'>
                           No tiene familiares registrados, registre al menos uno
                       </label>
                       </div>
                   </div>
                   @endif

                    <div id="div_notificacion_sol" class="myform-bottom">
                      
                    <form action="{{ url('guardar_familiares') }}"  method="post" id="f_enviar_agregar_persona" class="" enctype="multipart/form-data">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="id_paciente" value="{{$id_paciente}}">
                      <br>
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
                                <label >Celular</label>
                                <input type="input" name="telefono_celular" placeholder="" class="form-control" value="{{ old('telefono_celular') }}" pattern="[0-9]{6,9}"/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label >Parentesco</label>
                                <input type="input" name="parentesco" placeholder="" class="form-control" value="{{ old('parentesco') }}"/>
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