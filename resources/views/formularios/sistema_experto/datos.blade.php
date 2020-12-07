<div class="col-md-3">
    {{-- <a href="compose.html" class="btn btn-primary btn-block margin-bottom">Compose</a> --}}
    <div class="box box-solid">
      <div class="box-header with-border bg-navy">
        <h3 class="box-title"><b>Datos Personales</b></h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <b><i class="fa fa-pencil margin-r-5"></i> {{$persona[0]->usuario->roles[0]->description}}:</b>

        <p class="text-muted">

          {{$paciente->nombre}} {{$paciente->paterno}} {{$paciente->materno}}

        </p>

        {{-- <hr> --}}

        <b><i class="fa fa-pencil margin-r-5"></i> Edad:</b>

        <p class="text-muted">{{$paciente->edad}}</p>

        {{-- <hr> --}}

        <b><i class="fa fa-pencil margin-r-5"></i> Sexo:</b>

        <p class="text-muted">{{$paciente->sexo}}</p>

      </div>
      <!-- /.box-body -->
    </div>
    <div class="box box-solid">
      <div class="box-header with-border bg-navy">
        <h3 class="box-title"><b>Médico de Cabecera</b></h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <b><i class="fa fa-user-md margin-r-5"></i> Médico:</b>

        <p class="text-muted">
          @if(isset($medico))
          {{$medico->nombre}} {{$medico->paterno}} {{$medico->materno}}
          @else
          No asignado aún!
          @endif
        </p>

      </div>
      <!-- /.box-body -->
    </div>

    <div class="box box-solid">
      <div class="box-header with-border bg-navy">
        <h3 class="box-title"><b>Historia Clínica</b></h3>

        <div class="box-tools">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="box-body">
          <b><i class="fa fa-circle-o margin-r-5"></i> Antecedentes:</b>

          <p class="text-muted">
            
            @forelse ($antecedentes as $item => $value)
                {{$item}}{{$value ? ' : '.$value.', ' : ', '}} 
            @empty
                No hay antecedentes registrados
            @endforelse

          </p>

          {{-- <hr> --}}

          <b><i class="fa fa-circle-o margin-r-5"></i> Falencias</b>
          <p class="text-muted">
            @forelse ($enfermedades as $item => $value)
                {{$item}}{{$value ? ' : '.$value.', ' : ', '}}
            @empty
                <p>No hay enfermedades registradas</p>
            @endforelse
          </p>
          {{-- <hr> --}}

          <b><i class="fa fa-circle-o margin-r-5"></i> Alergias</b>
          <p class="text-muted">
            @forelse ($alergias as $item)
                {{$item}}, 
            @empty
                <p>No hay alergias registradas</p>
            @endforelse
          </p>

          <b><i class="fa fa-circle-o margin-r-5"></i> Consumo de medicamentos</b>
          <p class="text-muted">
            @forelse ($recetas as $item)
                {{$item}}, 
            @empty
                <p>No consume ningún medicamento</p>
            @endforelse
          </p>

          <b><i class="fa fa-circle-o margin-r-5"></i> Familiares</b>

          
            @forelse ($familiares as $item)
              <p class="text-muted">
                {{$item->parentesco}}: {{$item->nombre}} {{$item->paterno}} {{$item->materno}} 
                Cel.: {{$item->telefono_celular}}
              </p>
            @empty
                <p>No tiene familiares registrados.</p>
            @endforelse
          
  
        </div>
      <!-- /.box-body -->
    </div>

  </div>