<?php

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

// Check the querystring for a numeric id
if (isset($_REQUEST['codigo_asociado']) && intval($_REQUEST['codigo_asociado']) != "") 
{
	
	// Get id from querystring
	$tipo = $_REQUEST['tipo'];

	if($tipo == "UNITARIO")
	{
		$codigo_asociado = $_REQUEST['codigo_asociado'];
		$clave = $_REQUEST['clave'];
		
		// Execute database query
		$temporal = new Herramientas_temporal();
		$temporal->codigo_asociado = $codigo_asociado;
		$temporal->clave = $clave;

		$temporal->delete();
	}
	else if($tipo == "TODO")
	{
		$codigo_asociado = $_REQUEST['codigo_asociado'];
		
		// Execute database query
		$temporal = new Herramientas_temporal();
		$temporal->codigo_asociado = $codigo_asociado;

		$temporal->deleteAll();
	}
		

	$q = "SELECT herramientas_temporal.*, herramientas_herramientas.descripcion AS descripcion
				FROM herramientas_temporal
					INNER JOIN herramientas_herramientas ON herramientas_temporal.clave = herramientas_herramientas.clave
						AND herramientas_temporal.codigo_asociado = $codigo_asociado";
//echo $q;
	$transacciones = Herramientas_temporal::getAllByQuery($q);

	$str = "";
	foreach ($transacciones as $t) 
	{
	 	$str.="<tr>";
	 		$str.="<td>".$t->clave."</td>";
			$str.="<td>".$t->descripcion."</td>";
			$str.="<td>".$t->cantidad."</td>";
			$str.="<td><button class='btn btn-danger btn-sm eliminar_articulo' t='".$t->codigo_asociado."' c='".$t->clave."'>Eliminar</button></td>";
			
	 	$str.="</tr>";
	}

	echo $str;
}



// Redirect to site root
//redirect_to('indexHerramientas_prestamos.php?id_herramienta='.$id_herramienta);
?>

<script type="text/javascript">
	$('.eliminar_articulo').on('click', function(e)
	{
		var codigo_asociado = null;
		var clave = null;
			codigo_asociado = $(this).attr("t"); 
			clave = $(this).attr("c"); 
			$("#mensaje").html(null);
			tipo = "UNITARIO";

        $.post( 'deleteHerramienta_temporal.php', {codigo_asociado: codigo_asociado, clave: clave, tipo: tipo})
      	.done(function( data )
      	{

            $("#mensaje").text("Artículo eliminado...");
            $("#mensaje").removeClass();
            $("#mensaje").addClass('alert alert-danger');
            $("#mensaje").alert();
            $("#mensaje").fadeTo(1000, 700).slideUp(700, function(){
            $("#mensaje").slideUp(1000);
            });

            $("#articulos_ingresados").html(data);
      	});
	});
</script>