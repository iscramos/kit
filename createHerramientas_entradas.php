<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$clave = NULL;
$fechaEntrada = NULL;
$cantidad = NULL;

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
		$clave = $_POST["clave"];
		$fechaEntrada = date("Y-m-d");
		$cantidad = $_POST["cantidad"];
		

		// new object
		$entradas = new Herramientas_entradas();
		$entradas->id = $id;
		$entradas->clave = $clave;
		//$entradas->fechaEntrada = $fechaEntrada;
		$entradas->cantidad = $cantidad;
		$entradas->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];
		$clave = $_POST["clave"];
		$fechaEntrada = date("Y-m-d");
		$cantidad = $_POST["cantidad"];
		

		// new object
		$entradas = new Herramientas_entradas();
		//$entradas->id = $id;
		$entradas->clave = $clave;
		$entradas->fechaEntrada = $fechaEntrada;
		$entradas->cantidad = $cantidad;
		
		$herramientas_stock = Herramientas_stock::getByClave($clave);
		$stock = new Herramientas_stock();
		//echo $herramientas_stock->id;
		//echo count($herramientas_stock);
		if (count($herramientas_stock->clave) > 0) 
		{
			$stock->clave = $clave;
			$stock->stock = $cantidad;
			$stock->update();
			//die("entro actualizar");
		}
		else
		{
			$stock->clave = $clave;
			$stock->stock = $cantidad;
			$stock->insert();
			//die("entro insert");
		}

		$entradas->save();
		
	}
}

redirect_to('indexHerramientas_entradas.php');

?>