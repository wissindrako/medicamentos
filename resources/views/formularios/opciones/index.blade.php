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
              <div class="col-sm-8 col-sm-offset-2 myform-cont" >

									@if(session()->has('mensaje_exito'))
										<div class="alert alert-success">
										{{ session()->get('mensaje_exito') }}
										</div>
									@endif
									@if(session()->has('mensaje_error'))
										<div class="alert alert-warning">
										{{ session()->get('mensaje_error') }}
										</div>
									@endif

                 <div class="myform-top">
                    <div class="myform-top-left">
                       {{-- <img  src="" class="img-responsive logo" /> --}}
                      <h3>Opciones</h3>
                        <p>Por favor pulse sobre la cada uno de los botones para llenar las diferentes opciones</p>
                    </div>
                    <div class="myform-top-right">
                      <i class="fa fa-edit"></i>
                    </div>
                  </div>

                  <div class="col-md-12" >
                    @if (count($errors) > 0)

                        <div class="alert alert-danger">
                            <strong>UPPS!</strong> Error al Registrar<br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>

                    @endif
                </div  >

								<div class="row">
									<div class="col-md-12">
										<div class="myform-bottom">
                                            <hr>
                                            <i class="fa fa-book margin-r-5"></i>
                                            <b>Paciente:</b>
                                            {{$persona[0]->nombre}} {{$persona[0]->paterno}} {{$persona[0]->materno}}
                                            <hr>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <a href="{{route('antecedentes_persona', ['id' => $persona[0]->id_persona])}}" class="myButton">Antecedentes</a>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <a href="{{route('enfermedades_persona', ['id' => $persona[0]->id_persona])}}" class="myButton">Enfermedades</a>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <a href="{{route('alergias_persona', ['id' => $persona[0]->id_persona])}}" class="myButton">Alergias</a>
                                            </div>
                                            <div class="col-md-6">
                                                <a href="#" class="myButton">Familiares</a>
                                            </div>
                                            <div class="col-md-12">
                                                <a href="#" class="myButton">Recetas</a>
                                            </div>
                                            
                                            &nbsp;&nbsp;&nbsp;
                                            

										</div>
									</div>
								</div>

              </div>
            </div>

        </div>
      </div>

</section>

</section>
@endsection
