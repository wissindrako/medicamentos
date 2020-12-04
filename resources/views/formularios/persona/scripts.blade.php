
@section('scripts')
	
@parent
<script>
	function activar_eventos() {

    // Ocultando Divs al iniciar
    if ($("#institucion").val() != "") {
        $("#div_institucion").show();
        document.getElementById("institucion").required = true;
    }else{
        $("#div_institucion").hide();
        document.getElementById("institucion").required = false;
    }

    if ($("#especialidad").val() != "") {
        $("#div_especialidad").show();
        document.getElementById("especialidad").required = true;
    } else {
        $("#div_especialidad").hide();
        document.getElementById("especialidad").required = false;
    }

    if ($("#medico").val() != "") {
        $("#div_medico").show();
        document.getElementById("medico").required = true;
    } else {
        $("#div_medico").hide();
        document.getElementById("medico").required = false;
    }

    $("#rol_slug").change(function(){

        //id obtenido de la base de datos "campo : slug"
        var rol_slug = $("#rol_slug").val();
        // alertify.success(rol_slug);
        if (rol_slug == '3') { //medico
            $("#div_institucion").show();
            $("#div_especialidad").show();
            $("#div_medico").hide();
            document.getElementById("medico").value = "";

            document.getElementById("institucion").required = true;
            document.getElementById("especialidad").required = true;
            document.getElementById("medico").required = false;

        }else if(rol_slug == '1'){ //Administrador
            $("#div_institucion").hide();
            document.getElementById("institucion").value = "";
            $("#div_especialidad").hide();
            document.getElementById("especialidad").value = "";
            $("#div_medico").hide();
            document.getElementById("medico").value = "";

            document.getElementById("institucion").required = false;
            document.getElementById("especialidad").required = false;
            document.getElementById("medico").required = false;


        }else{
            $("#div_institucion").hide();
            document.getElementById("institucion").value = "";
            $("#div_especialidad").hide();
            document.getElementById("especialidad").value = "";
            $("#div_medico").show();

            document.getElementById("institucion").required = false;
            document.getElementById("especialidad").required = false;
            document.getElementById("medico").required = true;

        }
    });
  


    
	
	}	
	activar_eventos();
	
	
	</script>
@endsection