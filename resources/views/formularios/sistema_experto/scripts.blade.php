<script>
    // $( "#dato" ).keyup(function() {
        // activar_eventos();
    $("#div_diagnostico").hide();
    function consultar() {

        var dato = $("#dato").val();

        var dato_sin_espacios = dato.trim();
        if (dato_sin_espacios == "") {
            
        } else {
            
            $("#tabla_diagnostico tbody tr").remove();
            // $.getJSON("consultaRecintosPorRecinto/"+recinto+"",{},function(objetosretorna){
            $.getJSON("motorInferencia/"+dato_sin_espacios+"",{},function(objetosretorna){
                $("#div_diagnostico").show();
                
                $("#error").html("");
                var TamanoArray = objetosretorna.length;
                $.each(objetosretorna, function(i, datos){
                    var grado = "";
                    if (datos.grado == 0) {
                        grado = "<h4 class='text-green'><i class='icon fa fa-check'></i></h4>";
                    }if (datos.grado == 1) {
                        grado = "<h4 class='text-yellow'><i class='icon fa fa-warning'></i></h4>";
                    }
                    if (datos.grado == 2) {
                        grado = "<h4 class='text-red'><i class='icon fa fa-ban'></i></h4>";
                    }
                    var nuevaFila =
                    "<tr>"
                    +"<td>"+datos.premisa+"</td>"
                    +"<td>"+datos.resultado+"</td>"
                    +"<td>"+datos.conclusion+"</td>"
                    +"<td>"+grado+"</td>"
                    +"</tr>";
                    $(nuevaFila).appendTo("#tabla_diagnostico tbody");
                });
                if(TamanoArray==0){
                    var nuevaFila =
                    "<tr><td colspan=6>No se encontraron parametros para su busqueda</td>"
                    +"</tr>";
                    $(nuevaFila).appendTo("#tabla_diagnostico tbody");
                }
            });
        }
        
    }
	
	
</script>