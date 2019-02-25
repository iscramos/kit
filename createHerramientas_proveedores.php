<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$descripcion = NULL;

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
		$descripcion = $_POST["descripcion"];
		

		// new object
		$proveedores = new Herramientas_proveedores();
		//$categoria->id = $id;
		$proveedores->descripcion = $descripcion;
		$proveedores->save();
	}
}

redirect_to('indexHerramientas_proveedores.php');

?>