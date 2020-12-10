@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection


@section('main-content')
<section  id="contenido_principal">

<div class="box box-primary">
		<div class="box-header">
				<h3 class="box-title">Listado de Medicamentos</h3>
				<input type="hidden" id="rol_usuario" value="">
				@role('super_admin')
				<div class="box-tools">
                    <a href="{{route('form_agregar_medicamento')}}" class="btn btn-sm">
                        <i class="fa fa-fw fa-plus-circle"></i> Nuevo Registro
                    </a>
				</div>
				@endrole
			
		</div>
		<!-- /.box-header -->
		
		<div class="box-body table-responsive no-padding">
		  <table id="tabla_medicamentos" class="table table-striped table-hover hoverTableww">
			<thead>
				<th>Nombre</th>
				<th>Impacto</th>
				<th>Resultado</th>
				<th>Observaciones</th>
			
			</thead>
			<tbody>
				@foreach ($medicamentos as $item)
				
					<tr class='clickable-roww' data-href="{{route('opciones_persona', ['id' => $item->id_persona])}}">
						<td>{{$item->nombre}} </td>	
						<td>{{ $item->efectos}}</td>
						<td>{{ $item->conclusion}}</td>
						<td>{{ $item->meta}}</td>
						{{-- <td>
							<a href="{{route('opciones_persona', ['id' => $item->id_persona])}}" class="btn btn-primary btn-sm">
								<i class="fa fa-edit"></i>
							</a>
							@if($item->usuario->roles[0]->slug == 'paciente')
							@role('super_admin')
							<button type="button"  class="btn btn-danger btn-sm"  onclick="borrado_paciente({{  $item->id_persona }});"  ><i class="fa fa-fw fa-remove"></i></button>
							@endrole
							@role('medico')
							<button type="button"  class="btn btn-danger btn-sm"  onclick="borrado_paciente({{  $item->id_persona }});"  ><i class="fa fa-fw fa-remove"></i></button>
							@endrole
							@role('paciente')
							<button type="button" class="btn btn-danger btn-sm" disabled><i class="fa fa-fw fa-remove"></i></button>
							@endrole
							@else
							<button type="button" class="btn btn-danger btn-sm" disabled><i class="fa fa-fw fa-remove"></i></button>
							@endif
							
						</td> --}}
					</tr>
				
				@endforeach
			</tbody>

		</table>
			@if (count($medicamentos) == 0)
			<div class="box box-primary col-xs-12">
				<div class='aprobado' style="margin-top:70px; text-align: center">
				<label style='color:#177F6B'>
					... no se encontraron resultados para su busqueda...
				</label>
				</div>
			</div>
			@endif
		</div>
		<!-- /.box-body -->
	  </div>

</section>
@endsection

@section('scripts')

@parent

<script>

	$(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });

</script>



@endsection
