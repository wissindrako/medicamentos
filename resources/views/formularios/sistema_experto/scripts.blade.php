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

                    var nuevaFila =
                    "<tr>"
                    +"<td>"+datos.premisa+"</td>"
                    +"<td>"+datos.conclusion+"</td>"
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