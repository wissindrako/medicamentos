
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
                          <h3>Agregar Antecedentes del Paciente</h3>
                            <p>Por favor llene los siguientes campos</p>
                        </div>
                        <div class="myform-top-right">
                          <i class="fa fa-user-md"></i>
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
                      
                    <form action="{{ url('guardar_medicamento') }}"  method="post" id="" class="">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label >Nombre del Medicamento</label>
                                <input type="input" name="nombre" class="form-control" value="{{ old('nombre') }}" required/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-black">Impacto</label>
                                <div class="form-group bg-gray">
                                    <select  class="form-control" name="impacto" required>
                                      @if(!old('impacto'))
                                        <option value="" selected> --- ELIJA UNA OPCION --- </option>
                                        @foreach ($impactos as $impacto)
                                            <option value={{$impacto}}>{{$impacto}}</option>                                                
                                        @endforeach
                                      @else
                                        <option value=""> --- ELIJA UNA OPCION --- </option>
                                        @foreach ($impactos as $impacto)
                                        <option value="{{$impacto}}" {{ old('impacto', $impacto) == $impacto ? 'selected' : '' }}>{{$impacto}}</option>
                                        @endforeach
                                      @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label >Resultado</label>
                                <input type="input" name="conclusion" class="form-control" value="{{ old('conclusion') }}" required/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label >Observaciones</label>
                                <textarea class="form-control" name="meta" rows="3" value="{{ old('meta') }}" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <br>
                        </div>
                        <button type="submit" class="mybtn">Guardar</button>
                      </form>
                    
                    </div>
              </div>
            </div>

        </div>
      </div>
 
</section>

</section>
@endsection

