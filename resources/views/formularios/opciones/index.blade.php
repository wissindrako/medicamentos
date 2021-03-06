@extends('layouts.app')

@section('htmlheader_title')
	Oociones Paciente
@endsection


@section('main-content')
<section  id="contenido_principal">
<section  id="content">

    <div class="" >
        <div class="container">
            <div class="row">
                @if($persona[0]->usuario->roles[0]->slug == 'paciente')
                @include('formularios.sistema_experto.datos')
                <div class="col-md-7" >
                @else
                <div class="col-sm-8 col-sm-offset-2 myform-cont" >
                @endif

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
                      <h3>Opciones</h3>
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
                            
                            @if($persona[0]->usuario->roles[0]->slug == 'super_admin' || $persona[0]->usuario->roles[0]->slug == 'medico')
                            <hr>
                            <div class="row">
                                    <i class="fa fa-book margin-r-5"></i><b>{{$persona[0]->usuario->roles[0]->description}}: </b>
                                    {{$persona[0]->nombre}} {{$persona[0]->paterno}} {{$persona[0]->materno}}
                                    @role('super_admin')
                                    <hr>
                                    <div class="box box-solid">
                                        <div class="box-header bg-primary">
                                            <h3 class="box-title">Pacientes</h3>
                                        </div>
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <th>Nombre</th>
                                                <th>Celular</th>
                                            </thead>
                                            <tbody>
                                                @forelse ($pacientes as $item)
                                                    <tr>
                                                        <td>{{$item->nombre}} {{$item->paterno}} {{$item->materno}}</td>
                                                        <td>{{$item->telefono_celular}}</td>
                                                    </tr>
                                                @empty
                                                    <tr><td colspan="2">No hay Pacientes asignados</td></tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    @endrole
                            </div>
                            @endif
                            <hr>
                            <div class="row">

                                @include('formularios.opciones.datos_personales')

                                @if($persona[0]->usuario->roles[0]->slug == 'paciente')
                                    @include('formularios.opciones.historial')
                                @endif

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
