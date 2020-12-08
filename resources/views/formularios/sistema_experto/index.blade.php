@extends('layouts.app')

@section('htmlheader_title')
	Diagnóstico
@endsection

@section('main-content')
<section  id="contenido_principal">
<section  id="content">

    <div class="" >
        <div class="container"> 
            <div class="row">
                @include('formularios.sistema_experto.datos')
                <!-- /.col -->

                <div class="col-md-9">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title"><b>Sistema Experto</b></h3>
                      <hr>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="">Medicamento</label>
                              
                              <select class="form-control input-lg select2" id="dato" style="width: 100%;">
                                <option selected="selected" disabled>Buscar</option>
                                @foreach ($medicamentos as $item)
                                <option>{{$item}}</option>
                                @endforeach
                              </select>
                            </div>
                            <!-- /.form-group -->
                            <div class="form-group">
                              <br>
                              <button onclick="consultar()" class="btn btn-primary pull-right btn-block btn-lg">Consultar</button>
                            </div>
                            <!-- /.form-group -->
                          </div>
                        </div>

                      <!-- /.box-tools -->
                    </div>
                    <div class="box-body" id="div_diagnostico">
                      <div class="box-header">
                          <h3 class="box-title"><b>Resultados</b></h3>
                      </div>
                      <div class="box-body table-responsive no-padding scrollable">
                          <table class="table table-bordered table-hover" id="tabla_diagnostico">
                              <thead>
                              <tr>
                                  <th>Premisa</th>
                                  <th>Resultado</th>
                                  <th>Conclusión</th>
                                  <th></th>
                              </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                      </div>
                    </div>

                  </div>
                  <!-- /. box -->
                </div>
                <!-- /.col -->
              </div>

        </div>
      </div>
 
</section>

</section>
@endsection

@section('scripts')
	
@parent

@include('formularios.sistema_experto.scripts')

@endsection