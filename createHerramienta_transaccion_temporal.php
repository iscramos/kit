<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$clave = NULL;
$cantidad = NULL;
$codigo_asociado = NULL;
$aprobado = NULL;

/*echo "<pre>";
	print_r($_POST);
echo "</pre>";
die("He llegado");*/

if(isset($_POST["id"]) && intval($_POST["id"]) > 0)
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{

		// request data
		$id = $_POST["id"];
		$descripcion = $_POST["descripcion"];
		

		// new object
		$proveedores = new Herramientas_proveedores();
		$proveedores->id = $id;
		$proveedores->descripcion = $descripcion;
		$proveedores->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];
		$clave = $_POST["clave"];
		$cantidad = $_POST["cantidad"];
		$codigo_asociado = $_POST["codigo"];
		$aprobado = 0;
		

		// new object
		$temporal = new Herramientas_temporal();
		//$categoria->id = $id;
		$temporal->clave = $clave;
		$temporal->cantidad = $cantidad;
		$temporal->codigo_asociado = $codigo_asociado;
		
		
		$q = "SELECT * FROM herramientas_temporal WHERE codigo_asociado = $codigo_asociado AND clave = '$clave' ";
			$existe = Herramientas_temporal::getAllByQuery($q);

			if(count($existe) > 0)
			{
				$temporal->adicionar();
			}
			else
			{
				$temporal->save();
			}
		

		$q = "SELECT herramientas_temporal.*, herramientas_herramientas.descripcion AS descripcion
				FROM herramientas_temporal
					INNER JOIN herramientas_herramientas ON herramientas_temporal.clave = herramientas_herramientas.clave
						AND herramientas_temporal.codigo_asociado = $codigo_asociado";

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
}

//redirect_to('indexHerramientas_proveedores.php');

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
		$.post( 'deleteHerramienta_temporal.php', {codigo_asociado: codigo_asociado, clave: clave, tipo:tipo})
      	.done(function( data )
      	{

            $("#mensaje").text("Producto eliminado...");
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