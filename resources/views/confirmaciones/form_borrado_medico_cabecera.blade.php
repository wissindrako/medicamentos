<div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border my-box-header">
              <h3 class="box-title">Borrar Usuario</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class=" box-body">
            @role('super_admin')
            <h3>¿ Deseas quitar el Medico asignado al paciente {{ $paciente->nombre }} {{ $paciente->paterno }} {{ $paciente->materno }} de su lista ?</h3>
            @endrole
            @role('medico')
            <h3>¿ Deseas quitar al paciente {{ $paciente->nombre }} {{ $paciente->paterno }} {{ $paciente->materno }} de tu lista ?</h3>
            @endrole
            </div>
         
              <div class="box-footer">

              <form method="post" action="{{ url('borrar_medico_cabecera') }}" id="f_borrar_usuario" class="formentrada" >

               <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="id_persona" value="{{ $paciente->id_persona }}">

                <button type="button" class="btn btn-default" onclick="javascript:$('.div_modal').click();" >Cancelar</button>
                <button type="submit" class="btn btn-danger" style="margin-left:20px;" >Quitar</button> </form>
              </div>


          </div>
          <!-- /.box -->

         

       

        </div>