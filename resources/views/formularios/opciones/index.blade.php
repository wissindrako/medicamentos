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
                        @role('super_admin')
                        <a href="{{route('listado_personas')}}" class="">
                            <i class="fa fa-th" style="color:white"></i>
                          </a>
                        @endrole
                        @role('medico')
                        <a href="{{route('listado_personas')}}" class="">
                            <i class="fa fa-th" style="color:white"></i>
                          </a>
                        @endrole
                        @role('paciente')
                        <i class="fa fa-edit"></i>
                        @endrole

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
                            
                            <div class="row">
                                <div class="col-md-2">
                                    <i class="fa fa-book margin-r-5"></i><b>Paciente</b>
                                </div>
                                <div class="col-md-1"><b>:</b></div>
                                <div class="col-md-8">
                                    {{$persona[0]->nombre}} {{$persona[0]->paterno}} {{$persona[0]->materno}}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <a href="{{route('form_editar_persona', ['id' => $persona[0]->id_persona])}}" class="small-box-footer">
                                    <div class="col-md-12 col-lg-6 col-xs-12">
                                        <!-- small box -->
                                        <div class="small-box bg-primary">
                                        <div class="inner">
                                            <h2><b>Datos Personales</b></h2>
                                            <br>
                                            {{-- <p>User Registrations</p> --}}
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <br>
                                        {{-- href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i> --}}
                                        </div>
                                    </div>
                                </a>
                                <a href="{{route('antecedentes_persona', ['id' => $persona[0]->id_persona])}}" class="small-box-footer">
                                    <div class="col-md-12 col-lg-6 col-xs-12">
                                        <!-- small box -->
                                        <div class="small-box bg-aqua">
                                        <div class="inner">
                                            <h2><b>Antecedentes</b></h2>
                                            <br>
                                            {{-- <p>User Registrations</p> --}}
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-ambulance"></i>
                                        </div>
                                        <br>
                                        {{-- href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i> --}}
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="row">
                                <a href="{{route('enfermedades_persona', ['id' => $persona[0]->id_persona])}}" class="small-box-footer">
                                    <div class="col-md-12 col-lg-6 col-xs-12">
                                        <!-- small box -->
                                        <div class="small-box bg-red">
                                        <div class="inner">
                                            <h2><b>Enfermedades</b></h2>
                                            <br>
                                            {{-- <p>User Registrations</p> --}}
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-heartbeat"></i>
                                        </div>
                                        <br>
                                        {{-- href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i> --}}
                                        </div>
                                    </div>
                                </a>
                                <a href="{{route('alergias_persona', ['id' => $persona[0]->id_persona])}}" class="small-box-footer">
                                    <div class="col-md-12 col-lg-6 col-xs-12">
                                        <!-- small box -->
                                        <div class="small-box bg-yellow">
                                        <div class="inner">
                                            <h2><b>Alergias</b></h2>
                                            <br>
                                            {{-- <p>User Registrations</p> --}}
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-medkit"></i>
                                        </div>
                                        <br>
                                        {{-- href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i> --}}
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="row">
                                <a href="{{route('familiares_persona', ['id' => $persona[0]->id_persona])}}" class="small-box-footer">
                                    <div class="col-md-12 col-lg-6 col-xs-12">
                                        <!-- small box -->
                                        <div class="small-box bg-green">
                                        <div class="inner">
                                            <h2><b>Familiares</b></h2>
                                            <br>
                                            {{-- <p>User Registrations</p> --}}
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <br>
                                        {{-- href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i> --}}
                                        </div>
                                    </div>
                                </a>
                                <a href="{{route('recetas_persona', ['id' => $persona[0]->id_persona])}}" class="small-box-footer">
                                    <div class="col-md-12 col-lg-6 col-xs-12">
                                        <!-- small box -->
                                        <div class="small-box bg-purple">
                                        <div class="inner">
                                            <h2><b>Recetas</b></h2>
                                            <br>
                                            {{-- <p>User Registrations</p> --}}
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-list-alt"></i>
                                        </div>
                                        <br>
                                        {{-- href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i> --}}
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="row">
                                <a href="{{route('experto', ['id' => $persona[0]->id_persona])}}" class="small-box-footer">
                                    <div class="col-md-12 col-lg-12 col-xs-12">
                                        <!-- small box -->
                                        <div class="small-box bg-maroon">
                                        <div class="inner">
                                            <h2><b>Sistema Experto</b></h2>
                                            <br>
                                            {{-- <p>User Registrations</p> --}}
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-desktop"></i>
                                        </div>
                                        <br>
                                        {{-- href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i> --}}
                                        </div>
                                    </div>
                                </a>
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
