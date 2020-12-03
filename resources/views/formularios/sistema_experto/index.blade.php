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
                        <div class="form-group margin-bottom-none">
                          <div class="col-sm-12">
                            <label for="">Medicamento</label>
                            <input class="form-control input-lg" id="dato" placeholder="Response">
                          </div>
                          <div class="col-sm-12">
                            <button onclick="consultar()" class="btn btn-info pull-right btn-block btn-lg">Send</button>
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
                                  <th>Conclusión</th>
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