@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection

@section('main-content')

<section  id="contenido_principal">

<div class="box box-primary box-white">
     <div class="box-header">
        <h4 class="box-title">Usuarios</h4>	        


    </div>

<div class="box-body box-white">

    <div class="table-responsive" >

	    <table  class="table table-hover table-striped" cellspacing="0" width="100%">
			<thead>
				<tr>    
					<th>codigo</th>
					<th>Rol</th>
					<th>Nombre</th>
					<th>Carnet</th>
					<th>Usuario</th>
					<th>Pass</th>
					<th>Acción</th>
				</tr>
			</thead>
	    <tbody>

	    @foreach($usuarios as $usuario)
		<tr role="row" class="odd">
			<td>{{ $usuario->id }}</td>
			<td><span class="label label-default">
             
             @foreach($usuario->getRoles() as $roles)
			 {{  $roles.","  }}
             @endforeach
           
             -</span>
			</td>
			<td class="mailbox-messages mailbox-name"><a href="javascript:void(0);"  style="display:block"><i class="fa fa-user"></i>&nbsp;&nbsp;{{ $usuario->persona['nombre'] }} {{ $usuario->persona['paterno'] }} {{ $usuario->persona['materno'] }}</a></td>
			<td class="mailbox-messages mailbox-name"><a href="javascript:void(0);"  style="display:block"><i class="fa fa-credit-card"></i>&nbsp;&nbsp;{{ $usuario->persona['cedula_identidad'] }}</a></td>
			<td>{{ $usuario->name }}</td>
			<td>{{ $usuario->email }}</td>
			<td>
			<button type="button" class="btn  btn-default btn-xs" onclick="verinfo_usuario({{  $usuario->id }}, 1)" ><i class="fa fa-fw fa-edit"></i></button>
			{{-- <button type="button"  class="btn  btn-danger btn-xs"  onclick="borrado_usuario({{  $usuario->id }});"  ><i class="fa fa-fw fa-remove"></i></button> --}}
			</td>
		</tr>
	    @endforeach



		</tbody>
		</table>

	</div>
</div>




{{ $usuarios->links() }}

@if(count($usuarios)==0)


<div class="box box-primary col-xs-12">

<div class='aprobado' style="margin-top:70px; text-align: center">
 
<label style='color:#177F6B'>
              ... no se encontraron resultados para su busqueda...
</label> 

</div>

 </div> 


@endif

</div></section>
@endsection