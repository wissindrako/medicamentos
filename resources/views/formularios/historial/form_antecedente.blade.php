
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
                      
                    <form action="{{ url('guardar_antecedentes') }}"  method="post" id="" class="">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id_historial" value="{{$historia->id}}">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="fracturas" value="{{ old('fracturas', $antecedentes->fracturas ?? '') }}" {{isset($antecedentes->fracturas) ? 'checked' : ''}}>
                                    Fracturas
                                  </label>
                                </div>
                         
                              </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label >Descripción fracturas</label>
                                <input type="input" name="descripcion_fracturas" placeholder="" class="form-control" value="{{ old('descripcion_fracturas', $antecedentes->descripcion_fracturas ?? '') }}"/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="lesiones" value="{{ old('lesiones', $antecedentes->lesiones ?? '') }}" {{isset($antecedentes->lesiones) ? 'checked' : ''}}>
                                    Lesiones Graves
                                  </label>
                                </div>
                              </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label >Descripción lesiones</label>
                                <input type="input" name="descripcion_lesiones" placeholder="" class="form-control" value="{{ old('descripcion_lesiones', $antecedentes->descripcion_lesiones ?? '') }}"/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="hepatitis_b" value="{{ old('hepatitis_b', $antecedentes->hepatitis_b ?? '') }}" {{isset($antecedentes->hepatitis_b) ? 'checked' : ''}}>
                                    Pruebas Hepatitis B
                                  </label>
                                </div>
                              </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="hepatitis_c" value="{{ old('hepatitis_c', $antecedentes->hepatitis_c ?? '') }}" {{isset($antecedentes->hepatitis_c) ? 'checked' : ''}}>
                                    Pruebas Hepatitis C
                                  </label>
                                </div>
                              </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="vih" value="{{ old('vih', $antecedentes->vih ?? '') }}" {{isset($antecedentes->vih) ? 'checked' : ''}}>
                                    Pruebas VIH
                                  </label>
                                </div>
                              </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="fuma" value="{{ old('fuma', $antecedentes->fuma ?? '') }}" {{isset($antecedentes->fuma) ? 'checked' : ''}}>
                                    Fuma
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="drogas" value="{{ old('drogas', $antecedentes->drogas ?? '') }}" {{isset($antecedentes->drogas) ? 'checked' : ''}}>
                                    Consumo de Drogas
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="bebidas_alcoholicas" value="{{ old('bebidas_alcoholicas', $antecedentes->bebidas_alcoholicas ?? '') }}" {{isset($antecedentes->bebidas_alcoholicas) ? 'checked' : ''}}>
                                    Consumo de bebidas alcoholicas
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="trabajo" value="{{ old('trabajo', $antecedentes->trabajo ?? '') }}" {{isset($antecedentes->trabajo) ? 'checked' : ''}}>
                                    Trabaja
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="invalidez" value="{{ old('invalidez', $antecedentes->invalidez ?? '') }}" {{isset($antecedentes->invalidez) ? 'checked' : ''}}>
                                    Invalidez
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="artritis" value="{{ old('artritis', $antecedentes->artritis ?? '') }}" {{isset($antecedentes->artritis) ? 'checked' : ''}}>
                                    Artritis
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="lupus" value="{{ old('lupus', $antecedentes->lupus ?? '') }}" {{isset($antecedentes->lupus) ? 'checked' : ''}}>
                                    Lupus
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="fibromialgia" value="{{ old('fibromialgia', $antecedentes->fibromialgia ?? '') }}" {{isset($antecedentes->fibromialgia) ? 'checked' : ''}}>
                                    Fibromialgia
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="gota" value="{{ old('gota', $antecedentes->gota ?? '') }}" {{isset($antecedentes->gota) ? 'checked' : ''}}>
                                    Gota
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="osteoartritis" value="{{ old('osteoartritis', $antecedentes->osteoartritis ?? '') }}" {{isset($antecedentes->osteoartritis) ? 'checked' : ''}}>
                                    Osteoartritis
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="osteoporosis" value="{{ old('osteoporosis', $antecedentes->osteoporosis ?? '') }}" {{isset($antecedentes->osteoporosis) ? 'checked' : ''}}>
                                    Osteoporosis
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="diabetes" value="{{ old('diabetes', $antecedentes->diabetes ?? '') }}" {{isset($antecedentes->diabetes) ? 'checked' : ''}}>
                                    Diabetes
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="soriasis" value="{{ old('soriasis', $antecedentes->soriasis ?? '') }}" {{isset($antecedentes->soriasis) ? 'checked' : ''}}>
                                    Soriasis
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="crohns" value="{{ old('crohns', $antecedentes->crohns ?? '') }}" {{isset($antecedentes->crohns) ? 'checked' : ''}}>
                                    Enfermedad de Crohns
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="espondilitis" value="{{ old('espondilitis', $antecedentes->espondilitis ?? '') }}" {{isset($antecedentes->espondilitis) ? 'checked' : ''}}>
                                    Espondilitis
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="presion_sanguinea" value="{{ old('presion_sanguinea', $antecedentes->presion_sanguinea ?? '') }}" {{isset($antecedentes->presion_sanguinea) ? 'checked' : ''}}>
                                    Presión sanguínea
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="tuberculosis" value="{{ old('tuberculosis', $antecedentes->tuberculosis ?? '') }}" {{isset($antecedentes->tuberculosis) ? 'checked' : ''}}>
                                    Tuberculosis
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

