<div class="col-md-12">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border my-box-header">
        <h3 class="box-title">Borrar Usuario</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <div class=" box-body">

      <h3>¿ Deseas Borrar Completamente al Usuario {{ $persona->nombre }} {{ $persona->paterno }} {{ $persona->materno }} ?</h3>

      </div>
   
        <div class="box-footer">

        <form method="post" action="{{ url('eliminar_paciente_medico') }}" id="f_borrar_usuario" class="formentrada" >

         <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
          <input type="hidden" name="id_persona" value="{{ $persona->id_persona }}">

          <button type="button" class="btn btn-default" onclick="javascript:$('.div_modal').click();" >Cancelar</button>
          <button type="submit" class="btn btn-danger" style="margin-left:20px;" >Borrar Usuario</button> </form>
        </div>

    </div>
    <!-- /.box -->

   

 

  </div>