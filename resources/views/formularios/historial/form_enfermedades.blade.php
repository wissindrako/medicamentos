
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
                          <h3>Agregar Enfermedades del Paciente</h3>
                            <p>Por favor seleccione las opciones si es caso</p>
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
                      
                    <form action="{{ url('guardar_enfermedades') }}"  method="post" id="" class="">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id_historial" value="{{$historia->id}}">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="lumbalgia" value="{{ old('lumbalgia', $enfermedades->lumbalgia ?? '') }}" {{isset($enfermedades->lumbalgia) ? 'checked' : ''}}>
                                    Lumbalgia
                                  </label>
                                </div>
                         
                              </div>
                        </div>
                        {{-- <div class="col-md-12">
                            <div class="form-group">
                                <label >Descripción fracturas</label>
                                <input type="input" name="descripcion_fracturas" placeholder="" class="form-control" value="{{ old('descripcion_fracturas', $enfermedades->descripcion_fracturas ?? '') }}"/>
                            </div>
                        </div> --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="reflujo_gastroesofagico" value="{{ old('reflujo_gastroesofagico', $enfermedades->reflujo_gastroesofagico ?? '') }}" {{isset($enfermedades->reflujo_gastroesofagico) ? 'checked' : ''}}>
                                    Reflujo gastroesofágico
                                  </label>
                                </div>
                              </div>
                        </div>
                        {{-- <div class="col-md-12">
                            <div class="form-group">
                                <label >Descripción lesiones</label>
                                <input type="input" name="descripcion_lesiones" placeholder="" class="form-control" value="{{ old('descripcion_lesiones', $enfermedades->descripcion_lesiones ?? '') }}"/>
                            </div>
                        </div> --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="faringoamigdalitis" value="{{ old('faringoamigdalitis', $enfermedades->faringoamigdalitis ?? '') }}" {{isset($enfermedades->faringoamigdalitis) ? 'checked' : ''}}>
                                    Faringoamigdalitis
                                  </label>
                                </div>
                              </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="hipertension_arterial" value="{{ old('hipertension_arterial', $enfermedades->hipertension_arterial ?? '') }}" {{isset($enfermedades->hipertension_arterial) ? 'checked' : ''}}>
                                    Hipertensión arterial
                                  </label>
                                </div>
                              </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="artritis" value="{{ old('artritis', $enfermedades->artritis ?? '') }}" {{isset($enfermedades->artritis) ? 'checked' : ''}}>
                                    Artritis
                                  </label>
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

