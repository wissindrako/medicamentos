
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
                          <h3>Agregar Alergias del Paciente</h3>
                            <p>Por favor selecciones las opciones si es el caso</p>
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
                      
                    <form action="{{ url('guardar_alergias') }}"  method="post" id="" class="">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id_historial" value="{{$historia->id}}">
                        <div class="col-md-12">
                          <div class="form-group">
                            <br>
                            <label>Alergias del paciente</label>
                            <select class="form-control select2" multiple="multiple" name="alergias[]" data-placeholder="Buscar"
                                    style="width: 100%;">
                                    @foreach ($medicamentos as $item)
                                        {{-- <option value={{$item->nombre}}>{{$item->nombre}}</option>    --}}
                                        <option
                                        value="{{$item}}"
                                        {{is_array(old('alergias')) ? (in_array($item, old('alergias')) ? 'selected' : '')  : (isset($alergias) ? (in_array($item, $alergias) ? 'selected' : '') : '')}}
                                        >
                                        {{$item}}
                                        </option>                                             
                                    @endforeach
                            </select>
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

